<?php

namespace App\Http\Controllers;

use App\Models\JenisTagihan;
use Illuminate\Http\Request;

class JenisTagihanController extends Controller
{
    public function index()
    {
        $jenisTagihan = JenisTagihan::orderBy('nama')
            ->paginate(10);

        return view(
            'admin.jenis-tagihan.index',
            compact('jenisTagihan')
        );
    }

    public function create()
    {
        return view('admin.jenis-tagihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_bulanan' => 'required|boolean',
        ]);

        JenisTagihan::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'is_active' => $request->is_active ?? true,
            'is_bulanan' => $request->is_bulanan,
        ]);

        $jenisTagihan->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'is_active' => $request->is_active ?? true,
            'is_bulanan' => $request->is_bulanan,
        ]);

        return redirect()
            ->route('admin.jenis-tagihan.index')
            ->with(
                'success',
                'Jenis tagihan berhasil ditambahkan.'
            );
    }

    public function edit($id)
    {
        $jenisTagihan = JenisTagihan::findOrFail($id);

        return view(
            'admin.jenis-tagihan.edit',
            compact('jenisTagihan')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $jenisTagihan = JenisTagihan::findOrFail($id);

        $jenisTagihan->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('admin.jenis-tagihan.index')
            ->with(
                'success',
                'Jenis tagihan berhasil diperbarui.'
            );
    }
}