<?php

namespace App\Http\Controllers;

use App\Models\RekeningPondok;
use Illuminate\Http\Request;

class RekeningPondokController extends Controller
{
    public function index()
    {
        $rekening = RekeningPondok::orderByDesc('is_active')
            ->orderBy('bank')
            ->get();

        return view(
            'admin.rekening.index',
            compact('rekening')
        );
    }

    public function create()
    {
        return view(
            'admin.rekening.create'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:100',
            'atas_nama' => 'required|string|max:150',
            'is_active' => 'nullable|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        RekeningPondok::create($validated);

        return redirect()
            ->route('admin.rekening.index')
            ->with(
                'success',
                'Rekening pondok berhasil ditambahkan.'
            );
    }

    public function edit($id)
    {
        $rekening =
            RekeningPondok::findOrFail($id);

        return view(
            'admin.rekening.edit',
            compact('rekening')
        );
    }

    public function update(
        Request $request,
        $id
    ) {
        $rekening =
            RekeningPondok::findOrFail($id);

        $validated = $request->validate([
            'bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:100',
            'atas_nama' => 'required|string|max:150',
            'is_active' => 'nullable|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        $rekening->update($validated);

        return redirect()
            ->route('admin.rekening.index')
            ->with(
                'success',
                'Rekening pondok berhasil diperbarui.'
            );
    }

    public function toggle($id)
    {
        $rekening =
            RekeningPondok::findOrFail($id);

        $rekening->update([
            'is_active' =>
                !$rekening->is_active,
        ]);

        return redirect()
            ->route('admin.rekening.index')
            ->with(
                'success',
                'Status rekening berhasil diperbarui.'
            );
    }
}