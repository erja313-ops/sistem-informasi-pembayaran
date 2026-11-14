<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekening_pondok', function (Blueprint $table) {

            $table->string('bank', 100)
                ->after('id');

            $table->string('nomor_rekening', 100)
                ->after('bank');

            $table->string('atas_nama', 150)
                ->after('nomor_rekening');

            $table->boolean('is_active')
                ->default(true)
                ->after('atas_nama');

            $table->string('keterangan', 255)
                ->nullable()
                ->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('rekening_pondok', function (Blueprint $table) {

            $table->dropColumn([
                'bank',
                'nomor_rekening',
                'atas_nama',
                'is_active',
                'keterangan',
            ]);
        });
    }
};