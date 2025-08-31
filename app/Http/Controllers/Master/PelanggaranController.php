<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPinaltyReward;
use App\Models\Pinalty;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pinalties = MasterPinaltyReward::get();
        return view('master.pelanggaran', compact('pinalties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'tipe' => 'required|string',
            'poin' => 'required|integer',
        ]);

        MasterPinaltyReward::create([
            'jenis' => $request->jenis,
            'tipe' => $request->tipe,
            'poin' => $request->poin,
        ]);

        return redirect()->route('pelanggaran.index')->with('success', 'Punishment/Reward Point added successfully.');
    }

    public function destroy($id)
    {
        $pinalty = MasterPinaltyReward::findOrFail($id);
        $pinalty->delete();

        return redirect()->route('pelanggaran.index')->with('success', 'Punishment/Reward Point deleted successfully.');
    }

    public function getbyId($id)
    {
        $pinalty = MasterPinaltyReward::findOrFail($id);
        return response()->json($pinalty);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string',
            'tipe' => 'required|string',
            'poin' => 'required|integer',
        ]);

        $pinalty = MasterPinaltyReward::findOrFail($id);
        $pinalty->jenis = $request->jenis;
        $pinalty->tipe = $request->tipe;
        $pinalty->poin = $request->poin;
        $pinalty->save();

        return redirect()->route('pelanggaran.index')->with('success', 'Punishment/Reward Point updated successfully.');
    }

}
