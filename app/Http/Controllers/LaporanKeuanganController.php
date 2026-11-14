<?php

namespace App\Http\Controllers;

use App\Services\LaporanKeuanganService;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    protected $laporanKeuanganService;

    public function __construct(
        LaporanKeuanganService $laporanKeuanganService
    ) {
        $this->laporanKeuanganService = $laporanKeuanganService;
    }

    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);

        $mulai = now()
            ->setYear($tahun)
            ->setMonth($bulan)
            ->startOfMonth()
            ->startOfDay();

        $sampai = now()
            ->setYear($tahun)
            ->setMonth($bulan)
            ->endOfMonth()
            ->endOfDay();

        $ringkasan = $this->laporanKeuanganService
            ->ringkasan($mulai, $sampai);

        return view(
            'laporan.keuangan.index',
            compact(
                'ringkasan',
                'mulai',
                'sampai',
                'bulan',
                'tahun'
            )
        );
    }
}