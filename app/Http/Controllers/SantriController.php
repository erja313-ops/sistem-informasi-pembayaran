<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('wali')
            ->orderBy('nama');

        // Pencarian berdasarkan nama atau NIS
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $kelas = Santri::query()
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        $santri = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.santri.index', compact(
            'santri',
            'kelas'
        ));
    }

    public function create()
{
    $wali = Wali::orderBy('nama')->get();

    return view(
        'admin.santri.create',
        compact('wali')
    );
}

public function store(Request $request)
{
    $request->validate([
        'nis' => 'required|string|max:50|unique:santri,nis',
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => [
            'required',
            Rule::in(['Laki-laki', 'Perempuan']),
        ],
        'kelas' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'status' => [
            'required',
            Rule::in(['aktif', 'nonaktif']),
        ],
        'wali_id' => 'nullable|exists:wali,id',
    ]);

    Santri::create([
        'wali_id' => $request->wali_id,
        'nis' => $request->nis,
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'kelas' => $request->kelas,
        'alamat' => $request->alamat,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('admin.santri.index')
        ->with(
            'success',
            'Data santri berhasil ditambahkan.'
        );
}

public function edit($id)
{
    $santri = Santri::with('wali')->findOrFail($id);

    $wali = Wali::orderBy('nama')->get();

    return view(
        'admin.santri.edit',
        compact('santri', 'wali')
    );
}

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $request->validate([
            'nis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('santri', 'nis')
                    ->ignore($santri->id),
            ],

            'nama' => 'required|string|max:255',

            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki-laki', 'Perempuan']),
            ],

            'kelas' => 'required|string|max:100',

            'alamat' => 'nullable|string',

            'status' => [
                'required',
                Rule::in(['aktif', 'nonaktif']),
            ],

            'wali_id' => 'nullable|exists:wali,id',
        ]);

        $santri->update([
            'wali_id' => $request->wali_id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.santri.index')
            ->with(
                'success',
                'Data santri berhasil diperbarui.'
            );
    }
}