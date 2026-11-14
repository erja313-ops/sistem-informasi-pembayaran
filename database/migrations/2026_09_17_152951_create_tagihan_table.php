<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')
                ->constrained('santri')
                ->cascadeOnDelete();

            $table->string('jenis_tagihan');
            $table->unsignedTinyInteger('periode_bulan');
            $table->unsignedSmallInteger('periode_tahun');

            $table->decimal('nominal', 12, 2);

            $table->date('jatuh_tempo')->nullable();

            $table->enum('status', ['belum_bayar', 'lunas'])
                ->default('belum_bayar');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(
                [
                    'santri_id',
                    'jenis_tagihan',
                    'periode_bulan',
                    'periode_tahun'
                ],
                'tagihan_periode_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
