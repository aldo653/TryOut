<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengampu;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPengampuController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPengampu::join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->select('jadwal_pengampu.*', 'users.name as pengampu_nama', 'kegiatan.nama_kegiatan')
            ->where('jadwal_pengampu.status', 'active') 
            ->get();
        $kegiatan = Kegiatan::all(); // Fetch all activities
        $pengampu = User::role('Pengajar')->with('roles')->get();
        return view('master.jadwal', compact('jadwal', 'kegiatan', 'pengampu')); // Return the jadwal view with the schedules
    }

    public function getbyId($id)
    {
        $jadwal = JadwalPengampu::findOrFail($id); // Find schedule by ID
        return response()->json($jadwal);
    }

    public function getdummy()
    {
        $pengampu = User::with('roles')
            ->where('name', 'Pengajar')
            ->get();
        return response()->json($pengampu);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengampu' => 'required|exists:users,id',
            'kegiatan' => 'required|exists:kegiatan,id',
            'hari' => 'required|string|max:10',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|string|in:active,inactive', 
        ]);

        JadwalPengampu::create([
            'pengampu' => $request->pengampu,
            'kegiatan_id' => $request->kegiatan,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status, // New field for status
        ]);

        return redirect()->back()->with('success', 'Schedule created successfully.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPengampu::findOrFail($id);
        $jadwal->delete();
        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPengampu::findOrFail($id);
           $request->validate([
            'pengampu' => 'required|exists:users,id',
            'kegiatan' => 'required|exists:kegiatan,id',
            'hari' => 'required|string|max:10',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|string|in:active,inactive', // New field for status
        ]);
        $jadwal->update([
            'pengampu' => $request->pengampu,
            'kegiatan_id' => $request->kegiatan,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status, // New field for status
        ]);

        return redirect()->back()->with('success', 'Schedule updated successfully.');
    }
}
