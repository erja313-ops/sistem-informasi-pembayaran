<?php

namespace App\Http\Controllers;

use App\Models\TarifTagihan;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;

class TarifTagihanController extends Controller
{
    public function index()
    {
        $tarif = TarifTagihan::with('jenisTagihan')
            ->orderByDesc('berlaku_mulai')
            ->paginate(10);

        return view(
            'admin.tarif-tagihan.index',
            compact('tarif')
        );
    }

    public function create()
    {
        $jenisTagihan = JenisTagihan::where(
            'is_active',
            true
        )
        ->orderBy('nama')
        ->get();

        return view(
            'admin.tarif-tagihan.create',
            compact('jenisTagihan')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tagihan_id' => [
                'required',
                'exists:jenis_tagihan,id'
            ],

            'nominal' => [
                'required',
                'numeric',
                'min:0'
            ],

            'berlaku_mulai' => [
                'required',
                'date'
            ],

            'berlaku_sampai' => [
                'nullable',
                'date',
                'after_or_equal:berlaku_mulai'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],
        ]);

        TarifTagihan::create([
            'jenis_tagihan_id' =>
                $request->jenis_tagihan_id,

            'nominal' =>
                $request->nominal,

            'berlaku_mulai' =>
                $request->berlaku_mulai,

            'berlaku_sampai' =>
                $request->berlaku_sampai,

            'keterangan' =>
                $request->keterangan,
        ]);

        return redirect()
            ->route('admin.tarif-tagihan.index')
            ->with(
                'success',
                'Tarif tagihan berhasil ditambahkan.'
            );
    }
}