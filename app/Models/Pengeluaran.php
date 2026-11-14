<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'kategori_id',
        'created_by',
        'tanggal',
        'nominal',
        'keterangan',
        'bukti',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriPengeluaran::class,
            'kategori_id'
        );
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}