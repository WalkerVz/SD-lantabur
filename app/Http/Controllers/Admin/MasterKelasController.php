<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterKelas;
use Illuminate\Http\Request;

class MasterKelasController extends Controller
{
    public function index()
    {
        // Pastikan kelas 1-6 ada
        for ($i = 1; $i <= 6; $i++) {
            MasterKelas::firstOrCreate(['tingkat' => $i]);
        }

        $kelas = MasterKelas::orderBy('tingkat')->get();

        return view('admin.master_kelas.index', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_surah' => 'nullable|string|max:50',
        ]);

        $kelas = MasterKelas::findOrFail($id);
        $kelas->update([
            'nama_surah' => $request->nama_surah,
        ]);

        return back()->with('success', 'Nama tambahan untuk Kelas ' . $kelas->tingkat . ' berhasil diperbarui.');
    }
}
