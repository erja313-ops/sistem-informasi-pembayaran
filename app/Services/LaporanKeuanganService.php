<?php

namespace App\Services;

use App\Services\LaporanPemasukanService;
use App\Services\LaporanPengeluaranService;

class LaporanKeuanganService
{
    protected $laporanPemasukanService;
    protected $laporanPengeluaranService;

    public function __construct(
        LaporanPemasukanService $laporanPemasukanService,
        LaporanPengeluaranService $laporanPengeluaranService
    ) {
        $this->laporanPemasukanService = $laporanPemasukanService;
        $this->laporanPengeluaranService = $laporanPengeluaranService;
    }

    public function ringkasan($mulai, $sampai)
    {
        $pemasukan = $this->laporanPemasukanService
            ->totalPemasukan($mulai, $sampai);

        $pengeluaran = $this->laporanPengeluaranService
            ->totalPengeluaran($mulai, $sampai);

        $saldo = $pemasukan - $pengeluaran;

        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $saldo,
        ];
    }
}