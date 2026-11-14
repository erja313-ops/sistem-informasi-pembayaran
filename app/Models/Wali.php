<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    use HasFactory;

    protected $table = 'wali';

    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function santri()
    {
        return $this->hasMany(
            Santri::class,
            'wali_id'
        );
    }
}