<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaportNilai;
use App\Models\RaportPraktik;
use App\Models\RaportMapelNilai;
use App\Models\MasterMapel;
use App\Models\Siswa;
use App\Models\Enrollment;
use App\Models\MasterTahunAjaran;
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
        
        $tahun = request('tahun_ajaran');
        if ($tahun) {
            session(['selected_tahun_ajaran' => $tahun]);
        } else {
            $tahun = session('selected_tahun_ajaran', MasterTahunAjaran::getAktif() ?: (MasterTahunAjaran::orderBy('urutan', 'desc')->first()?->nama ?: date('y') . '/' . (date('y') + 1)));
        }
        
        $siswa = Enrollment::where('tahun_ajaran', $tahun)
            ->where('kelas', $kelas)
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $raport = RaportNilai::where('kelas', $kelas)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with('siswa')
            ->get()
            ->keyBy('siswa_id');

        $tahunList = MasterTahunAjaran::getListForDropdown();

        return view('admin.raport.by_kelas', compact('kelas', 'siswa', 'raport', 'semester', 'tahun', 'tahunList'));
    }

    public function create(Request $request)
    {
        $kelas = (int) $request->route('kelas');
        $semester = $request->get('semester', 'Ganjil');
        
        $tahun = $request->get('tahun_ajaran');
        if ($tahun) {
            session(['selected_tahun_ajaran' => $tahun]);
        } else {
            $tahun = session('selected_tahun_ajaran', MasterTahunAjaran::getAktif() ?: (MasterTahunAjaran::orderBy('urutan', 'desc')->first()?->nama ?: date('y') . '/' . (date('y') + 1)));
        }
        
        $siswa = Enrollment::where('tahun_ajaran', $tahun)
            ->where('kelas', $kelas)
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $preselectSiswaId = $request->get('siswa_id');

        return view('admin.raport.form', [
            'item' => null,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
            'preselectSiswaId' => $preselectSiswaId,
            'praktik_categories' => $this->getPraktikCategories(),
            'master_mapel' => MasterMapel::where('kelas', $kelas)->where('is_aktif', true)->orderBy('urutan')->get(),
        ]);
    }

    private function getPraktikCategories(): array
    {
        return [
            'PAI' => ['Adzan', 'Iqomah', "Shalat Jum'at"],
            'ADAB' => ['Adab kepada Allah', 'Adab kepada diri sendiri', 'Adab kepada orang tua', 'Adab kepada guru'],
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas' => 'required|integer|in:1,2',
            'semester' => 'required|string|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
            'catatan_wali' => 'nullable|string',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'tanpa_keterangan' => 'nullable|integer|min:0',
            'mapel_nilai' => 'nullable|array',
            'mapel_deskripsi' => 'nullable|array',
        ]);

        $data = $request->only([
            'siswa_id', 'kelas', 'semester', 'tahun_ajaran',
            'catatan_wali',
            'sakit', 'izin', 'tanpa_keterangan',
        ]);

        $raport = RaportNilai::updateOrCreate(
            [
                'siswa_id' => $data['siswa_id'],
                'kelas' => $data['kelas'],
                'semester' => $data['semester'],
                'tahun_ajaran' => $data['tahun_ajaran'],
            ],
            $data
        );

        if ($request->has('praktik')) {
            foreach ($request->praktik as $section => $categories) {
                foreach ($categories as $kategori => $nilaiData) {
                    RaportPraktik::updateOrCreate(
                        [
                            'raport_id' => $raport->id,
                            'section' => $section,
                            'kategori' => $kategori,
                        ],
                        [
                            'nilai' => $nilaiData['nilai'] ?? null,
                            'deskripsi' => $nilaiData['deskripsi'] ?? null,
                        ]
                    );
                }
            }
        }

        if ($request->mapel_nilai) {
            foreach ($request->mapel_nilai as $mapelId => $nilai) {
                RaportMapelNilai::updateOrCreate(
                    ['raport_id' => $raport->id, 'mapel_id' => $mapelId],
                    ['nilai' => $nilai, 'deskripsi' => $request->mapel_deskripsi[$mapelId] ?? null]
                );
            }
        }

        return redirect()->route('admin.raport.byKelas', [
            'kelas' => $data['kelas'],
            'tahun_ajaran' => $data['tahun_ajaran'],
            'semester' => $data['semester']
        ])->with('success', 'Nilai raport berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $item = RaportNilai::with(['siswa', 'praktik', 'mapelNilai'])->findOrFail($id);
        $siswa = Siswa::where('kelas', $item->kelas)->orderBy('nama')->get();
        $master_mapel = MasterMapel::where('kelas', $item->kelas)->where('is_aktif', true)->orderBy('urutan')->get();
        
        $existing_nilai = $item->mapelNilai->pluck('nilai', 'mapel_id')->all();
        $existing_deskripsi = $item->mapelNilai->pluck('deskripsi', 'mapel_id')->all();

        return view('admin.raport.form', [
            'item' => $item,
            'kelas' => $item->kelas,
            'siswa' => $siswa,
            'semester' => $item->semester,
            'tahun_ajaran' => $item->tahun_ajaran,
            'praktik_categories' => $this->getPraktikCategories(),
            'praktik_values' => $item->praktik->groupBy('section')->map(fn($sec) => $sec->keyBy('kategori')),
            'master_mapel' => $master_mapel,
            'existing_nilai' => $existing_nilai,
            'existing_deskripsi' => $existing_deskripsi,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = RaportNilai::findOrFail($id);
        $request->validate([
            'catatan_wali' => 'nullable|string',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'tanpa_keterangan' => 'nullable|integer|min:0',
            'mapel_nilai' => 'nullable|array',
            'mapel_deskripsi' => 'nullable|array',
        ]);

        $data = $request->only([
            'catatan_wali',
            'sakit', 'izin', 'tanpa_keterangan',
        ]);


        $item->update($data);

        if ($request->has('praktik')) {
            foreach ($request->praktik as $section => $categories) {
                foreach ($categories as $kategori => $nilaiData) {
                    RaportPraktik::updateOrCreate(
                        [
                            'raport_id' => $item->id,
                            'section' => $section,
                            'kategori' => $kategori,
                        ],
                        [
                            'nilai' => $nilaiData['nilai'] ?? null,
                            'deskripsi' => $nilaiData['deskripsi'] ?? null,
                        ]
                    );
                }
            }
        }

        if ($request->mapel_nilai) {
            foreach ($request->mapel_nilai as $mapelId => $nilai) {
                RaportMapelNilai::updateOrCreate(
                    ['raport_id' => $item->id, 'mapel_id' => $mapelId],
                    ['nilai' => $nilai, 'deskripsi' => $request->mapel_deskripsi[$mapelId] ?? null]
                );
            }
        }

        return redirect()->route('admin.raport.byKelas', [
            'kelas' => $item->kelas,
            'tahun_ajaran' => $item->tahun_ajaran,
            'semester' => $item->semester
        ])->with('success', 'Nilai raport berhasil diubah.');
    }

    public function cetak(int $kelas)
    {
        $semester = request('semester', 'Ganjil');
        $tahun = request('tahun_ajaran', MasterTahunAjaran::getAktif() ?: (MasterTahunAjaran::orderBy('urutan', 'desc')->first()?->nama ?: date('y') . '/' . (date('y') + 1)));
        $raport = RaportNilai::where('kelas', $kelas)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with(['siswa', 'mapelNilai'])
            ->get()
            ->sortBy(fn ($r) => $r->siswa?->nama);

        $master_mapel = MasterMapel::where('kelas', $kelas)->where('is_aktif', true)->orderBy('urutan')->get();

        return view('admin.raport.cetak', compact('kelas', 'raport', 'semester', 'tahun', 'master_mapel'));
    }

    public function cetakSiswa(string $id)
    {
        $raport = RaportNilai::with(['siswa.infoPribadi', 'mapelNilai.mapel'])->findOrFail($id);
        $siswa = $raport->siswa;
        $master_mapel = MasterMapel::where('kelas', $raport->kelas)->where('is_aktif', true)->orderBy('urutan')->get();
        
        $mapel_values = $raport->mapelNilai->keyBy('mapel_id');

        // Data kehadiran dari database
        $attendance = [
            'sakit' => $raport->sakit ?? 0,
            'izin' => $raport->izin ?? 0,
            'tanpa_keterangan' => $raport->tanpa_keterangan ?? 0,
        ];

        // Ambil nama orang tua dari info pribadi siswa
        $infoPribadi = $siswa->infoPribadi;
        $namaOrtu = $infoPribadi ? ($infoPribadi->nama_ibu ?: $infoPribadi->nama_ayah) : '';

        // Ambil data Kepala Sekolah dari staff_sdm
        $kepalaSekolah = \App\Models\StaffSdm::where('jabatan', 'Kepala Sekolah')->first();

        // Ambil data Wali Kelas dari staff_sdm berdasarkan jabatan
        $jabatanWaliKelas = 'Wali Kelas ' . $raport->kelas;
        $waliKelas = \App\Models\StaffSdm::where('jabatan', $jabatanWaliKelas)->first();

        // Data tanda tangan
        $signatures = [
            'ortu' => $namaOrtu,
            'kepala_sekolah' => $kepalaSekolah ? $kepalaSekolah->nama : 'KASMIDAR, S.Pd',
            'niy_kepala' => $kepalaSekolah && $kepalaSekolah->niy ? $kepalaSekolah->niy : 'NIY. 2403001',
            'wali_kelas' => $waliKelas ? $waliKelas->nama : '',
            'niy_wali' => $waliKelas && $waliKelas->niy ? $waliKelas->niy : '',
        ];

        $tanggal_cetak = now()->locale('id')->translatedFormat('d F Y');

        return view('admin.raport.cetak_siswa', compact('raport', 'siswa', 'attendance', 'signatures', 'tanggal_cetak', 'master_mapel', 'mapel_values'));
    }

    public function cetakPraktik(string $id)
    {
        $raport = RaportNilai::with(['siswa.infoPribadi', 'praktik'])->findOrFail($id);
        $siswa = $raport->raportNilai ? $raport->raportNilai->siswa : $raport->siswa; // Safety check

        // Data for the template provided by user
        $semester = $raport->semester;
        $tahun = $raport->tahun_ajaran;
        $tanggal = now()->locale('id')->translatedFormat('d F Y');
        $kelas = \App\Models\Siswa::getNamaKelas($raport->kelas);

        $praktik_pai = $raport->praktik->where('section', 'PAI')->values()->toArray();
        $praktik_adab = $raport->praktik->where('section', 'ADAB')->values()->toArray();

        // Signatures (reuse logic from cetakSiswa)
        $infoPribadi = $siswa->infoPribadi;
        $namaOrtu = $infoPribadi ? ($infoPribadi->nama_ibu ?: $infoPribadi->nama_ayah) : '_______________';

        $kepalaSekolah = \App\Models\StaffSdm::where('jabatan', 'Kepala Sekolah')->first();
        $jabatanWaliKelas = 'Wali Kelas ' . $raport->kelas;
        $waliKelas = \App\Models\StaffSdm::where('jabatan', $jabatanWaliKelas)->first();

        $data = [
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'praktik_pai' => $praktik_pai,
            'praktik_adab' => $praktik_adab,
            'ortu' => strtoupper($namaOrtu),
            'tanggal' => $tanggal,
            'wali_kelas' => $waliKelas ? $waliKelas->nama : '_______________',
            'niy_wali' => $waliKelas ? $waliKelas->niy : '',
            'kepala_sekolah' => $kepalaSekolah ? $kepalaSekolah->nama : 'KASMIDAR, S.Pd',
            'niy_kepsek' => $kepalaSekolah ? $kepalaSekolah->niy : '2403001',
        ];

        return view('admin.raport.cetak_praktik', $data);
    }

    public function history(string $siswa_id, Request $request)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $reports = RaportNilai::where('siswa_id', $siswa_id)
            ->with('mapelNilai')
            ->orderByRaw("CAST(SUBSTRING_INDEX(tahun_ajaran, '/', 1) AS UNSIGNED) DESC")
            ->orderBy('semester', 'desc')
            ->get();

        $return_params = [
            'kelas' => $request->query('ret_kelas'),
            'tahun' => $request->query('ret_tahun'),
            'semester' => $request->query('ret_semester'),
        ];

        return view('admin.raport.history', compact('siswa', 'reports', 'return_params'));
    }
}
