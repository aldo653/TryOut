<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
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
}
