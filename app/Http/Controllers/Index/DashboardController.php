<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengampu;
use App\Models\Kegiatan;
use App\Models\Kehadiran_Jadwal;
use App\Models\Pinalty;
use App\Models\RiwayatSpMhs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->hasRole('Mahasiswa')) {
            $id = Auth::user()->id;
            $details = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
                ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
                ->join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
                ->join('quanty_byjadwals', 'kehadiran__jadwal.quantity_byjadwal_id', '=', 'quanty_byjadwals.id')
                ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
                ->where('kehadiran__jadwal.mhs_id', $id)
                ->where('kehadiran__jadwal.status', 'Alfa')
                ->select(
                    'kegiatan.nama_kegiatan',
                    'quanty_byjadwals.deskripsi',
                    'kegiatan.poin_kegiatan',
                    'kehadiran__jadwal.created_at'
                )
                ->get();

            $punishment = Pinalty::where('user_id', $id)
                ->join('master_pinalty_rewards as m', function ($join) {
                    $join->on('holistic.jenis', '=', 'm.jenis')
                        ->on('holistic.tipe', '=', 'm.tipe');
                })
                ->select('holistic.jenis', 'holistic.tipe', 'm.poin', 'holistic.created_at')
                ->get();

            $dataset = [];

            foreach ($details as $d) {
                $dataset[] = [
                    'x' => $d->created_at->format('Y-m-d H:i:s'),
                    'y' => -(int) $d->poin_kegiatan,
                    'label' => $d->nama_kegiatan . ' - ' . $d->deskripsi,
                    'type' => 'kegiatan'
                ];
            }

            foreach ($punishment as $p) {
                $dataset[] = [
                    'x' => $p->created_at->format('Y-m-d H:i:s'),
                    'y' => (int) $p->poin,
                    'label' => $p->jenis . ' - ' . $p->tipe,
                    'type' => 'punishment'
                ];
            }

            usort($dataset, function ($a, $b) {
                return strtotime($a['x']) <=> strtotime($b['x']);
            });
            $nilai_mhs = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
                ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
                ->join('users', 'memberjadwal.mhs_id', '=', 'users.id')
                ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
                ->where('users.id', $id)
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
                )
                ->first();

            if ($nilai_mhs) {
                $totalPinalty = DB::table('holistic as p')
                    ->join('master_pinalty_rewards as m', function ($join) {
                        $join->on('p.jenis', '=', 'm.jenis')
                            ->on('p.tipe', '=', 'm.tipe');
                    })
                    ->where('p.user_id', $nilai_mhs->mhs_id)
                    ->sum('m.poin') ?? 0;

                $nilai_mhs->nilai_pinalty = $totalPinalty;
                $nilai_mhs->nilai_total = $nilai_mhs->nilai_kehadiran !== null
                    ? max(-100, min(100, $nilai_mhs->nilai_kehadiran + $totalPinalty))
                    : 100;
            } else {
                $nilai_mhs = (object) [
                    'mhs_id'        => $id,
                    'mhs_name'      => User::find($id)?->name,
                    'nip_nim'       => User::find($id)?->nip_nim,
                    'gender'        => User::find($id)?->gender,
                    'status'        => User::find($id)?->status,
                    'nilai_pinalty' => 0,
                    'nilai_total'   => 100, // default
                ];
            }

            $riwayat_sp = RiwayatSpMhs::where('mhs_id', $id)
                ->orderBy('created_at')
                ->get();

            return view('dashboard.mhs', compact('dataset', 'nilai_mhs', 'riwayat_sp'));
        }

        $user   = Role::withCount('users')->get();
        $jadwal = JadwalPengampu::select('hari', DB::raw('count(*) as total'))
            ->groupBy('hari')
            ->get();

        return view('dashboard.index', compact('user', 'jadwal'));
    }

    public function json($id)
    {
        $details = Kehadiran_Jadwal::join('memberjadwal', 'kehadiran__jadwal.mhs_id', '=', 'memberjadwal.mhs_id')
            ->join('jadwal_pengampu', 'memberjadwal.jadwal_pengampu_id', '=', 'jadwal_pengampu.id')
            ->join('users', 'jadwal_pengampu.pengampu', '=', 'users.id')
            ->join('quanty_byjadwals', 'kehadiran__jadwal.quantity_byjadwal_id', '=', 'quanty_byjadwals.id')
            ->join('kegiatan', 'jadwal_pengampu.kegiatan_id', '=', 'kegiatan.id')
            ->where('kehadiran__jadwal.mhs_id', $id)
            ->where('kehadiran__jadwal.status', 'Alfa')
            ->select(
                'kegiatan.nama_kegiatan',
                'quanty_byjadwals.deskripsi',
                'kegiatan.poin_kegiatan',
                'kehadiran__jadwal.created_at'
            )
            ->get();

        $punishment = Pinalty::where('user_id', $id)
            ->join('master_pinalty_rewards as m', function ($join) {
                $join->on('holistic.jenis', '=', 'm.jenis')
                    ->on('holistic.tipe', '=', 'm.tipe');
            })
            ->select('holistic.jenis', 'holistic.tipe', 'm.poin', 'holistic.created_at')
            ->get();

        $dataset = [];

        // data dari kehadiran
        foreach ($details as $d) {
            $dataset[] = [
                'x' => $d->created_at->format('Y-m-d H:i:s'),
                'y' => (int) $d->poin_kegiatan,
                'label' => $d->nama_kegiatan . ' - ' . $d->deskripsi,
                'type' => 'kegiatan'
            ];
        }

        // data dari pinalty
        foreach ($punishment as $p) {
            $dataset[] = [
                'x' => $p->created_at->format('Y-m-d H:i:s'),
                'y' => (int) $p->poin,
                'label' => $p->jenis . ' - ' . $p->tipe,
                'type' => 'punishment'
            ];
        }

        // urutkan berdasarkan timestamp
        usort($dataset, function ($a, $b) {
            return strtotime($a['x']) <=> strtotime($b['x']);
        });

        return response()->json($dataset);
    }

    public function download_raport()
    {
        $filePath = public_path('assets/asset/Rapot.pdf');

        if (!file_exists($filePath)) {
            abort(404, 'File raport tidak ditemukan.');
        }

        $fileName = 'Raport_Mahasantri.pdf';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
