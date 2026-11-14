<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pembayaran_id')
                ->constrained('pembayaran')
                ->cascadeOnDelete();

            $table->foreignId('detail_tagihan_id')
                ->constrained('detail_tagihan')
                ->restrictOnDelete();

            $table->decimal('nominal_dibayar', 12, 2);

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'pembayaran_id',
                'detail_tagihan_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pembayaran');
    }
};