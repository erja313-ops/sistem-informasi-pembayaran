<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wali;
use App\Models\Santri;
use Illuminate\Database\Seeder;

class WaliSantriSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil akun wali yang sudah dibuat oleh UserSeeder
        $user = User::where('username', 'wali001')->firstOrFail();

        // Buat / ambil data wali
        $wali = Wali::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => 'Wali Santri 001',
                'no_hp' => '081234567890',
                'alamat' => 'Jombang',
            ]
        );

        // Santri pertama
        Santri::updateOrCreate(
            ['nis' => '260001'],
            [
                'wali_id' => $wali->id,
                'nama' => 'Ahmad Fauzan',
                'jenis_kelamin' => 'L',
                'kelas' => '7A',
                'alamat' => 'Jombang',
                'status' => 'aktif',
            ]
        );

        // Santri kedua
        Santri::updateOrCreate(
            ['nis' => '260002'],
            [
                'wali_id' => $wali->id,
                'nama' => 'Ahmad Fikri',
                'jenis_kelamin' => 'L',
                'kelas' => '8A',
                'alamat' => 'Jombang',
                'status' => 'aktif',
            ]
        );
    }
}