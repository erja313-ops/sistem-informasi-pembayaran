<?php

namespace App\Http\Controllers;

use App\Services\TagihanGeneratorService;
use Illuminate\Http\Request;

class GenerateTagihanController extends Controller
{
    protected $tagihanGeneratorService;

    public function __construct(
        TagihanGeneratorService $tagihanGeneratorService
    ) {
        $this->tagihanGeneratorService =
            $tagihanGeneratorService;
    }

    public function create()
    {
        return view(
            'admin.tagihan.generate'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => [
                'required',
                'integer',
                'between:1,12'
            ],

            'tahun' => [
                'required',
                'integer',
                'min:2020',
                'max:2100'
            ],
        ]);

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        $jumlah = $this->tagihanGeneratorService
            ->generateUntukSemuaSantri(
                $bulan,
                $tahun
            );

        return redirect()
            ->route('admin.tagihan.generate')
            ->with(
                'success',
                "Berhasil membuat/memeriksa tagihan {$bulan}/{$tahun} untuk {$jumlah} santri aktif."
            );
    }
}