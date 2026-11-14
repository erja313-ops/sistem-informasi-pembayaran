<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Wali;

class WaliDashboardController extends Controller
{
    public function index()
    {
        $wali = Wali::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        $santri = $wali->santri()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $santriIds = $santri->pluck('id');

        $tagihanBelumLunas = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan',
        ])
        ->whereIn('santri_id', $santriIds)
        ->whereIn('status', [
            'belum_bayar',
            'sebagian',
        ])
        ->orderByDesc('periode_tahun')
        ->orderByDesc('periode_bulan')
        ->get();

        $totalTunggakan = $tagihanBelumLunas
            ->sum(function ($tagihan) {
                return $tagihan->hitungSisa();
            });

        $jumlahTagihanBelumLunas =
            $tagihanBelumLunas->count();

        $pembayaranMenunggu =
            Pembayaran::where('status', 'menunggu_verifikasi')
            ->whereHas(
                'detailPembayaran.detailTagihan.tagihan',
                function ($query) use ($santriIds) {
                    $query->whereIn(
                        'santri_id',
                        $santriIds
                    );
                }
            )
            ->count();

        $pembayaranTerakhir =
            Pembayaran::with([
                'detailPembayaran.detailTagihan.jenisTagihan',
                'detailPembayaran.detailTagihan.tagihan.santri',
            ])
            ->whereHas(
                'detailPembayaran.detailTagihan.tagihan',
                function ($query) use ($santriIds) {
                    $query->whereIn(
                        'santri_id',
                        $santriIds
                    );
                }
            )
            ->orderByDesc('tanggal_bayar')
            ->limit(5)
            ->get();

        return view(
            'wali.dashboard',
            compact(
                'wali',
                'santri',
                'tagihanBelumLunas',
                'jumlahTagihanBelumLunas',
                'totalTunggakan',
                'pembayaranMenunggu',
                'pembayaranTerakhir'
            )
        );
    }
}