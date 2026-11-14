<?php

namespace App\Http\Controllers;

use App\Models\Wali;
use App\Models\Tagihan;
use App\Models\DetailTagihan;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\RekeningPondok;

class WaliPembayaranController extends Controller
{
    public function create($id)
    {
        $wali = Wali::where('user_id', auth()->id())
            ->firstOrFail();

        $tagihan = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan'
        ])->findOrFail($id);

        // Pastikan tagihan milik santri yang terhubung
        // dengan wali yang sedang login.
        $santriIds = $wali->santri()
            ->pluck('id');

        if (!$santriIds->contains($tagihan->santri_id)) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }

        // Hanya komponen yang masih memiliki sisa
        // yang dapat dibayar.
        $detailTagihan = $tagihan->detailTagihan
            ->filter(function ($detail) {
                return $detail->hitungSisa() > 0;
            })
            ->values();

        $rekeningPondok = RekeningPondok::where(
                'is_active',
                true
            )
            ->orderBy('bank')
            ->get();

        return view(
            'wali.pembayaran.create',
            compact(
                'wali',
                'tagihan',
                'detailTagihan',
                'rekeningPondok'
            )
        );
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'metode' => [
                'required',
                'in:offline,transfer'
            ],

            'detail_id' => [
                'required',
                'array',
                'min:1'
            ],

            'detail_id.*' => [
                'integer',
                'exists:detail_tagihan,id'
            ],

            'nominal' => [
                'required',
                'array'
            ],

            'bukti_pembayaran' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
        ]);

        if (
            $request->metode === 'transfer'
            && !$request->hasFile('bukti_pembayaran')
        ) {
            throw ValidationException::withMessages([
                'bukti_pembayaran' =>
                    'Bukti pembayaran wajib diunggah untuk pembayaran transfer.'
            ]);
        }

        $wali = Wali::where('user_id', auth()->id())
            ->firstOrFail();

        $tagihan = Tagihan::with([
            'santri',
            'detailTagihan'
        ])->findOrFail($id);

        // Keamanan: pastikan tagihan milik wali.
        $santriIds = $wali->santri()
            ->pluck('id');

        if (!$santriIds->contains($tagihan->santri_id)) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }

        $detailPembayaran = [];
        $nominalTagihan = 0;
        $totalTransfer = 0;

        foreach ($request->detail_id as $detailId) {

            $detail = DetailTagihan::findOrFail($detailId);

            // Detail harus berasal dari tagihan yang sedang dibayar.
            if ($detail->tagihan_id !== $tagihan->id) {
                abort(403, 'Detail tagihan tidak sesuai.');
            }

            $nominal = (float) (
                $request->input("nominal.$detailId") ?? 0
            );

            if (!$detail->bisaDibayar($nominal)) {
                throw ValidationException::withMessages([
                    'nominal' =>
                        'Nominal pembayaran untuk ' .
                        ($detail->jenisTagihan->nama ?? 'tagihan') .
                        ' tidak valid.'
                ]);
            }

            $detailPembayaran[] = [
                'detail_tagihan_id' => $detail->id,
                'nominal_dibayar' => $nominal,
            ];

            $nominalTagihan += (float) $detail->nominal;
            $totalTransfer += $nominal;
        }

        if ($totalTransfer <= 0) {
            throw ValidationException::withMessages([
                'nominal' => 'Total pembayaran harus lebih dari Rp0.'
            ]);
        }

        // Buat kode transaksi yang unik.
        do {
            $kodeTransaksi =
                'TRX-' .
                now()->format('YmdHis') .
                '-' .
                Str::upper(Str::random(4));
        } while (
            Pembayaran::where(
                'kode_transaksi',
                $kodeTransaksi
            )->exists()
        );

        return DB::transaction(function () use (
            $request,
            $kodeTransaksi,
            $nominalTagihan,
            $totalTransfer,
            $detailPembayaran,
            $tagihan
        ) {

            $bukti = null;

            if ($request->hasFile('bukti_pembayaran')) {
                $bukti = $request
                    ->file('bukti_pembayaran')
                    ->store(
                        'bukti-pembayaran',
                        'public'
                    );
            }

            $pembayaran = Pembayaran::create([
                'kode_transaksi' => $kodeTransaksi,
                'metode' => $request->metode,
                'nominal_tagihan' => $nominalTagihan,
                'total_transfer' => $totalTransfer,
                'tanggal_bayar' => now(),
                'bukti_pembayaran' => $bukti,
                'status' => 'menunggu_verifikasi',
            ]);

            foreach ($detailPembayaran as $item) {

                DetailPembayaran::create([
                    'pembayaran_id' => $pembayaran->id,
                    'detail_tagihan_id' => $item['detail_tagihan_id'],
                    'nominal_dibayar' => $item['nominal_dibayar'],
                ]);

            }

            return redirect()->route(
                'wali.pembayaran.konfirmasi',
                $pembayaran->id
            );
        });
    }

    public function show($id)
    {
        $wali = Wali::where('user_id', auth()->id())
            ->firstOrFail();

        $pembayaran = Pembayaran::with([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri'
        ])->findOrFail($id);

        $santriIds = $wali->santri()
            ->pluck('id');

        $milikWali = $pembayaran->detailPembayaran
            ->contains(function ($detail) use ($santriIds) {

                return $detail->detailTagihan
                    && $santriIds->contains(
                        $detail->detailTagihan->tagihan->santri_id
                    );
            });

        if (!$milikWali) {
            abort(403, 'Anda tidak memiliki akses ke pembayaran ini.');
        }

        return view(
            'wali.pembayaran.show',
            compact('pembayaran')
        );
    }

    public function riwayat()
    {
        $wali = Wali::where('user_id', auth()->id())
            ->firstOrFail();

        $santriIds = $wali->santri()
            ->pluck('id');

        $pembayaran = Pembayaran::with([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri'
        ])
        ->whereHas(
            'detailPembayaran.detailTagihan.tagihan',
            function ($query) use ($santriIds) {
                $query->whereIn('santri_id', $santriIds);
            }
        )
        ->orderByDesc('tanggal_bayar')
        ->paginate(10);

        return view(
            'wali.pembayaran.riwayat',
            compact('pembayaran')
        );
    }
}