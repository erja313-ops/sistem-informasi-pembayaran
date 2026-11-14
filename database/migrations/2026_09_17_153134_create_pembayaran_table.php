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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tagihan_id')
                ->constrained('tagihan')
                ->cascadeOnDelete();

            $table->foreignId('diverifikasi_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('kode_transaksi', 50)->unique();

            $table->enum('metode', ['offline', 'transfer']);

            $table->decimal('nominal_tagihan', 12, 2);

            $table->unsignedSmallInteger('kode_unik')->nullable();

            $table->decimal('total_transfer', 12, 2)->nullable();

            $table->dateTime('tanggal_bayar')->nullable();

            $table->string('bukti_pembayaran')->nullable();

            $table->enum('status', [
                'menunggu_verifikasi',
                'diterima',
                'ditolak'
            ])->default('menunggu_verifikasi');

            $table->text('alasan_penolakan')->nullable();

            $table->dateTime('diverifikasi_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
