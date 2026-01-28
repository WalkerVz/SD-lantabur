<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaportNilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RaportController extends Controller
{
    public function index(): View
    {
        return view('admin.raport.index');
    }

    public function byKelas(int $kelas)
    {
        $semester = request('semester', 'Ganjil');
        $tahun = request('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $siswa = Siswa::where('kelas', $kelas)->orderBy('nama')->get();
        $raport = RaportNilai::where('kelas', $kelas)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with('siswa')
            ->get()
            ->keyBy('siswa_id');

        return view('admin.raport.by_kelas', compact('kelas', 'siswa', 'raport', 'semester', 'tahun'));
    }

    public function create(Request $request)
    {
        $kelas = (int) $request->route('kelas');
        $semester = $request->get('semester', 'Ganjil');
        $tahun = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $siswa = Siswa::where('kelas', $kelas)->orderBy('nama')->get();
        $preselectSiswaId = $request->get('siswa_id');

        return view('admin.raport.form', [
            'item' => null,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
            'preselectSiswaId' => $preselectSiswaId,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'semester' => 'required|string|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
            'bahasa_indonesia' => 'nullable|numeric|min:0|max:100',
            'matematika' => 'nullable|numeric|min:0|max:100',
            'pendidikan_pancasila' => 'nullable|numeric|min:0|max:100',
            'ipas' => 'nullable|numeric|min:0|max:100',
            'olahraga' => 'nullable|numeric|min:0|max:100',
            'alquran_hadist' => 'nullable|numeric|min:0|max:100',
            'catatan_wali' => 'nullable|string',
        ]);

        $data = $request->only([
            'siswa_id', 'kelas', 'semester', 'tahun_ajaran',
            'bahasa_indonesia', 'matematika', 'pendidikan_pancasila',
            'ipas', 'olahraga', 'alquran_hadist', 'catatan_wali',
        ]);

        RaportNilai::updateOrCreate(
            [
                'siswa_id' => $data['siswa_id'],
                'kelas' => $data['kelas'],
                'semester' => $data['semester'],
                'tahun_ajaran' => $data['tahun_ajaran'],
            ],
            $data
        );

        return redirect()->route('admin.raport.byKelas', $data['kelas'])
            ->with('success', 'Nilai raport berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $item = RaportNilai::with('siswa')->findOrFail($id);
        $siswa = Siswa::where('kelas', $item->kelas)->orderBy('nama')->get();

        return view('admin.raport.form', [
            'item' => $item,
            'kelas' => $item->kelas,
            'siswa' => $siswa,
            'semester' => $item->semester,
            'tahun_ajaran' => $item->tahun_ajaran,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = RaportNilai::findOrFail($id);
        $request->validate([
            'bahasa_indonesia' => 'nullable|numeric|min:0|max:100',
            'matematika' => 'nullable|numeric|min:0|max:100',
            'pendidikan_pancasila' => 'nullable|numeric|min:0|max:100',
            'ipas' => 'nullable|numeric|min:0|max:100',
            'olahraga' => 'nullable|numeric|min:0|max:100',
            'alquran_hadist' => 'nullable|numeric|min:0|max:100',
            'catatan_wali' => 'nullable|string',
        ]);

        $item->update($request->only([
            'bahasa_indonesia', 'matematika', 'pendidikan_pancasila',
            'ipas', 'olahraga', 'alquran_hadist', 'catatan_wali',
        ]));

        return redirect()->route('admin.raport.byKelas', $item->kelas)
            ->with('success', 'Nilai raport berhasil diubah.');
    }

    public function cetak(int $kelas)
    {
        $semester = request('semester', 'Ganjil');
        $tahun = request('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $raport = RaportNilai::where('kelas', $kelas)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with('siswa')
            ->get()
            ->sortBy(fn ($r) => $r->siswa?->nama);

        return view('admin.raport.cetak', compact('kelas', 'raport', 'semester', 'tahun'));
    }
}
