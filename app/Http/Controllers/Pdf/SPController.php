<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\RiwayatSpMhs;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SPController extends Controller
{
    public function sp1(Request $request, $id)
    {
        $mhs = User::findOrFail($id);

        $data = [
            'mhs'       => $mhs,
            'tipe'      => $request->tipe,
            'no_surat'  => $request->no_surat,
            'alasan'    => $request->alasan,
            'tenggat'   => $request->tenggat,
        ];

        $pdf = Pdf::loadView('pdf.sp1', compact('mhs', 'data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Surat Peringatan 1 - ' . $mhs->name . '.pdf');
    }

    public function download($id)
    {
        $sp = RiwayatSpMhs::findOrFail($id);
        $mhs = User::findOrFail($sp->mhs_id);

        $data = [
            'mhs'      => $mhs,
            'no_surat' => $sp->no_surat,
            'alasan'   => $sp->alasan,
            'tenggat'  => $sp->tenggat,
            'tipe'  => $sp->perihal,
        ];

        $pdf = Pdf::loadView('pdf.sp1', [
            'mhs'  => $mhs,
            'data' => $data
        ])
            ->setPaper('a4', 'portrait');
            
        return $pdf->download('Surat_Peringatan_' . $mhs->name . '.pdf');
    }
}
