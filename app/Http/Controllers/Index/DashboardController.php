<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengampu;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(){
        $user = Role::withCount('users')->get();

        $jadwal = JadwalPengampu::select('hari', DB::raw('count(*) as total'))->groupBy('hari')->get();
        return view('dashboard.index', compact('user', 'jadwal'));
    }
}
