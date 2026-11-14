<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom menjadi string agar menerima
        // "Laki-laki" dan "Perempuan".
        DB::statement("
            ALTER TABLE santri
            MODIFY jenis_kelamin VARCHAR(20) NOT NULL
        ");

        // Normalisasi data lama bila sebelumnya menggunakan
        // nilai L/P.
        DB::statement("
            UPDATE santri
            SET jenis_kelamin = CASE
                WHEN jenis_kelamin = 'L' THEN 'Laki-laki'
                WHEN jenis_kelamin = 'P' THEN 'Perempuan'
                ELSE jenis_kelamin
            END
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE santri
            MODIFY jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL
        ");
    }
};