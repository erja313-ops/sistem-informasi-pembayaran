<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengeluaran;

class KategoriPengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'nama' => 'Operasional',
                'keterangan' => 'Pengeluaran operasional pondok',
            ],
            [
                'nama' => 'Konsumsi',
                'keterangan' => 'Pengeluaran untuk konsumsi dan kebutuhan makan',
            ],
            [
                'nama' => 'Listrik dan Air',
                'keterangan' => 'Pembayaran listrik, air, dan utilitas',
            ],
            [
                'nama' => 'Perawatan',
                'keterangan' => 'Perawatan dan perbaikan fasilitas pondok',
            ],
            [
                'nama' => 'Perlengkapan',
                'keterangan' => 'Pembelian perlengkapan dan kebutuhan pondok',
            ],
            [
                'nama' => 'Kegiatan',
                'keterangan' => 'Pengeluaran untuk kegiatan pondok',
            ],
            [
                'nama' => 'Lain-lain',
                'keterangan' => 'Pengeluaran lain yang tidak termasuk kategori utama',
            ],
        ];

        foreach ($kategori as $item) {
            KategoriPengeluaran::firstOrCreate(
                ['nama' => $item['nama']],
                ['keterangan' => $item['keterangan']]
            );
        }
    }
}