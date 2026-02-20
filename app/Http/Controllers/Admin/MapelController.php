<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterMapel;
use App\Models\MasterKelas;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $classes = MasterKelas::orderBy('tingkat')->get();
        $selectedKelas = $request->get('kelas', $classes->first()?->tingkat ?? 1);
        
        $mapels = MasterMapel::where('kelas', $selectedKelas)
            ->orderBy('urutan')
            ->get();

        return view('admin.mapel.index', compact('classes', 'selectedKelas', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|exists:master_kelas,tingkat',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
        ]);

        MasterMapel::create($request->all());

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $mapel = MasterMapel::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
            'is_aktif' => 'required|boolean',
        ]);

        $mapel->update($request->all());

        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mapel = MasterMapel::findOrFail($id);
        
        // Check if mapel is used in raport
        if ($mapel->nilai()->exists()) {
            return back()->with('error', 'Mata pelajaran tidak dapat dihapus karena sudah digunakan di raport siswa.');
        }

        $mapel->delete();

        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
