<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran_Jadwal;
use App\Models\MasterPinaltyReward;
use App\Models\Pinalty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolisticController extends Controller
{
    public function index(Request $request)
    {
        $mhs = User::role('Mahasiswa')->with('roles')->get();

        $nilai_mhs = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
            ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
            ->join('users', 'memberjadwal.mhs_id', '=', 'users.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->select(
                'users.id as mhs_id',
                'users.name as mhs_name',
                'users.nip_nim',
                'users.gender',
                'jadwal_pengampu.id as jadwal_pengampu_id',
                'kegiatan.nama_kegiatan',
                'kegiatan.poin_kegiatan',
                DB::raw("
                CASE 
                    WHEN SUM(CASE WHEN kehadiran__jadwal.status = 'Alfa' THEN 1 ELSE 0 END) > 0 
                    THEN 100 - (SUM(CASE WHEN kehadiran__jadwal.status = 'Alfa' THEN 1 ELSE 0 END) * kegiatan.poin_kegiatan) 
                    ELSE 100 
                END as nilai_kehadiran
            ")
            )
            ->groupBy(
                'users.id',
                'users.name',
                'users.nip_nim',
                'users.gender',
                'jadwal_pengampu.id',
                'kegiatan.nama_kegiatan',
                'kegiatan.poin_kegiatan'
            );
            
        if ($request->filled('search')) {
            $search = $request->search;
            $nilai_mhs->where(function ($query) use ($search) {
                $query->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.nip_nim', 'like', "%{$search}%");
            });
        }

        $nilai_mhs = $nilai_mhs->get();

        foreach ($nilai_mhs as $item) {
            $totalPinalty = DB::table('holistic as p')
                ->join('master_pinalty_rewards as m', function ($join) {
                    $join->on('p.jenis', '=', 'm.jenis')
                        ->on('p.tipe', '=', 'm.tipe');
                })
                ->where('p.user_id', $item->mhs_id)
                ->sum('m.poin');

            $item->nilai_pinalty = $totalPinalty;
            $item->nilai_total = max(-100, min(100, $item->nilai_kehadiran + $totalPinalty));
        }

        return view('feature.holistic', compact('mhs', 'nilai_mhs'));
    }


    public function getData()
    {
        $nilai_mhs = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
            ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
            ->join('users', 'memberjadwal.mhs_id', '=', 'users.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->select(
                'users.id as mhs_id',
                'users.name as mhs_name',
                'users.nip_nim',
                'users.gender',
                'jadwal_pengampu.id as jadwal_pengampu_id',
                'kegiatan.nama_kegiatan',
                'kegiatan.poin_kegiatan',
                DB::raw("
            CASE 
                WHEN SUM(CASE WHEN kehadiran__jadwal.status = 'Alfa' THEN 1 ELSE 0 END) > 0 
                THEN 100 - (SUM(CASE WHEN kehadiran__jadwal.status = 'Alfa' THEN 1 ELSE 0 END) * kegiatan.poin_kegiatan) 
                ELSE 100 
            END as nilai
        ")
            )
            ->groupBy(
                'users.id',
                'users.name',
                'users.nip_nim',
                'users.gender',
                'jadwal_pengampu.id',
                'kegiatan.nama_kegiatan',
                'kegiatan.poin_kegiatan'
            )
            ->get();


        return response()->json($nilai_mhs);
    }

    public function getDetail(Request $request, $id)
    {
        // ambil data mahasiswa sekali saja
        $mahasiswa = User::where('id', $id)
            ->select('name as mhs_name', 'nip_nim')
            ->first();

        $details = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
            ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
            ->join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
            ->join('quanty_byjadwals', 'kehadiran__jadwal.quantity_byjadwal_id', '=', 'quanty_byjadwals.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->where('kehadiran__jadwal.mhs_id', $id)
            ->where('kehadiran__jadwal.status', 'Alfa')
            ->select(
                'users.name as pengampu',
                'quanty_byjadwals.deskripsi as deskripsi',
                'kegiatan.nama_kegiatan as nama_kegiatan',
                'kegiatan.poin_kegiatan as poin_kegiatan',
                'kehadiran__jadwal.status as status'
            );
        
            
        if($request->filled('search')){
            $search = $request->search;
            $details->where('users.name', 'like', "%{$search}%")
                ->orWhere('quanty_byjadwals.deskripsi', 'like', "%{$search}%")
                ->orWhere('kegiatan.nama_kegiatan', 'like', "%{$search}%")
                ->orWhere('kegiatan.poin_kegiatan', 'like', "%{$search}%")
                ->orWhere('kehadiran__jadwal.status', 'like', "%{$search}%");
        }

        $details = $details->get();

        $punishment = Pinalty::where('user_id', $id)
            ->join('master_pinalty_rewards as m', function ($join) {
                $join->on('holistic.jenis', '=', 'm.jenis')
                    ->on('holistic.tipe', '=', 'm.tipe');
            })
            ->select('holistic.*', 'm.poin');

        if($request->filled('searchholistic')){
            $searchholistic = $request->searchholistic;
            $punishment->where('holistic.deskripsi', 'like', "%{$searchholistic}%")
                ->orWhere('holistic.deskripsi', 'like', "%{$searchholistic}%")
                ->orWhere('holistic.jenis', 'like', "%{$searchholistic}%")
                ->orWhere('holistic.tipe', 'like', "%{$searchholistic}%")
                ->orWhere('holistic.tgl', 'like', "%{$searchholistic}%")
                ->orWhere('m.poin', 'like', "%{$searchholistic}%");
        }

        $punishment = $punishment->get();

        $detail = [
            'mhs_name' => $mahasiswa->mhs_name ?? null,
            'mhs_id'   => $id,
            'nip_nim'  => $mahasiswa->nip_nim ?? null,
            'details'  => $details
        ];

        $reward = [
            'mhs_id' => $id,
            'rewards' => $punishment
        ];

        // return response()->json($detail);
        return view('feature.holistic-detail', compact('detail', 'reward'));
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        $request->validate([
            'mhs_id' => 'required',
            'tipe'   => 'required',
            'tgl'    => 'required',
            'jenis'  => 'required',
            'deskripsi' => 'required',
        ]);

        Pinalty::create([
            'user_id'    => $request->mhs_id,
            'tipe'      => $request->tipe,
            'tgl'       => $request->tgl,
            'jenis'     => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data holistic assessment berhasil disimpan.');
    }

    public function destroy($id)
    {
        $pinalty = Pinalty::find($id);
        if (!$pinalty) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $pinalty->delete();
        return redirect()->back()->with('success', 'Data holistic assessment berhasil dihapus.');
    }
}
