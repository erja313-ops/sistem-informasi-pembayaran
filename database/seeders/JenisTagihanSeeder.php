<?php

namespace Database\Seeders;

use App\Models\JenisTagihan;
use App\Models\TarifTagihan;
use Illuminate\Database\Seeder;

class JenisTagihanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Uang Makan',
                'keterangan' => 'Biaya makan santri setiap bulan.',
                'nominal' => 350000,
            ],
            [
                'nama' => 'Infaq',
                'keterangan' => 'Infaq bulanan santri.',
                'nominal' => 25000,
            ],
            [
                'nama' => 'Diniyyah',
                'keterangan' => 'Biaya kegiatan pendidikan diniyyah.',
                'nominal' => 15000,
            ],
            [
                'nama' => 'Air Minum',
                'keterangan' => 'Biaya air minum santri.',
                'nominal' => 8000,
            ],
            [
                'nama' => 'Sampah',
                'keterangan' => 'Biaya pengelolaan sampah.',
                'nominal' => 2000,
            ],
        ];

        foreach ($data as $item) {
            $jenisTagihan = JenisTagihan::updateOrCreate(
                [
                    'nama' => $item['nama'],
                ],
                [
                    'keterangan' => $item['keterangan'],
                    'is_active' => true,
                ]
            );

            TarifTagihan::updateOrCreate(
                [
                    'jenis_tagihan_id' => $jenisTagihan->id,
                    'berlaku_mulai' => '2026-01-01',
                ],
                [
                    'nominal' => $item['nominal'],
                    'berlaku_sampai' => null,
                    'keterangan' => 'Tarif awal',
                    'is_active' => true,
                ]
            );
        }
    }
}