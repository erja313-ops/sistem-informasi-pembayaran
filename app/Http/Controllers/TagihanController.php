<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan'
        ]);

        // Cari berdasarkan nama atau NIS santri
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('santri', function ($q) use ($search) {

                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');

            });
        }

        // Filter bulan
        if ($request->filled('bulan')) {

            $query->where(
                'periode_bulan',
                $request->bulan
            );
        }

        // Filter tahun
        if ($request->filled('tahun')) {

            $query->where(
                'periode_tahun',
                $request->tahun
            );
        }

        // Filter status
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        $tahun = Tagihan::query()
            ->whereNotNull('periode_tahun')
            ->select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        $tagihan = $query
            ->orderByDesc('periode_tahun')
            ->orderByDesc('periode_bulan')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.tagihan.index',
            compact(
                'tagihan',
                'tahun'
            )
        );
    }

    public function show($id)
    {
        $tagihan = Tagihan::with([
            'santri',
            'detailTagihan.jenisTagihan',
            'detailTagihan.detailPembayaran.pembayaran'
        ])->findOrFail($id);

        return view(
            'admin.tagihan.show',
            compact('tagihan')
        );
    }
}