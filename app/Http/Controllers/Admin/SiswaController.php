<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BiayaSpp;
use App\Models\Enrollment;
use App\Models\InfoPribadiSiswa;
use App\Models\MasterTahunAjaran;
use App\Models\Siswa;
use App\Models\StaffSdm;
use App\Models\TahunKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageOptimization;

class SiswaController extends Controller
{
    use ImageOptimization;
    public static function getTahunAjaranList(): array
    {
        return MasterTahunAjaran::getListForDropdown();
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
            $tahunAjaran = MasterTahunAjaran::getAktif() ?? $listTahun[0] ?? MasterTahunAjaran::getFallback();
            session(['selected_tahun_ajaran' => $tahunAjaran]);
        }

        $rows = [];
        $masterKelas = \App\Models\MasterKelas::orderBy('tingkat')->get();

        // Ambil data Wali Kelas dari TahunKelas untuk tahun yang dipilih
        $waliKelasList = \App\Models\TahunKelas::where('tahun_ajaran', $tahunAjaran)
            ->with('waliKelas')
            ->get()
            ->keyBy('kelas');

        // Optimize N+1: eager load count for enrollments matching the selected year
        $enrollmentCounts = \App\Models\Enrollment::where('tahun_ajaran', $tahunAjaran)
            ->selectRaw('kelas, count(*) as count')
            ->groupBy('kelas')
            ->pluck('count', 'kelas');

        // Optimize N+1: fetch all relevant SPP at once
        $sppData = \App\Models\BiayaSpp::where('tahun_ajaran', $tahunAjaran)
            ->pluck('nominal', 'kelas');

        foreach ($masterKelas as $mKelas) {
            $kelas = $mKelas->tingkat;
            $count = $enrollmentCounts->get($kelas, 0);
            
            // Ambil Wali Kelas dari TahunKelas (Historis)
            $wali = $waliKelasList->get($kelas)?->waliKelas;
            
            // Ambil nominal SPP langsung dari array
            $spp = $sppData->get($kelas, 0);

            $rows[] = (object)[
                'kelas' => $kelas,
                'nama_surah' => $mKelas->nama_surah,
                'jumlah_siswa' => $count,
                'wali_kelas' => $wali,
                'wali_kelas_nama' => $wali ? $wali->nama : '-',
                'spp_bulanan' => $spp,
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
        if (!\App\Models\MasterKelas::where('tingkat', $kelas)->exists()) {
            return response()->json(['siswa' => []]);
        }
        $siswa = Enrollment::where('tahun_ajaran', $tahunAjaran)
            ->where('kelas', $kelas)
            ->with('siswa.infoPribadi')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy(fn ($s) => strtolower($s->nama ?? ''))
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
            'kelas' => 'required|integer|exists:master_kelas,tingkat',
            'nis' => 'nullable|string|max:50|unique:siswa,nis',
            'nisn' => 'nullable|string|max:50|unique:siswa,nisn',
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tahun_ajaran' => 'required|string|max:20',
            'spp' => 'nullable|integer|min:0',
            'biaya_seragam' => 'nullable|integer|min:0',
            'biaya_sarana_prasarana' => 'nullable|integer|min:0',
            'biaya_kegiatan_tahunan' => 'nullable|integer|min:0',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara_kandung' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama', 'nis', 'nisn', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama', 'spp', 'biaya_seragam', 'biaya_sarana_prasarana', 'biaya_kegiatan_tahunan']);
        $data['kelas'] = $request->kelas;
        // Pastikan biaya tidak null
        foreach (['spp','biaya_seragam','biaya_sarana_prasarana','biaya_kegiatan_tahunan'] as $col) {
            if (empty($data[$col])) $data[$col] = 0;
        }
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $this->optimizeAndStore($request->file('foto'), 'siswa');
            if ($fotoPath) {
                $data['foto'] = $fotoPath;
            }
        }

        try {
            $siswa = \Illuminate\Support\Facades\DB::transaction(function () use ($data, $request) {
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

                return $siswa;
            });

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'siswa' => $siswa->fresh(['infoPribadi'])]);
            }
            return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->tahun_ajaran])->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            if (isset($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menyimpan data siswa: ' . $e->getMessage())->withInput();
        }
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
            'kelas' => 'required|integer|exists:master_kelas,tingkat',
            'nis' => 'nullable|string|max:50|unique:siswa,nis,' . $id,
            'nisn' => 'nullable|string|max:50|unique:siswa,nisn,' . $id,
            'jenis_kelamin' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:30',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tahun_ajaran' => 'nullable|string|max:20',
            'spp' => 'nullable|integer|min:0',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara_kandung' => 'nullable|integer|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['nama', 'nis', 'nisn', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama', 'spp', 'biaya_seragam', 'biaya_sarana_prasarana', 'biaya_kegiatan_tahunan']);
        $data['kelas'] = $request->kelas;
        // Pastikan biaya tidak null
        foreach (['spp','biaya_seragam','biaya_sarana_prasarana','biaya_kegiatan_tahunan'] as $col) {
            if (empty($data[$col])) $data[$col] = 0;
        }
        $oldFoto = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($item->foto) {
                $oldFoto = $item->foto;
            }
            $fotoPath = $this->optimizeAndStore($request->file('foto'), 'siswa');
            if ($fotoPath) {
                $data['foto'] = $fotoPath;
            }
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($item, $data, $request, $oldFoto) {
                $oldKelas = $item->kelas;
                $newKelas = (int) $request->kelas;
                $tahunAjaran = $request->tahun_ajaran;

                $item->update($data);

                if ($request->filled('tahun_ajaran')) {
                    Enrollment::updateOrCreate(
                        ['tahun_ajaran' => $tahunAjaran, 'siswa_id' => $item->id],
                        ['kelas' => $newKelas]
                    );

                    // Sync related data if class corrected within the same year
                    if ($oldKelas !== $newKelas) {
                        \App\Models\RaportNilai::where('siswa_id', $item->id)
                            ->where('tahun_ajaran', $tahunAjaran)
                            ->where('kelas', $oldKelas)
                            ->update(['kelas' => $newKelas]);

                        \App\Models\Pembayaran::where('siswa_id', $item->id)
                            ->where('tahun_ajaran', $tahunAjaran)
                            ->where('kelas', $oldKelas)
                            ->update(['kelas' => $newKelas]);
                    }
                }

                $item->infoPribadi()->updateOrCreate(
                    ['siswa_id' => $item->id],
                    $request->only(['nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'anak_ke', 'jumlah_saudara_kandung', 'status'])
                );

                if ($oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            });

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'siswa' => $item->fresh(['infoPribadi'])]);
            }
            return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->tahun_ajaran])->with('success', 'Siswa berhasil diubah.');
        } catch (\Exception $e) {
            if (isset($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->with('error', 'Gagal mengubah data siswa: ' . $e->getMessage())->withInput();
        }
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
        return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $tahunAjaran])->with('success', 'Siswa berhasil dihapus secara permanen.');
    }

    public function removeFromClass(string $id, Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        if (!$tahunAjaran) {
            return response()->json(['success' => false, 'message' => 'Tahun ajaran tidak ditentukan.'], 400);
        }

        Enrollment::where('siswa_id', $id)->where('tahun_ajaran', $tahunAjaran)->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Siswa berhasil dikeluarakan dari kelas.');
    }

    public function exportPdf(Request $request)
    {
        try {
            $tahunAjaran = $request->get('tahun_ajaran');
            $kelas = $request->filled('kelas') ? (int) $request->kelas : null;

            if ($tahunAjaran) {
                $query = Enrollment::where('tahun_ajaran', $tahunAjaran)->with('siswa');
                if ($kelas) {
                    $query->where('kelas', $kelas);
                }
                $enrollments = $query->get();
                $rows = $enrollments->map(fn ($e) => (object) ['siswa' => $e->siswa, 'kelas' => $e->kelas])
                    ->filter(fn ($r) => $r->siswa !== null)
                    ->sortBy(fn ($r) => sprintf('%02d_%s', (int)$r->kelas, strtolower($r->siswa->nama ?? '')))
                    ->values();
            } else {
                $query = Siswa::query()->orderBy('kelas')->orderBy('nama');
                if ($kelas) {
                    $query->where('kelas', $kelas);
                }
                $rows = $query->get()->map(fn ($s) => (object) ['siswa' => $s, 'kelas' => $s->kelas ?? null]);
            }

            $label = $tahunAjaran ? str_replace('/', '-', (string) $tahunAjaran) : '';
            if ($kelas >= 1 && $kelas <= 6) {
                $label .= ($label !== '' ? '_' : '') . ' Kelas ' . $kelas;
            }
            $filename = 'data_siswa_' . ($label ? str_replace(' ', '_', $label) . '_' : '') . date('Y-m-d_His') . '.pdf';

            $pdf = Pdf::loadView('admin.export.siswa-pdf', compact('rows', 'label'));
            return $pdf->download($filename);
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
                ->sortBy(fn ($s) => strtolower($s->nama ?? ''))
                ->values();
        }

        $masterKelas = \App\Models\MasterKelas::orderBy('tingkat')->get();

        return view('admin.siswa.promotion', compact('siswa', 'sourceTahun', 'sourceKelas', 'listTahun', 'masterKelas'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswa,id',
            'target_kelas' => 'required|integer|exists:master_kelas,tingkat',
            'target_tahun_ajaran' => 'required|string|max:20',
        ]);

        try {
            $count = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $count = 0;
                $siswaIds = $request->siswa_ids;
                $targetKelas = $request->target_kelas;
                $targetTahunAjaran = $request->target_tahun_ajaran;

                // Mass update current class of the students
                Siswa::whereIn('id', $siswaIds)->update(['kelas' => $targetKelas]);

                // Record the enrollment for the target year/class
                foreach ($siswaIds as $siswaId) {
                    Enrollment::updateOrCreate(
                        ['tahun_ajaran' => $targetTahunAjaran, 'siswa_id' => $siswaId],
                        ['kelas' => $targetKelas]
                    );
                    $count++;
                }

                return $count;
            });

            return redirect()->route('admin.siswa.index', ['tahun_ajaran' => $request->target_tahun_ajaran])
                ->with('success', "$count siswa berhasil dipindahkan ke Kelas {$request->target_kelas} ({$request->target_tahun_ajaran}).");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memindahkan siswa: ' . $e->getMessage());
        }
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
            ->sortBy(fn ($s) => strtolower($s->nama ?? ''))
            ->values();

        $nama_kelas = Siswa::getNamaKelas($kelas);
        $tanggal_cetak = now()->locale('id')->translatedFormat('d F Y');

        // Ambil Wali Kelas dari TahunKelas (Historis)
        $tahunKelas = \App\Models\TahunKelas::where('tahun_ajaran', $tahun_ajaran)
            ->where('kelas', $kelas)
            ->with('waliKelas')
            ->first();

        $wali_kelas = $tahunKelas && $tahunKelas->waliKelas ? $tahunKelas->waliKelas->nama : '_______________________';

        return view('admin.siswa.cetak_absen', compact('siswa', 'kelas', 'nama_kelas', 'tahun_ajaran', 'tanggal_cetak', 'wali_kelas'));
    }
}
