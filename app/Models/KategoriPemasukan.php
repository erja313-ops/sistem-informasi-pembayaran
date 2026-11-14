<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPemasukan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pemasukan';

    protected $fillable = [
        'nama',
        'keterangan',
    ];

    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class, 'kategori_id');
    }
}