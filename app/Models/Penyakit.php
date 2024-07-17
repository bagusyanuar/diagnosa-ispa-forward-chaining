<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakits';

    protected $fillable = [
        'nama',
        'keterangan',
        'pencegahan'
    ];

    public function aturan()
    {
        return $this->hasMany(Aturan::class, 'penyakit_id');
    }
}
