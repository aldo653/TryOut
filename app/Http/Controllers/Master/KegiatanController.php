<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(){
        $kegiatan = Kegiatan::all(); // Fetch all activities
        return view('master.kegiatan', compact('kegiatan')); // Return the kegiatan view with the activities
    }

    public function getbyId($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer',
        ]);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'poin_kegiatan' => $request->poin,
        ]);

        return redirect()->back()->with('success', 'Kegiatan created successfully.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer',
        ]);

        $kegiatan->nama_kegiatan = $request->nama;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->poin_kegiatan = $request->poin;
        $kegiatan->save();

        return redirect()->back()->with('success', 'Kegiatan updated successfully.');
    }
}
