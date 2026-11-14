<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_tagihan', function (Blueprint $table) {
            $table->boolean('is_bulanan')
                ->default(false)
                ->after('is_active');
        });

        /*
         * Jenis yang memang merupakan komponen Syahriah bulanan.
         */
        DB::table('jenis_tagihan')
            ->whereIn('nama', [
                'Uang Makan',
                'Infaq',
                'Diniyyah',
                'Air Minum',
                'Sampah',
            ])
            ->update([
                'is_bulanan' => true,
            ]);
    }

    public function down(): void
    {
        Schema::table('jenis_tagihan', function (Blueprint $table) {
            $table->dropColumn('is_bulanan');
        });
    }
};