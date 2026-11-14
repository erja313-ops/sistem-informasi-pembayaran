<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'santri_id',
        'jenis_tagihan_id',
        'jenis_tagihan',
        'periode_bulan',
        'periode_tahun',
        'nominal',
        'jatuh_tempo',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'jatuh_tempo' => 'date',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function jenisTagihan()
    {
        return $this->belongsTo(
            JenisTagihan::class,
            'jenis_tagihan_id'
        );
    }

    public function detailTagihan()
    {
        return $this->hasMany(DetailTagihan::class);
    }

    public function hitungTotalDibayar()
    {
        return $this->detailTagihan
            ->sum(function ($detail) {
                return $detail->hitungTotalDibayar();
            });
    }

    public function hitungSisa()
    {
        return max(
            0,
            (float) $this->detailTagihan->sum('nominal')
            - (float) $this->hitungTotalDibayar()
        );
    }

    public function updateStatus()
    {
        $details = $this->detailTagihan()->get();

        $totalDibayar = $details->sum(function ($detail) {
            return $detail->hitungTotalDibayar();
        });

        $totalNominal = $details->sum('nominal');

        if ($totalDibayar <= 0) {
            $status = 'belum_bayar';
        } elseif ($totalDibayar < $totalNominal) {
            $status = 'sebagian';
        } else {
            $status = 'lunas';
        }

        $this->update([
            'status' => $status
        ]);

        return $status;
    }

    public function getTotalNominalAttribute()
    {
        return $this->detailTagihan()->sum('nominal');
    }

    public function getTotalDibayarAttribute()
    {
        return $this->detailTagihan()
            ->with('detailPembayaran.pembayaran')
            ->get()
            ->sum(function ($detail) {
                return $detail->total_dibayar;
            });
    }

    public function getSisaAttribute()
    {
        $sisa = (float) $this->total_nominal - (float) $this->total_dibayar;

        return max(0, $sisa);
    }

    public function getStatusPembayaranAttribute()
    {
        $total = (float) $this->total_nominal;
        $dibayar = (float) $this->total_dibayar;

        if ($dibayar <= 0) {
            return 'BELUM_BAYAR';
        }

        if ($dibayar < $total) {
            return 'SEBAGIAN';
        }

        return 'LUNAS';
    }
}