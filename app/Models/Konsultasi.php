<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'no_konsultasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function penyakit()
    {
        return $this->hasMany(KonsultasiPenyakit::class, 'konsultasi_id');
    }

    public function gejala()
    {
        return $this->hasMany(KonsultasiGejala::class,'konsultasi_id');
    }
}
