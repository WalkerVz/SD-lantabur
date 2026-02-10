<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\InfoPribadiSiswa;
use App\Models\MasterTahunAjaran;
use App\Models\Siswa;
use App\Models\StaffSdm;
use App\Models\TahunKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public static function getTahunAjaranList(): array
    {
        $fromMaster = MasterTahunAjaran::getListForDropdown();
        $fromEnrollment = Enrollment::select('tahun_ajaran')->distinct()->orderByDesc('tahun_ajaran')->pluck('tahun_ajaran')->all();
        $merged = array_unique(array_merge($fromMaster, $fromEnrollment));
        rsort($merged);

        return empty($merged) ? [date('y') . '/' . (date('y') + 1)] : array_values($merged);
    }

    public function index(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $listTahun = self::getTahunAjaranList();

        if ($tahunAjaran) {
            session(['selected_tahun_ajaran' => $tahunAjaran]);
        } else {
            $tahunAjaran = session('selected_tahun_ajaran');
        }

        if (! $tahunAjaran || ! in_array($tahunAjaran, $listTahun)) {
            $tahunAjaran = MasterTahunAjaran::getAktif() ?? $listTahun[0] ?? (date('y') . '/' . (date('y') + 1));
            session(['selected_tahun_ajaran' => $tahunAjaran]);
        }

        $rows = [];
        for ($kelas = 1; $kelas <= 2; $kelas++) {
            $count = Enrollment::where('tahun_ajaran', $tahunAjaran)->where('kelas', $kelas)->count();
            
            // Auto-detect wali kelas dari staff_sdm berdasarkan jabatan
            $jabatanWaliKelas = 'Wali Kelas ' . $kelas;
            $wali = StaffSdm::where('jabatan', $jabatanWaliKelas)->first();
            
            $rows[] = (object)[
                'kelas' => $kelas,
                'jumlah_siswa' => $count,
                'wali_kelas' => $wali,
                'wali_kelas_nama' => $wali ? $wali->nama : '-',
            ];
        }

        return view('admin.siswa.index', [
            'rows' => $rows,
            'tahun_ajaran' => $tahunAjaran,
            'list_tahun' => $listTahun,
        ]);
    }

    public function listByKelas(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $kelas = (int) $request->get('kelas');
        if ($kelas < 1 || $kelas > 2) {
            return response()->json(['siswa' => []]);
        }
        $siswa = Enrollment::where('tahun_ajaran', $tahunAjaran)
            ->where('kelas', $kelas)
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();
        return response()->json(['siswa' => $siswa]);
    }

    public function show(string $id)
    {
        $item = Siswa::with('infoPribadi')->findOrFail($id);
        return view('admin.siswa.show', compact('item'));
    }

    public function create(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $kelas = (int) $request->get('kelas', 1);
        return view('admin.siswa.form', ['item' => null, 'kelas' => $kelas, 'tahun_ajaran' => $tahunAjaran]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|in:1,2',
            'nis' => 'nullable|string|max:50',
            'nisn' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'tahun_ajaran' => 'required|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara_kandung' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama', 'nis', 'nisn', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        $data['kelas'] = $request->kelas;
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        $siswa = Siswa::create($data);

        Enrollment::firstOrCreate(
            ['tahun_ajaran' => $request->tahun_ajaran, 'siswa_id' => $siswa->id],
            ['kelas' => $request->kelas]
        );
        Enrollment::where('tahun_ajaran', $request->tahun_ajaran)->where('siswa_id', $siswa->id)->update(['kelas' => $request->kelas]);

        $siswa->infoPribadi()->updateOrCreate(
            ['siswa_id' => $siswa->id],
            $request->only(['nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'anak_ke', 'jumlah_saudara_kandung', 'status'])
        );

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'siswa' => $siswa->fresh(['infoPribadi'])]);
        }
        return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->tahun_ajaran])->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Siswa::with('infoPribadi')->findOrFail($id);
        $tahunAjaran = request('tahun_ajaran', date('y') . '/' . (date('y') + 1));
        $enrollment = Enrollment::where('siswa_id', $item->id)->where('tahun_ajaran', $tahunAjaran)->first();
        $kelas = $enrollment ? $enrollment->kelas : $item->kelas;
        return view('admin.siswa.form', ['item' => $item, 'kelas' => $kelas, 'tahun_ajaran' => $tahunAjaran]);
    }

    public function update(Request $request, string $id)
    {
        $item = Siswa::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|in:1,2',
            'nis' => 'nullable|string|max:50',
            'nisn' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'tahun_ajaran' => 'nullable|string|max:20',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara_kandung' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama', 'nis', 'nisn', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        $data['kelas'] = $request->kelas;
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        $item->update($data);

        if ($request->filled('tahun_ajaran')) {
            Enrollment::where('tahun_ajaran', $request->tahun_ajaran)->where('siswa_id', $item->id)->update(['kelas' => $request->kelas]);
        }

        $item->infoPribadi()->updateOrCreate(
            ['siswa_id' => $item->id],
            $request->only(['nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'anak_ke', 'jumlah_saudara_kandung', 'status'])
        );

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'siswa' => $item->fresh(['infoPribadi'])]);
        }
        return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->tahun_ajaran])->with('success', 'Siswa berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = Siswa::findOrFail($id);
        $tahunAjaran = $request->get('tahun_ajaran');
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $tahunAjaran])->with('success', 'Siswa berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        try {
            while (ob_get_level()) {
                ob_end_clean();
            }
            $tahunAjaran = $request->get('tahun_ajaran');
            $kelas = $request->filled('kelas') ? (int) $request->kelas : null;

            if ($tahunAjaran) {
                $query = Enrollment::where('tahun_ajaran', $tahunAjaran)->with('siswa');
                if ($kelas >= 1 && $kelas <= 2) {
                    $query->where('kelas', $kelas);
                }
                $enrollments = $query->get();
                $rows = $enrollments->map(fn ($e) => (object) ['siswa' => $e->siswa, 'kelas' => $e->kelas])
                    ->filter(fn ($r) => $r->siswa !== null)
                    ->sortBy(fn ($r) => $r->siswa->nama ?? '')
                    ->values();
            } else {
                $query = Siswa::query()->orderBy('nama');
                if ($kelas >= 1 && $kelas <= 2) {
                    $query->where('kelas', $kelas);
                }
                $rows = $query->get()->map(fn ($s) => (object) ['siswa' => $s, 'kelas' => $s->kelas ?? null]);
            }

            $label = $tahunAjaran ? str_replace('/', '-', (string) $tahunAjaran) : '';
            if ($kelas >= 1 && $kelas <= 2) {
                $label .= ($label !== '' ? '_' : '') . 'kelas-' . $kelas;
            }
            $filename = 'data_siswa_' . ($label !== '' ? $label . '_' : '') . date('Y-m-d_His') . '.xlsx';

            $path = 'exports/' . $filename;
            Storage::disk('local')->makeDirectory('exports');
            Excel::store(new SiswaExport($rows), $path, 'local');

            return response()->download(storage_path('app/' . $path), $filename)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->get('tahun_ajaran')])
                ->with('error', 'Export gagal: ' . $e->getMessage());
        }
    }

    public function promotion(Request $request)
    {
        $sourceTahun = $request->get('source_tahun_ajaran', MasterTahunAjaran::getAktif());
        $sourceKelas = $request->get('source_kelas');
        $listTahun = self::getTahunAjaranList();

        $siswa = [];
        if ($sourceTahun && $sourceKelas) {
            $siswa = Enrollment::where('tahun_ajaran', $sourceTahun)
                ->where('kelas', $sourceKelas)
                ->with('siswa')
                ->get()
                ->pluck('siswa')
                ->filter()
                ->sortBy('nama')
                ->values();
        }

        return view('admin.siswa.promotion', compact('siswa', 'sourceTahun', 'sourceKelas', 'listTahun'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswa,id',
            'target_kelas' => 'required|integer|in:1,2',
            'target_tahun_ajaran' => 'required|string|max:20',
        ]);

        $count = 0;
        foreach ($request->siswa_ids as $siswaId) {
            $siswa = Siswa::find($siswaId);
            if ($siswa) {
                // Update current class of the student
                $siswa->update(['kelas' => $request->target_kelas]);

                // Record the enrollment for the target year/class
                Enrollment::updateOrCreate(
                    ['tahun_ajaran' => $request->target_tahun_ajaran, 'siswa_id' => $siswaId],
                    ['kelas' => $request->target_kelas]
                );
                $count++;
            }
        }

        return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->target_tahun_ajaran])
            ->with('success', "$count siswa berhasil dipindahkan ke Kelas {$request->target_kelas} ({$request->target_tahun_ajaran}).");
    }

    public function cetakAbsen(string $kelas)
    {
        $tahun_ajaran = request('tahun_ajaran', session('selected_tahun_ajaran', MasterTahunAjaran::getAktif()));
        
        $siswa = Enrollment::where('tahun_ajaran', $tahun_ajaran)
            ->where('kelas', $kelas)
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $nama_kelas = Siswa::getNamaKelas($kelas);
        $tanggal_cetak = now()->locale('id')->translatedFormat('d F Y');

        // Deteksi Wali Kelas (cocokkan dengan index)
        $jabatanWaliKelas = 'Wali Kelas ' . $kelas;
        $wali = StaffSdm::where('jabatan', $jabatanWaliKelas)->first();
        $wali_kelas = $wali ? $wali->nama : '_______________________';

        return view('admin.siswa.cetak_absen', compact('siswa', 'kelas', 'nama_kelas', 'tahun_ajaran', 'tanggal_cetak', 'wali_kelas'));
    }
}
