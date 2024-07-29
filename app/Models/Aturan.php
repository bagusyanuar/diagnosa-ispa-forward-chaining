<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;

    protected $table = 'aturans';

    protected $fillable = [
        'penyakit_id',
        'gejala_id',
        'bobot'
    ];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class,'penyakit_id');
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}
