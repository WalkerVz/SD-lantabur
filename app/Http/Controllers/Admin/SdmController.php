<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesialisasi;
use App\Models\StaffSdm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $staff = StaffSdm::create($data);
        
        // Auto-assign sebagai Wali Kelas berdasarkan jabatan
        $this->syncWaliKelasFromJabatan($staff);
        
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
        
        // Auto-assign sebagai Wali Kelas berdasarkan jabatan
        $this->syncWaliKelasFromJabatan($item);
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = StaffSdm::findOrFail($id);
        
        // Cleanup assignment Wali Kelas sebelum delete
        // Agar tidak ada orphaned foreign key di tahun_kelas
        \App\Models\TahunKelas::where('wali_kelas_id', $item->id)
            ->update(['wali_kelas_id' => null]);
        
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        try {
            $query = StaffSdm::with('spesialisasi')->orderBy('nama');
            if ($request->filled('spesialisasi_id')) {
                $query->where('spesialisasi_id', $request->spesialisasi_id);
            }
            $rows = $query->get();
            $pdf = Pdf::loadView('admin.export.sdm-pdf', compact('rows'));
            return $pdf->download('data_sdm_' . date('Y-m-d_His') . '.pdf');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.sdm.index')->with('error', 'Export gagal: ' . $e->getMessage());
        }
    }

    /**
     * Auto-sync Wali Kelas berdasarkan jabatan
     */
    /**
     * Auto-sync Wali Kelas berdasarkan jabatan
     */
    private function syncWaliKelasFromJabatan(StaffSdm $staff): void
    {
        // 1. Hapus assignment lama untuk staff ini (dari kelas mana pun)
        \App\Models\MasterKelas::where('wali_kelas_id', $staff->id)
            ->update(['wali_kelas_id' => null]);

        // 2. Deteksi kelas dari jabatan (contoh: "Wali Kelas 3" -> 3)
        if (preg_match('/Wali Kelas (\d+)/', $staff->jabatan, $matches)) {
            $kelas = (int) $matches[1];
            if ($kelas >= 1 && $kelas <= 6) {
                // 3. Update MasterKelas langsung
                //    Otomatis overwrite jika ada wali kelas lama (karena kolom di tabel hanya satu)
                \App\Models\MasterKelas::where('tingkat', $kelas)
                    ->update(['wali_kelas_id' => $staff->id]);
            }
        }
    }
}
