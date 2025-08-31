<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengampu;
use App\Models\Kehadiran_Jadwal;
use App\Models\memberjadwal;
use App\Models\quanty_byjadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPengampu::join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->select('jadwal_pengampu.*', 'users.name as pengampu_nama', 'kegiatan.nama_kegiatan')
            ->where('jadwal_pengampu.status', 'active')
            ->where('jadwal_pengampu.pengampu', Auth::id())
            ->get();
        return view('feature.assessment', compact('jadwals')); // Return the assessment view with the jadwals
    }

    public function detail($id)
    {
        $jadwal = JadwalPengampu::where('jadwal_pengampu.id', $id)
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', 'kegiatan.id')
            ->select('jadwal_pengampu.*', 'kegiatan.nama_kegiatan')
            ->first();
            
        $member = memberjadwal::join('users', 'memberjadwal.mhs_id', '=', 'users.id')
            ->select('memberjadwal.*', 'users.name as mhs_nama', 'users.id as mhs_id')
            ->where('memberjadwal.jadwal_pengampu_id', $id)
            ->get();
        $quantity = quanty_byjadwal::where('jadwal_pengampu_id', $id)->get();

        $kehadiran = Kehadiran_Jadwal::join('users', 'kehadiran__jadwal.mhs_id', '=', 'users.id')
            ->join('quanty_byjadwals', 'kehadiran__jadwal.quantity_byjadwal_id', '=', 'quanty_byjadwals.id')
            ->select('kehadiran__jadwal.*', 'users.name as mhs_nama')
            ->where('quanty_byjadwals.jadwal_pengampu_id', $id)
            ->get();

        $kehadiranRows = Kehadiran_Jadwal::join('quanty_byjadwals', 'kehadiran__jadwal.quantity_byjadwal_id', '=', 'quanty_byjadwals.id')
            ->select('kehadiran__jadwal.*', 'quanty_byjadwals.jadwal_pengampu_id', 'kehadiran__jadwal.status as kehadiran')
            ->where('quanty_byjadwals.jadwal_pengampu_id', $id)
            ->get();

        $kehadiran = [];
        foreach ($kehadiranRows as $row) {
            $kehadiran[$row->mhs_id][$row->quantity_byjadwal_id] = $row->kehadiran;
        }
        return view('feature.assessment-detail', compact('member', 'quantity', 'kehadiran', 'jadwal')); // Return the assessment detail view with the member data
    }

    public function destroy_member($id)
    {
        $member = memberjadwal::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Member deleted successfully'); // Redirect back with success message
    }

    public function store_quantity(Request $request)
    {
        // Validate the request data
        $request->validate([
            'jadwal_pengampu_id' => 'required|exists:jadwal_pengampu,id',
            'deskripsi' => 'required|string',
        ]);

        quanty_byjadwal::create([
            'jadwal_pengampu_id' => $request->jadwal_pengampu_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Member added successfully');
    }

    public function store_kehadiran(Request $request)
    {
        $data = $request->input('kehadiran', []);

        foreach ($data as $mhs_id => $jadwals) {
            foreach ($jadwals as $quantity_id => $status) {
                if ($status) {
                    Kehadiran_Jadwal::updateOrCreate(
                        [
                            'quantity_byjadwal_id' => $quantity_id,
                            'mhs_id' => $mhs_id,
                        ],
                        [
                            'status' => $status,
                        ]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Data kehadiran berhasil disimpan');
    }
}
