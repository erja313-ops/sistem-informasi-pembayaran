<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'wali_id',
        'nis',
        'nama',
        'jenis_kelamin',
        'kelas',
        'alamat',
        'status',
    ];

    public function wali()
    {
        return $this->belongsTo(
            Wali::class,
            'wali_id'
        );
    }

    public function tagihan()
    {
        return $this->hasMany(
            Tagihan::class,
            'santri_id'
        );
    }
}