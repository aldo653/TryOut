<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengampu;
use App\Models\memberjadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPengampu::join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->leftJoin('memberjadwal', function ($join) {
                $join->on('jadwal_pengampu.id', '=', 'memberjadwal.jadwal_pengampu_id')
                    ->where('memberjadwal.mhs_id', Auth::id());
            })
            ->where('jadwal_pengampu.status', 'active')
            ->select(
                'jadwal_pengampu.*',
                'users.name as pengampu_nama',
                'kegiatan.nama_kegiatan',
                'memberjadwal.id as memberjadwal_id',
                DB::raw('CASE WHEN memberjadwal.id IS NULL THEN 0 ELSE 1 END as is_assigned')
            );
        

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kegiatan.nama_kegiatan', 'like', "%{$search}%")
                    ->orWhere('users.name', 'like', "%{$search}%")
                    ->orWhere('jadwal_pengampu.hari', 'like', "%{$search}%")
                    ->orWhere('jadwal_pengampu.lokasi', 'like', "%{$search}%")
                    ->orWhere('jadwal_pengampu.deskripsi', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->get();

        return view('feature.assignment', compact('jadwals'));
    }

    public function assignments(Request $request)
    {
        $request->validate([
            'jadwal_pengampu_id' => 'required|exists:jadwal_pengampu,id',
        ]);

        $assignment = memberjadwal::firstOrCreate(
            [
                'jadwal_pengampu_id' => $request->jadwal_pengampu_id,
                'mhs_id' => Auth::id(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'You have assigned successfully',
        ]);
    }
}
