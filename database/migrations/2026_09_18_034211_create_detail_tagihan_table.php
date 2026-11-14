<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_tagihan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tagihan_id')
                ->constrained('tagihan')
                ->cascadeOnDelete();

            $table->foreignId('jenis_tagihan_id')
                ->constrained('jenis_tagihan')
                ->restrictOnDelete();

            $table->foreignId('tarif_tagihan_id')
                ->nullable()
                ->constrained('tarif_tagihan')
                ->nullOnDelete();

            $table->decimal('nominal', 12, 2);

            $table->string('status')
                ->default('BELUM_BAYAR');

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'tagihan_id',
                'jenis_tagihan_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_tagihan');
    }
};