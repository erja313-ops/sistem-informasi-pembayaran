<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use App\Services\LaporanPengeluaranService;
use Illuminate\Http\Request;

class LaporanPengeluaranController extends Controller
{
    protected $laporanPengeluaranService;

    public function __construct(
        LaporanPengeluaranService $laporanPengeluaranService
    ) {
        $this->laporanPengeluaranService = $laporanPengeluaranService;
    }

    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);

        $kategoriId = $request->kategori_id;

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

        $kategori = KategoriPengeluaran::orderBy('nama')->get();

        $rekap = $this->laporanPengeluaranService
            ->rekapPerKategori(
                $mulai,
                $sampai,
                $kategoriId
            );

        $totalPengeluaran = $this->laporanPengeluaranService
            ->totalPengeluaran(
                $mulai,
                $sampai,
                $kategoriId
            );

        return view(
            'laporan.pengeluaran.index',
            compact(
                'rekap',
                'totalPengeluaran',
                'mulai',
                'sampai',
                'bulan',
                'tahun',
                'kategori',
                'kategoriId'
            )
        );
    }
}