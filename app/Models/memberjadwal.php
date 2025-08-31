<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class memberjadwal extends Model
{
    protected $table = 'memberjadwal';

    protected $fillable = [
        'jadwal_pengampu_id',
        'mhs_id',
        'created_at',
        'updated_at',
    ];

    public function jadwalPengampu()
    {
        return $this->belongsTo(JadwalPengampu::class, 'jadwal_pengampu_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }
}
