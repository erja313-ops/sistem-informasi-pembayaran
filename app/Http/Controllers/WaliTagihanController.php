<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Wali;
use Illuminate\Http\Request;

class WaliTagihanController extends Controller
{
    public function index(Request $request)
    {
        $wali = Wali::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

        $santriIds = $wali->santri()
            ->where('status', 'aktif')
            ->pluck('id');

        $santri = $wali->santri()
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $query = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan',
        ])
        ->whereIn('santri_id', $santriIds)
        ->whereIn('status', [
            'belum_bayar',
            'sebagian',
        ])
        ->orderByDesc('periode_tahun')
        ->orderByDesc('periode_bulan');

        if ($request->filled('santri_id')) {

            $query->where(
                'santri_id',
                $request->santri_id
            );
        }

        if ($request->filled('bulan')) {

            $query->where(
                'periode_bulan',
                $request->bulan
            );
        }

        if ($request->filled('tahun')) {

            $query->where(
                'periode_tahun',
                $request->tahun
            );
        }

        $tagihan = $query
            ->paginate(10)
            ->withQueryString();

        $tahun = Tagihan::whereIn(
            'santri_id',
            $santriIds
        )
        ->select('periode_tahun')
        ->distinct()
        ->orderByDesc('periode_tahun')
        ->pluck('periode_tahun');

        return view(
            'wali.tagihan.index',
            compact(
                'wali',
                'santri',
                'tagihan',
                'tahun'
            )
        );
    }

    public function show($id)
    {
        $wali = Wali::where('user_id', auth()->id())
            ->firstOrFail();

        $tagihan = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan'
        ])->findOrFail($id);

        // Pastikan tagihan benar-benar milik santri
        // yang terhubung dengan wali yang sedang login.
        $santriIds = $wali->santri()
            ->pluck('id');

        if (!$santriIds->contains($tagihan->santri_id)) {
            abort(403, 'Anda tidak memiliki akses ke tagihan ini.');
        }

        return view(
            'wali.tagihan.show',
            compact('wali', 'tagihan')
        );
    }
}