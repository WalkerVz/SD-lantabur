<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelas = (int) $request->get('kelas', 1);
        if ($kelas < 1 || $kelas > 6) {
            $kelas = 1;
        }
        $siswa = Siswa::where('kelas', $kelas)->orderBy('nama')->get();
        $countPerKelas = Siswa::selectRaw('kelas, count(*) as total')->groupBy('kelas')->pluck('total', 'kelas');

        return view('admin.siswa.index', compact('siswa', 'kelas', 'countPerKelas'));
    }

    public function create(Request $request)
    {
        $kelas = (int) $request->get('kelas', 1);
        return view('admin.siswa.form', ['item' => null, 'kelas' => $kelas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'nis' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'kelas', 'nis', 'tempat_lahir', 'tanggal_lahir']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        Siswa::create($data);
        return redirect()->route('admin.siswa.index', ['kelas' => $request->kelas])->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Siswa::findOrFail($id);
        return view('admin.siswa.form', ['item' => $item, 'kelas' => $item->kelas]);
    }

    public function update(Request $request, string $id)
    {
        $item = Siswa::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'nis' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'kelas', 'nis', 'tempat_lahir', 'tanggal_lahir']);
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        $item->update($data);
        return redirect()->route('admin.siswa.index', ['kelas' => $request->kelas])->with('success', 'Siswa berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $item = Siswa::findOrFail($id);
        $kelas = $item->kelas;
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        return redirect()->route('admin.siswa.index', ['kelas' => $kelas])->with('success', 'Siswa berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = Siswa::orderBy('kelas')->orderBy('nama');
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        $rows = $query->get();
        $filename = 'data_siswa_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new SiswaExport($rows), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
}
