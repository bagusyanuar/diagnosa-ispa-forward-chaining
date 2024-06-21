<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiGejala extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_gejalas';

    protected $fillable = [
        'gejala_id',
        'konsultasi_id'
    ];

    public function gejala()
    {
        return $this->belongsTo(Gejala::class,'gejala_id');
    }

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class,'konsultasi_id');
    }
}
