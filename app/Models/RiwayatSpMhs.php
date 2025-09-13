<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatSpMhs extends Model
{
    protected $table = 'riwayat_sp_mhs';

    protected $fillable = [
        'mhs_id',
        'no_surat',
        'tenggat',
        'perihal',
        'alasan',
    ];

    
}
