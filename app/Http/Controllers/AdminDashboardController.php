<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Services\LaporanPemasukanService;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    protected $laporanPemasukanService;

    public function __construct(
        LaporanPemasukanService $laporanPemasukanService
    ) {
        $this->laporanPemasukanService = $laporanPemasukanService;
    }

    public function index()
    {
        // Total santri
        $totalSantri = Santri::count();

        // Tagihan yang belum lunas
        $tagihanBelumLunas = Tagihan::where('status', '!=', 'lunas')
            ->count();

        // Pembayaran yang masih menunggu verifikasi
        $pembayaranMenunggu = Pembayaran::where(
            'status',
            'menunggu_verifikasi'
        )->count();

        $pembayaranPending = Pembayaran::with([
            'detailPembayaran.detailTagihan.tagihan.santri'
        ])
            ->where('status', 'menunggu_verifikasi')
            ->orderByDesc('tanggal_bayar')
            ->limit(5)
            ->get();

        // Periode bulan berjalan
        $awalBulan = now()->startOfMonth()->startOfDay();
        $akhirBulan = now()->endOfMonth()->endOfDay();

        // Pemasukan berdasarkan pembayaran yang diterima
        $totalPemasukan = $this->laporanPemasukanService
            ->totalPemasukan(
                $awalBulan,
                $akhirBulan
            );

        // Pengeluaran bulan berjalan
        $totalPengeluaran = Pengeluaran::whereBetween(
            'tanggal',
            [$awalBulan, $akhirBulan]
        )->sum('nominal');

        $tahunGrafik = now()->year;

        $grafikBulanan = [];
        $nilaiMaksimalGrafik = 0;

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $mulaiGrafik = Carbon::create(
                $tahunGrafik,
                $bulan,
                1
            )->startOfMonth();

            $sampaiGrafik = $mulaiGrafik
                ->copy()
                ->endOfMonth()
                ->endOfDay();

            $pemasukanGrafik = $this->laporanPemasukanService
                ->totalPemasukan(
                    $mulaiGrafik,
                    $sampaiGrafik
                );

            $pengeluaranGrafik = Pengeluaran::whereBetween(
                'tanggal',
                [
                    $mulaiGrafik,
                    $sampaiGrafik
                ]
            )->sum('nominal');

            $grafikBulanan[] = [
                'bulan' => $bulan,
                'nama_bulan' => Carbon::create(
                    $tahunGrafik,
                    $bulan,
                    1
                )->translatedFormat('F'),
                'pemasukan' => $pemasukanGrafik,
                'pengeluaran' => $pengeluaranGrafik,
            ];

            $nilaiMaksimalGrafik = max(
                $nilaiMaksimalGrafik,
                (float) $pemasukanGrafik,
                (float) $pengeluaranGrafik
            );
        }

        return view('admin.dashboard', compact(
            'totalSantri',
            'tagihanBelumLunas',
            'pembayaranMenunggu',
            'totalPemasukan',
            'totalPengeluaran',
            'grafikBulanan',
            'nilaiMaksimalGrafik',
            'tahunGrafik',
            'pembayaranPending'
        ));
    }
}