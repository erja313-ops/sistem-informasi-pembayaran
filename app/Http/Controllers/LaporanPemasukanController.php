<?php

namespace App\Http\Controllers;

use App\Models\JenisTagihan;
use App\Services\LaporanPemasukanService;
use Illuminate\Http\Request;

class LaporanPemasukanController extends Controller
{
    protected $laporanPemasukanService;

    public function __construct(LaporanPemasukanService $laporanPemasukanService)
    {
        $this->laporanPemasukanService = $laporanPemasukanService;
    }

    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $jenisTagihanId = $request->input('jenis_tagihan_id');

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

        $rekap = $this->laporanPemasukanService
            ->rekapPerJenis($mulai, $sampai);

        if ($jenisTagihanId) {
            $rekap = $rekap->where(
                'jenis_tagihan_id',
                (int) $jenisTagihanId
            )->values();
        }

        $totalPemasukan = $rekap->sum('total_pemasukan');

        $jenisTagihan = JenisTagihan::where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('laporan.pemasukan.index', compact(
            'rekap',
            'totalPemasukan',
            'mulai',
            'sampai',
            'bulan',
            'tahun',
            'jenisTagihanId',
            'jenisTagihan'
        ));
    }
}