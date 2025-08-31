<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class quanty_byjadwal extends Model
{
    protected $table = 'quanty_byjadwals';

    protected $fillable = [
        'jadwal_pengampu_id',
        'deskripsi',
        'created_at',
        'updated_at',
    ];

    public function jadwalPengampu()
    {
        return $this->belongsTo(JadwalPengampu::class, 'jadwal_pengampu_id');
    }
}
