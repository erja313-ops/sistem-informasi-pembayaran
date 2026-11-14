<?php

namespace App\Services;

use App\Models\KategoriPengeluaran;
use App\Models\Pengeluaran;

class LaporanPengeluaranService
{
    public function rekapPerKategori($mulai, $sampai, $kategoriId = null)
    {
        $kategori = KategoriPengeluaran::query()
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('id', $kategoriId);
            })
            ->orderBy('nama')
            ->get();

        return $kategori->map(function ($item) use ($mulai, $sampai) {

            $total = Pengeluaran::where('kategori_id', $item->id)
                ->whereBetween('tanggal', [$mulai, $sampai])
                ->sum('nominal');

            return [
                'kategori_id' => $item->id,
                'nama' => $item->nama,
                'total_pengeluaran' => $total,
            ];
        });
    }

    public function totalPengeluaran($mulai, $sampai, $kategoriId = null)
    {
        return $this->rekapPerKategori(
            $mulai,
            $sampai,
            $kategoriId
        )->sum('total_pengeluaran');
    }
}