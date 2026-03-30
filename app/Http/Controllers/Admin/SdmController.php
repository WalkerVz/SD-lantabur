<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\SdmExport;
use App\Models\StaffSdm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageOptimization;
use Maatwebsite\Excel\Facades\Excel;

class SdmController extends Controller
{
    use ImageOptimization;
    public function index(Request $request)
    {
        $tahunAktif = \App\Models\MasterTahunAjaran::getAktif();
        $query = StaffSdm::with(['tahunKelas' => function($q) use ($tahunAktif) {
            $q->where('tahun_ajaran', $tahunAktif);
        }]);
        $allStaff = $query->get();

        // Sort berdasarkan prioritas jabatan: Kepala Sekolah → Wakil → Wali Kelas → Guru Bidang Studi → Staff Administrasi → lainnya → Satpam
        $jabatanPriority = function ($jabatan) {
            $jabatan = strtolower($jabatan ?? '');
            if (str_contains($jabatan, 'kepala sekolah') && !str_contains($jabatan, 'wakil')) return 0;
            if (str_contains($jabatan, 'wakil kepala') || str_contains($jabatan, 'wakil')) return 1;
            if (str_contains($jabatan, 'wali kelas')) return 2;
            if (str_contains($jabatan, 'guru bidang studi')) return 3;
            if (str_contains($jabatan, 'staff administrasi')) return 4;
            if (str_contains($jabatan, 'satpam')) return 999;
            return 900;
        };

        $staff = $allStaff
            ->sortBy(function ($s) use ($jabatanPriority) {
                $p = $jabatanPriority($s->jabatan);
                $n = strtolower(trim((string) ($s->nama ?? '')));
                return str_pad((string) $p, 4, '0', STR_PAD_LEFT) . '|' . $n;
            })
            ->values();

        $totalAll = StaffSdm::count();
        return view('admin.sdm.index', compact('staff', 'totalAll'));
    }

    public function create()
    {
        return view('admin.sdm.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang_studi' => 'nullable|required_if:jabatan,Guru Bidang Studi|string|max:255',
            'niy' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'nomor_handphone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
        ]);

        $data = $request->only(['nama', 'jabatan', 'bidang_studi', 'niy', 'email', 'nomor_handphone', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        if (($data['jabatan'] ?? '') !== 'Guru Bidang Studi') {
            $data['bidang_studi'] = null;
        }
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->optimizeAndStore($request->file('foto'), 'staff_sdm');
        }
        $staff = StaffSdm::create($data);
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.sdm.index')->with('success', 'Data SDM berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = StaffSdm::findOrFail($id);
        return view('admin.sdm.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = StaffSdm::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang_studi' => 'nullable|required_if:jabatan,Guru Bidang Studi|string|max:255',
            'niy' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'nomor_handphone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
        ]);

        $data = $request->only(['nama', 'jabatan', 'bidang_studi', 'niy', 'email', 'nomor_handphone', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        if (($data['jabatan'] ?? '') !== 'Guru Bidang Studi') {
            $data['bidang_studi'] = null;
        }
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $this->optimizeAndStore($request->file('foto'), 'staff_sdm');
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
        
        // Cleanup assignment Wali Kelas sebelum delete
        \App\Models\TahunKelas::where('wali_kelas_id', $item->id)->update(['wali_kelas_id' => null]);
        
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
            $allStaff = StaffSdm::query()->get();

            // Sort berdasarkan prioritas jabatan sama seperti di halaman web
            $jabatanPriority = function ($jabatan) {
                $jabatan = strtolower($jabatan ?? '');
                if (str_contains($jabatan, 'kepala sekolah') && !str_contains($jabatan, 'wakil')) return 0;
                if (str_contains($jabatan, 'wakil kepala') || str_contains($jabatan, 'wakil')) return 1;
                if (str_contains($jabatan, 'wali kelas')) return 2;
                if (str_contains($jabatan, 'guru bidang studi')) return 3;
                if (str_contains($jabatan, 'staff administrasi')) return 4;
                if (str_contains($jabatan, 'satpam')) return 999;
                return 900;
            };

            $rows = $allStaff
                ->sortBy(function ($s) use ($jabatanPriority) {
                    $p = $jabatanPriority($s->jabatan);
                    $n = strtolower(trim((string) ($s->nama ?? '')));
                    return str_pad((string) $p, 4, '0', STR_PAD_LEFT) . '|' . $n;
                })
                ->values();

            $pdf = Pdf::loadView('admin.export.sdm-pdf', compact('rows'));
            return $pdf->download('data_sdm_' . date('Y-m-d_His') . '.pdf');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.sdm.index')->with('error', 'Export gagal: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $allStaff = StaffSdm::query()->get();

        // Sort berdasarkan prioritas jabatan sama seperti di halaman web
        $jabatanPriority = function ($jabatan) {
            $jabatan = strtolower($jabatan ?? '');
            if (str_contains($jabatan, 'kepala sekolah') && !str_contains($jabatan, 'wakil')) return 0;
            if (str_contains($jabatan, 'wakil kepala') || str_contains($jabatan, 'wakil')) return 1;
            if (str_contains($jabatan, 'wali kelas')) return 2;
            if (str_contains($jabatan, 'guru bidang studi')) return 3;
            if (str_contains($jabatan, 'staff administrasi')) return 4;
            if (str_contains($jabatan, 'satpam')) return 999;
            return 900;
        };

        $rows = $allStaff
            ->sortBy(function ($s) use ($jabatanPriority) {
                $p = $jabatanPriority($s->jabatan);
                $n = strtolower(trim((string) ($s->nama ?? '')));
                return str_pad((string) $p, 4, '0', STR_PAD_LEFT) . '|' . $n;
            })
            ->values();

        return Excel::download(new SdmExport($rows), 'data_sdm_' . date('Y-m-d_His') . '.xlsx');
    }
}
