<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran_Jadwal;
use App\Models\Pinalty;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HistoryPinaltyController extends Controller
{
    public function history($id){
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
            )
            ->get();

        $punishment = Pinalty::where('user_id', $id)
            ->join('master_pinalty_rewards as m', function ($join) {
                $join->on('holistic.jenis', '=', 'm.jenis')
                    ->on('holistic.tipe', '=', 'm.tipe');
            })
            ->select('holistic.*', 'm.poin')
            ->get();

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

        $pdf = Pdf::loadView('pdf.historypinalty', compact('detail', 'reward'))->setPaper('a4', 'potrait');
        return $pdf->stream('history-' . $reward['mhs_id'] . '.pdf');
    }
}
