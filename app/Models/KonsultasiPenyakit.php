<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiPenyakit extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_penyakits';

    protected $fillable = [
        'konsultasi_id',
        'penyakit_id',
        'persentasi'
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class,'konsultasi_id');
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class,'penyakit_id');
    }
}
