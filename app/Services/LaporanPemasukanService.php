<?php

namespace App\Services;

use App\Models\JenisTagihan;

class LaporanPemasukanService
{
    public function rekapPerJenis($mulai, $sampai)
    {
        $jenisTagihan = JenisTagihan::where('is_active', true)
            ->orderBy('nama')
            ->get();

        return $jenisTagihan->map(function ($jenis) use ($mulai, $sampai) {
            return [
                'jenis_tagihan_id' => $jenis->id,
                'nama' => $jenis->nama,
                'total_pemasukan' => $jenis->hitungTotalPembayaranPeriode(
                    $mulai,
                    $sampai
                ),
            ];
        });
    }

    public function totalPemasukan($mulai, $sampai)
    {
        return $this->rekapPerJenis($mulai, $sampai)
            ->sum('total_pemasukan');
    }
}