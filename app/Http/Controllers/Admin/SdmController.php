<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SdmExport;
use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use App\Models\StaffSdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SdmController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffSdm::with('spesialisasi');
        if ($request->filled('spesialisasi_id')) {
            $query->where('spesialisasi_id', $request->spesialisasi_id);
        }
        $staff = $query->orderBy('nama')->get();
        $spesialisasi = Spesialisasi::orderBy('nama')->get();
        $totalAll = StaffSdm::count();
        $countBySpesialisasi = StaffSdm::selectRaw('spesialisasi_id, count(*) as total')
            ->groupBy('spesialisasi_id')
            ->get()
            ->keyBy('spesialisasi_id');

        return view('admin.sdm.index', compact('staff', 'spesialisasi', 'countBySpesialisasi', 'totalAll'));
    }

    public function create()
    {
        $spesialisasi = Spesialisasi::orderBy('nama')->get();
        return view('admin.sdm.form', ['item' => null, 'spesialisasi' => $spesialisasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'niy' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'nomor_handphone' => 'nullable|string|max:20',
            'spesialisasi_id' => 'nullable|exists:spesialisasi,id',
            'foto' => 'nullable|image|max:2048',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
        ]);

        $data = $request->only(['nama', 'jabatan', 'niy', 'email', 'nomor_handphone', 'spesialisasi_id', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('staff_sdm', 'public');
        }
        StaffSdm::create($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = StaffSdm::findOrFail($id);
        $spesialisasi = Spesialisasi::orderBy('nama')->get();
        return view('admin.sdm.form', ['item' => $item, 'spesialisasi' => $spesialisasi]);
    }

    public function update(Request $request, string $id)
    {
        $item = StaffSdm::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'niy' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'nomor_handphone' => 'nullable|string|max:20',
            'spesialisasi_id' => 'nullable|exists:spesialisasi,id',
            'foto' => 'nullable|image|max:2048',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
        ]);

        $data = $request->only(['nama', 'jabatan', 'niy', 'email', 'nomor_handphone', 'spesialisasi_id', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('staff_sdm', 'public');
        }
        $item->update($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = StaffSdm::findOrFail($id);
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        try {
            while (ob_get_level()) {
                ob_end_clean();
            }
            $query = StaffSdm::with('spesialisasi')->orderBy('nama');
            if ($request->filled('spesialisasi_id')) {
                $query->where('spesialisasi_id', $request->spesialisasi_id);
            }
            $rows = $query->get();
            $filename = 'data_sdm_' . date('Y-m-d_His') . '.xlsx';

            $path = 'exports/' . $filename;
            Storage::disk('local')->makeDirectory('exports');
            \Maatwebsite\Excel\Facades\Excel::store(new SdmExport($rows), $path, 'local');

            return response()->download(storage_path('app/' . $path), $filename)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.sdm.index')->with('error', 'Export gagal: ' . $e->getMessage());
        }
    }
}
