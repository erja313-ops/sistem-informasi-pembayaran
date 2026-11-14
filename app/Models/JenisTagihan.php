<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTagihan extends Model
{
    use HasFactory;

    protected $table = 'jenis_tagihan';

    protected $fillable = [
        'nama',
        'keterangan',
        'is_active',
        'is_bulanan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_bulanan' => 'boolean',
    ];

    public function tarifTagihan()
    {
        return $this->hasMany(
            TarifTagihan::class,
            'jenis_tagihan_id'
        );
    }

    public function detailTagihan()
    {
        return $this->hasMany(
            DetailTagihan::class,
            'jenis_tagihan_id'
        );
    }

    public function hitungTotalPembayaran()
    {
        return $this->detailTagihan
            ->sum(function ($detail) {
                return $detail->hitungTotalDibayar();
            });
    }

    public function hitungTotalPembayaranPeriode($mulai, $sampai)
    {
        return $this->detailTagihan
            ->flatMap(function ($detail) {
                return $detail->detailPembayaran()
                    ->with('pembayaran')
                    ->get();
            })
            ->filter(function ($detailPembayaran) use ($mulai, $sampai) {
                $pembayaran = $detailPembayaran->pembayaran;

                if (!$pembayaran) {
                    return false;
                }

                if ($pembayaran->status !== 'diterima') {
                    return false;
                }

                $tanggal = $pembayaran->tanggal_bayar;

                return $tanggal >= $mulai
                    && $tanggal <= $sampai;
            })
            ->sum('nominal_dibayar');
    }
}