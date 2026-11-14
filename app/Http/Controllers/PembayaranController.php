<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\RekeningPondok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::query()
            ->orderByDesc('tanggal_bayar');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->paginate(10);

        return view('admin.pembayaran.index', compact(
            'pembayaran'
        ));
    }

    public function createOffline(Request $request)
    {
        $search = trim($request->search ?? '');

        $santriHasil = collect();
        $santriTerpilih = null;
        $tagihan = collect();

        /*
        * Cari santri berdasarkan:
        * - Nama
        * - NIS
        */
        if ($search !== '') {

            $santriHasil = \App\Models\Santri::with('wali')
                ->where(function ($query) use ($search) {

                    $query->where(
                        'nama',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'nis',
                        'like',
                        '%' . $search . '%'
                    );

                })
                ->orderBy('nama')
                ->limit(10)
                ->get();
        }


        /*
        * Kalau admin sudah memilih santri,
        * tampilkan seluruh tagihan yang belum lunas.
        */
        if ($request->filled('santri_id')) {

            $santriTerpilih = \App\Models\Santri::findOrFail(
                $request->santri_id
            );

            $tagihan = $santriTerpilih
                ->tagihan()
                ->with([
                    'detailTagihan.jenisTagihan'
                ])
                ->where('status', '!=', 'lunas')
                ->orderBy('periode_tahun')
                ->orderBy('periode_bulan')
                ->get();
        }


        return view(
            'admin.pembayaran.create-offline',
            compact(
                'search',
                'santriHasil',
                'santriTerpilih',
                'tagihan'
            )
        );
    }

    public function storeOffline(Request $request)
    {
        $request->validate([
            'detail_id' => [
                'required',
                'array',
                'min:1'
            ],

            'detail_id.*' => [
                'integer',
                'distinct',
                'exists:detail_tagihan,id'
            ],

            'nominal' => [
                'required',
                'array'
            ],

            'nominal.*' => [
                'nullable',
                'numeric',
                'min:0'
            ],
        ]);


        $detailPembayaran = [];
        $nominalTagihan = 0;
        $totalBayar = 0;


        foreach ($request->detail_id as $detailId) {

            $detail = \App\Models\DetailTagihan::with([
                'jenisTagihan',
                'tagihan'
            ])->findOrFail($detailId);


            $nominal = (float) (
                $request->input("nominal.$detailId") ?? 0
            );


            /*
            * Pastikan nominal benar-benar boleh dibayar.
            * Server tetap menjadi pengaman utama.
            */
            if (!$detail->bisaDibayar($nominal)) {

                return back()
                    ->withErrors([
                        'nominal' =>
                            'Nominal pembayaran untuk ' .
                            ($detail->jenisTagihan->nama ?? 'tagihan') .
                            ' tidak valid.'
                    ])
                    ->withInput();

            }


            $detailPembayaran[] = [
                'detail_tagihan_id' => $detail->id,
                'nominal_dibayar' => $nominal,
            ];


            /*
            * Nominal tagihan = total nilai komponen
            * yang sedang dibayarkan.
            */
            $nominalTagihan += (float) $detail->nominal;

            /*
            * Total bayar = jumlah uang yang benar-benar
            * dibayarkan pada transaksi ini.
            */
            $totalBayar += $nominal;

        }


        if ($totalBayar <= 0) {

            return back()
                ->withErrors([
                    'nominal' =>
                        'Total pembayaran harus lebih dari Rp0.'
                ])
                ->withInput();

        }


        /*
        * Satu transaksi untuk beberapa bulan / komponen.
        */
        do {

            $kodeTransaksi =
                'OFF-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(
                    \Illuminate\Support\Str::random(4)
                );

        } while (
            Pembayaran::where(
                'kode_transaksi',
                $kodeTransaksi
            )->exists()
        );


        DB::transaction(function () use (
            $detailPembayaran,
            $nominalTagihan,
            $totalBayar,
            $kodeTransaksi
        ) {

            $pembayaran = Pembayaran::create([

                'kode_transaksi' => $kodeTransaksi,

                'metode' => 'offline',

                'nominal_tagihan' => $nominalTagihan,

                'total_transfer' => $totalBayar,

                'tanggal_bayar' => now(),

                'bukti_pembayaran' => null,

                /*
                * Offline langsung diterima karena
                * admin menerima uang secara langsung.
                */
                'status' => 'diterima',

                'diverifikasi_oleh' => auth()->id(),

                'diverifikasi_at' => now(),

                'alasan_penolakan' => null,

            ]);


            foreach ($detailPembayaran as $item) {

                \App\Models\DetailPembayaran::create([

                    'pembayaran_id' =>
                        $pembayaran->id,

                    'detail_tagihan_id' =>
                        $item['detail_tagihan_id'],

                    'nominal_dibayar' =>
                        $item['nominal_dibayar'],

                ]);

            }


            /*
            * Sinkronkan status setiap detail dan
            * setiap tagihan yang terkena transaksi.
            */
            foreach ($pembayaran->detailPembayaran as $detail) {

                $detail->sinkronkanStatus();

            }

        });


        return redirect()
            ->route('admin.pembayaran.index')
            ->with(
                'success',
                'Pembayaran offline berhasil dicatat untuk beberapa tagihan dan langsung diterima.'
            );
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri'
        ])->findOrFail($id);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function terima($id)
    {
        $pembayaran = Pembayaran::with(
            'detailPembayaran'
        )->findOrFail($id);

        if ($pembayaran->status !== 'menunggu_verifikasi') {
            return redirect()
                ->route('admin.pembayaran.show', $id)
                ->with(
                    'error',
                    'Pembayaran ini sudah tidak menunggu verifikasi.'
                );
        }

        if ($pembayaran->cekKesesuaianNominal() !== 'sesuai') {
            return redirect()
                ->route('admin.pembayaran.show', $id)
                ->with(
                    'error',
                    'Total rincian pembayaran tidak sesuai dengan total transfer.'
                );
        }

        DB::transaction(function () use ($pembayaran) {

            $pembayaran->update([
                'status' => 'diterima',
                'diverifikasi_oleh' => auth()->id(),
                'diverifikasi_at' => now(),
                'alasan_penolakan' => null,
            ]);

            foreach (
                $pembayaran->detailPembayaran
                as $detailPembayaran
            ) {

                $detailPembayaran->sinkronkanStatus();

            }

        });

        return redirect()
            ->route('admin.pembayaran.show', $id)
            ->with(
                'success',
                'Pembayaran berhasil diterima dan status tagihan telah diperbarui.'
            );
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $id) {

            $pembayaran = Pembayaran::findOrFail($id);

            // Hanya pembayaran yang masih menunggu verifikasi
            // yang boleh ditolak.
            if ($pembayaran->status !== 'menunggu_verifikasi') {
                return;
            }

            // Ubah status pembayaran menjadi ditolak
            $pembayaran->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
                'diverifikasi_oleh' => auth()->id(),
                'diverifikasi_at' => now(),
            ]);

            // Sinkronkan kembali status seluruh detail tagihan
            foreach ($pembayaran->detailPembayaran as $detailPembayaran) {
                $detailPembayaran->sinkronkanStatus();
            }
        });

        return redirect()
            ->route('admin.pembayaran.show', $id)
            ->with(
                'success',
                'Pembayaran berhasil ditolak dan status tagihan telah diperbarui.'
            );
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::with([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri',
        ])->findOrFail($id);

        $user = auth()->user();

        // Wali hanya boleh melihat transaksi milik santrinya sendiri
        if ($user->role === 'wali') {

            $wali = $user->wali;

            $santriIds = $wali
                ? $wali->santri()->pluck('id')
                : collect();

            $bolehAkses = $pembayaran
                ->detailPembayaran
                ->contains(function ($detail) use ($santriIds) {

                    $santriId =
                        $detail
                            ->detailTagihan
                            ->tagihan
                            ->santri_id;

                    return $santriIds->contains($santriId);
                });

            abort_unless($bolehAkses, 403);
        }

        return view(
            'wali.pembayaran.konfirmasi',
            compact('pembayaran')
        );
    }
}