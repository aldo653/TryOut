<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinalty extends Model
{
    protected $table = 'holistic'; 
    protected $fillable = [
        'user_id',
        'deskripsi',
        'jenis',
        'tipe',
        'tgl',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
