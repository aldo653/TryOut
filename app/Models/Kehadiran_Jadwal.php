<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran_Jadwal extends Model
{
    protected $table = 'kehadiran__jadwal'; 

    protected $fillable = [
        'quantity_byjadwal_id',
        'mhs_id',
        'status'
    ];

    public $timestamps = true; // Enable timestamps

    public function quantityByJadwal()
    {
        return $this->belongsTo(quanty_byjadwal::class, 'quantity_byjadwal_id');
    }

    public function mhs()
    {
        return $this->belongsTo(User::class, 'mhs_id');
    }
}
