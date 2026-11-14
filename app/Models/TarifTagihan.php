<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifTagihan extends Model
{
    use HasFactory;

    protected $table = 'tarif_tagihan';

    protected $fillable = [
        'jenis_tagihan_id',
        'nominal',
        'berlaku_mulai',
        'berlaku_sampai',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'berlaku_mulai' => 'date',
        'berlaku_sampai' => 'date',
        'is_active' => 'boolean',
    ];

    public function jenisTagihan()
    {
        return $this->belongsTo(
            JenisTagihan::class,
            'jenis_tagihan_id'
        );
    }
}