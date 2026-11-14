<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTagihan extends Model
{
    use HasFactory;

    protected $table = 'detail_tagihan';

    protected $fillable = [
        'tagihan_id',
        'jenis_tagihan_id',
        'tarif_tagihan_id',
        'nominal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    public function tagihan()
    {
        return $this->belongsTo(
            Tagihan::class,
            'tagihan_id'
        );
    }

    public function jenisTagihan()
    {
        return $this->belongsTo(
            JenisTagihan::class,
            'jenis_tagihan_id'
        );
    }

    public function tarifTagihan()
    {
        return $this->belongsTo(
            TarifTagihan::class,
            'tarif_tagihan_id'
        );
    }

    public function detailPembayaran()
    {
        return $this->hasMany(
            DetailPembayaran::class,
            'detail_tagihan_id'
        );
    }

    public function hitungTotalDibayar()
    {
        return $this->detailPembayaran()
            ->whereHas('pembayaran', function ($query) {
                $query->where('status', 'diterima');
            })
            ->sum('nominal_dibayar');
    }

    public function hitungSisa()
    {
        return max(
            0,
            $this->nominal - $this->hitungTotalDibayar()
        );
    }

    public function nominalMaksimalDibayar()
    {
        return $this->hitungSisa();
    }

    public function bisaDibayar($nominal)
    {
        return $nominal > 0
            && $nominal <= $this->hitungSisa();
    }

    public function updateStatus()
    {
        $totalDibayar = $this->hitungTotalDibayar();

        if ($totalDibayar <= 0) {
            $status = 'belum_bayar';
        } elseif ($totalDibayar < $this->nominal) {
            $status = 'sebagian';
        } else {
            $status = 'lunas';
        }

        $this->update([
            'status' => $status
        ]);

        return $status;
    }
}