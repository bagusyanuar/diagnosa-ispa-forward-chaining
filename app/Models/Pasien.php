<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'jenis_kelamin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
