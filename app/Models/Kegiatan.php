<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan'; // Specify the table name

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'poin_kegiatan'
    ];

    public $timestamps = true; // Enable timestamps
}
