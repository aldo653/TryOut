<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPengampu extends Model
{
    protected $table = 'jadwal_pengampu'; // Specify the table name

    protected $fillable = [
        'kegiatan_id',
        'pengampu',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'deskripsi',
        'status' // New field for status 
    ];

    public $timestamps = true; // Enable timestamps
}
