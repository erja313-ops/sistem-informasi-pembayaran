<?php

namespace App\Services;

use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\TarifTagihan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanGeneratorService
{
    public function generateUntukSantri(
        Santri $santri,
        int $bulan,
        int $tahun
    ): Tagihan {
        return DB::transaction(function () use (
            $santri,
            $bulan,
            $tahun
        ) {

            $tanggal = Carbon::create(
                $tahun,
                $bulan,
                1
            );

            /*
             * Satu tagihan adalah satu periode bulanan
             * untuk satu santri.
             */
            $tagihan = Tagihan::firstOrCreate(
                [
                    'santri_id' => $santri->id,
                    'periode_bulan' => $bulan,
                    'periode_tahun' => $tahun,
                ],
                [
                    'status' => 'belum_bayar',
                ]
            );

            /*
             * Ambil semua jenis tagihan yang aktif.
             */
            $jenisTagihan = \App\Models\JenisTagihan::where(
                'is_active',
                true
            )
            ->where(
                'is_bulanan',
                true
            )
            ->get();

            foreach ($jenisTagihan as $jenis) {

                /*
                 * Cari tarif yang berlaku pada bulan tersebut.
                 */
                $tarif = TarifTagihan::where(
                    'jenis_tagihan_id',
                    $jenis->id
                )
                ->whereDate(
                    'berlaku_mulai',
                    '<=',
                    $tanggal
                )
                ->where(function ($query) use ($tanggal) {
                    $query->whereNull('berlaku_sampai')
                        ->orWhereDate(
                            'berlaku_sampai',
                            '>=',
                            $tanggal
                        );
                })
                ->orderByDesc('berlaku_mulai')
                ->first();

                /*
                 * Jika jenis tagihan belum mempunyai tarif,
                 * lewati.
                 */
                if (!$tarif) {
                    continue;
                }

                /*
                 * Jangan membuat detail yang sama dua kali.
                 */
                $tagihan->detailTagihan()->firstOrCreate(
                    [
                        'jenis_tagihan_id' => $jenis->id,
                    ],
                    [
                        'tarif_tagihan_id' => $tarif->id,
                        'nominal' => $tarif->nominal,
                        'status' => 'belum_bayar',
                    ]
                );
            }

            return $tagihan->load('detailTagihan');
        });
    }

    public function generateUntukSemuaSantri(
        int $bulan,
        int $tahun
    ): int {
        $jumlah = 0;

        Santri::where('status', 'aktif')
            ->chunkById(100, function ($santriList) use (
                $bulan,
                $tahun,
                &$jumlah
            ) {
                foreach ($santriList as $santri) {
                    $this->generateUntukSantri(
                        $santri,
                        $bulan,
                        $tahun
                    );

                    $jumlah++;
                }
            });

        return $jumlah;
    }
}