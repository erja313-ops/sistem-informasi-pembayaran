<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::with('kategori')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('admin.pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        $kategori = KategoriPengeluaran::orderBy('nama')->get();

        return view('admin.pengeluaran.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategori_pengeluaran,id'],
            'tanggal' => ['required', 'date'],
            'nominal' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['created_by'] = auth()->id();

        Pengeluaran::create($validated);

        return redirect()
            ->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil disimpan.');
    }
}