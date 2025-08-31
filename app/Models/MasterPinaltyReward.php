<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPinaltyReward extends Model
{
    protected $table = 'master_pinalty_rewards'; 
    protected $fillable = [
        'jenis',
        'tipe',
        'poin',
    ];
    
}
