<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    protected $fillable = [
        'kategori_id',
        'pembayaran_id',
        'created_by',
        'tanggal',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriPemasukan::class,
            'kategori_id'
        );
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}