<?php

namespace App\Http\Controllers;

use App\Models\DetailTagihan;
use App\Models\JenisTagihan;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\TarifTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanKhususController extends Controller
{
    public function create()
    {
        $jenisTagihan = JenisTagihan::where('is_active', true)
            ->where('is_bulanan', false)
            ->orderBy('nama')
            ->get();

        $santri = Santri::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $kelas = Santri::where('status', 'aktif')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view(
            'admin.tagihan-khusus.create',
            compact(
                'jenisTagihan',
                'santri',
                'kelas'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tagihan_id' => [
                'required',
                'exists:jenis_tagihan,id',
            ],

            'tanggal_kegiatan' => [
                'required',
                'date',
            ],

            'target' => [
                'required',
                'in:semua,kelas,santri',
            ],

            'kelas' => [
                'nullable',
                'required_if:target,kelas',
                'string',
                'max:100',
            ],

            'santri_id' => [
                'nullable',
                'required_if:target,santri',
                'array',
                'min:1',
            ],

            'santri_id.*' => [
                'integer',
                'distinct',
                'exists:santri,id',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $jenisTagihan = JenisTagihan::where('id', $request->jenis_tagihan_id)
            ->where('is_active', true)
            ->where('is_bulanan', false)
            ->firstOrFail();

        $tanggalKegiatan = Carbon::parse(
            $request->tanggal_kegiatan
        );

        /*
         * Cari tarif yang berlaku pada tanggal kegiatan.
         */
        $tarif = TarifTagihan::where(
            'jenis_tagihan_id',
            $jenisTagihan->id
        )
            ->whereDate(
                'berlaku_mulai',
                '<=',
                $tanggalKegiatan
            )
            ->where(function ($query) use ($tanggalKegiatan) {
                $query->whereNull('berlaku_sampai')
                    ->orWhereDate(
                        'berlaku_sampai',
                        '>=',
                        $tanggalKegiatan
                    );
            })
            ->orderByDesc('berlaku_mulai')
            ->first();

        if (!$tarif) {
            return back()
                ->withErrors([
                    'jenis_tagihan_id' =>
                        'Belum ada tarif yang berlaku untuk jenis tagihan tersebut pada tanggal kegiatan.'
                ])
                ->withInput();
        }

        /*
         * Tentukan santri penerima.
         */
        if ($request->target === 'semua') {

            $santriList = Santri::where('status', 'aktif')
                ->orderBy('id')
                ->get();

        } elseif ($request->target === 'kelas') {

            $santriList = Santri::where('status', 'aktif')
                ->where('kelas', $request->kelas)
                ->orderBy('id')
                ->get();

        } else {

            $santriList = Santri::where('status', 'aktif')
                ->whereIn('id', $request->santri_id)
                ->orderBy('id')
                ->get();
        }

        if ($santriList->isEmpty()) {
            return back()
                ->withErrors([
                    'target' =>
                        'Tidak ada santri yang menjadi penerima tagihan.'
                ])
                ->withInput();
        }

        $dibuat = 0;
        $dilewati = 0;

        DB::transaction(function () use (
            $santriList,
            $jenisTagihan,
            $tarif,
            $tanggalKegiatan,
            $request,
            &$dibuat,
            &$dilewati
        ) {

            foreach ($santriList as $santri) {

                /*
                 * Tagihan khusus menggunakan bulan kegiatan
                 * sebagai periode induk.
                 *
                 * Jika tagihan bulan tersebut sudah ada,
                 * kita gunakan tagihan yang sama.
                 *
                 * Jika belum ada, kita buat container tagihan.
                 */
                $tagihan = Tagihan::firstOrCreate(
                    [
                        'santri_id' =>
                            $santri->id,

                        'periode_bulan' =>
                            $tanggalKegiatan->month,

                        'periode_tahun' =>
                            $tanggalKegiatan->year,
                    ],
                    [
                        'status' =>
                            'belum_bayar',
                    ]
                );

                /*
                 * Jangan membuat jenis tagihan yang sama
                 * dua kali pada periode yang sama.
                 */
                $detailSudahAda = DetailTagihan::where(
                    'tagihan_id',
                    $tagihan->id
                )
                    ->where(
                        'jenis_tagihan_id',
                        $jenisTagihan->id
                    )
                    ->exists();

                if ($detailSudahAda) {
                    $dilewati++;
                    continue;
                }

                DetailTagihan::create([
                    'tagihan_id' =>
                        $tagihan->id,

                    'jenis_tagihan_id' =>
                        $jenisTagihan->id,

                    'tarif_tagihan_id' =>
                        $tarif->id,

                    'nominal' =>
                        $tarif->nominal,

                    'status' =>
                        'belum_bayar',

                    'keterangan' =>
                        $request->keterangan
                        ?: (
                            $jenisTagihan->nama .
                            ' - ' .
                            $tanggalKegiatan->format('d-m-Y')
                        ),
                ]);

                $tagihan->updateStatus();

                $dibuat++;
            }
        });

        $pesan =
            'Berhasil membuat ' .
            $dibuat .
            ' tagihan khusus.';

        if ($dilewati > 0) {
            $pesan .=
                ' ' .
                $dilewati .
                ' data dilewati karena tagihan sudah ada.';
        }

        return redirect()
            ->route('admin.tagihan-khusus.create')
            ->with(
                'success',
                $pesan
            );
    }
}