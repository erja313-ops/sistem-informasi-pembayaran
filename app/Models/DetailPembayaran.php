<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembayaran extends Model
{
    use HasFactory;

    protected $table = 'detail_pembayaran';

    protected $fillable = [
        'pembayaran_id',
        'detail_tagihan_id',
        'nominal_dibayar',
        'keterangan',
    ];

    protected $casts = [
        'nominal_dibayar' => 'decimal:2',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(
            Pembayaran::class,
            'pembayaran_id'
        );
    }

    public function detailTagihan()
    {
        return $this->belongsTo(
            DetailTagihan::class,
            'detail_tagihan_id'
        );
    }
    
    public function sinkronkanStatus()
    {
        $detailTagihan = $this->detailTagihan;

        if (!$detailTagihan) {
            return false;
        }

        // Update status detail tagihan
        $detailTagihan->updateStatus();

        // Update status tagihan utama
        $tagihan = $detailTagihan->tagihan;

        if ($tagihan) {
            $tagihan->updateStatus();
        }

        return true;
    }
}