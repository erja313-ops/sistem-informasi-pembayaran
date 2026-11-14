<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\URL;

class KuitansiController extends Controller
{
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri',
        ]);

        $user = auth()->user();

        if ($user->role === 'wali') {

            $wali = $user->wali;

            $santriIds = $wali
                ? $wali->santri()->pluck('id')
                : collect();

            $bolehAkses = $pembayaran
                ->detailPembayaran
                ->contains(function ($detail) use ($santriIds) {

                    $santriId =
                        $detail
                            ->detailTagihan
                            ->tagihan
                            ->santri_id;

                    return $santriIds->contains($santriId);
                });

            abort_unless($bolehAkses, 403);
        }

        $shareUrl = URL::temporarySignedRoute(
            'kuitansi.public',
            now()->addMinutes(30),
            [
                'pembayaran' => $pembayaran->id,
            ]
        );

        return view(
            'kuitansi.show',
            compact(
                'pembayaran',
                'shareUrl'
            )
        );
    }

    public function public(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'detailPembayaran.detailTagihan.jenisTagihan',
            'detailPembayaran.detailTagihan.tagihan.santri',
        ]);

        return view(
            'kuitansi.show',
            [
                'pembayaran' => $pembayaran,
                'shareUrl' => null,
                'isPublic' => true,
            ]
        );
    }
}