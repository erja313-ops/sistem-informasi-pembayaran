<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailPembayaran;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'diverifikasi_oleh',
        'kode_transaksi',
        'metode',
        'nominal_tagihan',
        'total_transfer',
        'tanggal_bayar',
        'bukti_pembayaran',
        'status',
        'alasan_penolakan',
        'diverifikasi_at',
    ];

    protected $casts = [
        'nominal_tagihan' => 'decimal:2',
        'total_transfer' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'diverifikasi_at' => 'datetime',
    ];

    /**
     * Detail-detail yang dibayar dalam transaksi ini.
     */
    public function detailPembayaran()
    {
        return $this->hasMany(
            DetailPembayaran::class,
            'pembayaran_id'
        );
    }

    public function hitungTotalDibayar()
    {
        return $this->detailPembayaran
            ->sum('nominal_dibayar');
    }

    public function totalSesuai()
    {
        return (float) $this->hitungTotalDibayar()
            === (float) $this->total_transfer;
    }

    public function cekKesesuaianNominal()
    {
        $totalDetail = (float) $this->hitungTotalDibayar();
        $totalTransfer = (float) $this->total_transfer;

        if ($totalDetail < $totalTransfer) {
            return 'belum_lengkap';
        }

        if ($totalDetail > $totalTransfer) {
            return 'melebihi';
        }

        return 'sesuai';
    }

    /**
     * Admin yang melakukan verifikasi pembayaran.
     */
    public function diverifikasiOleh()
    {
        return $this->belongsTo(
            User::class,
            'diverifikasi_oleh'
        );
    }
}