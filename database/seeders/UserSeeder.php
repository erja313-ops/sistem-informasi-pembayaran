<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@alasror.test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['username' => 'wali001'],
            [
                'name' => 'Wali Santri 001',
                'email' => 'wali001@alasror.test',
                'password' => Hash::make('password123'),
                'role' => 'wali',
                'is_active' => true,
            ]
        );
    }
}