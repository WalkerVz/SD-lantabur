<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RaportNilai;
use App\Models\RaportPraktik;
use App\Models\RaportMapelNilai;
use App\Models\RaportJilid;
use App\Models\RaportTahfidz;
use App\Models\MasterMapel;
use App\Models\Siswa;
use App\Models\Enrollment;
use App\Models\MasterTahunAjaran;
use App\Models\TahunKelas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RaportController extends Controller
{
    public function index(): View
    {
        $classes = \App\Models\MasterKelas::orderBy('tingkat')->get();
        return view('admin.raport.index', compact('classes'));
    }

    public function byKelas(int $kelas)
    {
        [$tahun, $semester] = $this->resolveTahunSemester(request());
        $siswa = $this->getSiswaByKelas($kelas, $tahun);

        $raport = RaportNilai::where('kelas', $kelas)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with(['siswa', 'mapelNilai', 'praktik'])
            ->get()
            ->keyBy('siswa_id');

        $raportJilid = RaportJilid::where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        $raportTahfidz = RaportTahfidz::where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        $tahunList = MasterTahunAjaran::getListForDropdown();

        return view('admin.raport.by_kelas', compact('kelas', 'siswa', 'raport', 'raportJilid', 'raportTahfidz', 'semester', 'tahun', 'tahunList'));
    }

    public function create(Request $request)
    {
        $kelas = (int) $request->route('kelas');
        [$tahun, $semester] = $this->resolveTahunSemester($request);
        $siswa = $this->getSiswaByKelas($kelas, $tahun);

        $preselectSiswaId = $request->get('siswa_id');

        return view('admin.raport.form', [
            'item' => null,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun_ajaran' => $tahun,
            'preselectSiswaId' => $preselectSiswaId,
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
            'kelas' => 'required|integer|exists:master_kelas,tingkat',
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

        try {
            $raport = \Illuminate\Support\Facades\DB::transaction(function () use ($data, $request) {
                $raport = RaportNilai::updateOrCreate(
                    [
                        'siswa_id' => $data['siswa_id'],
                        'kelas' => $data['kelas'],
                        'semester' => $data['semester'],
                        'tahun_ajaran' => $data['tahun_ajaran'],
                    ],
                    $data
                );

                $this->syncRaportDetails($raport, $request);
                return $raport;
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan nilai raport: ' . $e->getMessage())->withInput();
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

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($item, $request) {
                $item->update($request->only(['catatan_wali', 'sakit', 'izin', 'tanpa_keterangan']));
                $this->syncRaportDetails($item, $request);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal merubah nilai raport: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.raport.byKelas', [
            'kelas' => $item->kelas,
            'tahun_ajaran' => $item->tahun_ajaran,
            'semester' => $item->semester
        ])->with('success', 'Nilai raport berhasil diubah.');
    }

    public function editPraktik(string $id)
    {
        $item = RaportNilai::with(['siswa', 'praktik'])->findOrFail($id);

        return view('admin.raport.form_praktik', [
            'item' => $item,
            'praktik_categories' => $this->getPraktikCategories(),
            'praktik_values' => $item->praktik->groupBy('section')->map(fn($sec) => $sec->keyBy('kategori')),
        ]);
    }

    public function updatePraktik(Request $request, string $id)
    {
        $item = RaportNilai::findOrFail($id);

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($item, $request) {
                if ($request->has('praktik')) {
                    foreach ($request->praktik as $section => $categories) {
                        foreach ($categories as $kategori => $nilaiData) {
                            RaportPraktik::updateOrCreate(
                                ['raport_id' => $item->id, 'section' => $section, 'kategori' => $kategori],
                                ['nilai' => $nilaiData['nilai'] ?? null, 'deskripsi' => $nilaiData['deskripsi'] ?? null]
                            );
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan nilai praktik: ' . $e->getMessage());
        }

        return redirect()->route('admin.raport.byKelas', [
            'kelas' => $item->kelas,
            'tahun_ajaran' => $item->tahun_ajaran,
            'semester' => $item->semester
        ])->with('success', 'Nilai praktik berhasil disimpan.');
    }

    public function cetak(int $kelas)
    {
        [$tahun, $semester] = $this->resolveTahunSemester(request());
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

        $meta = $this->getPrintMetadata($raport);
        $signatures = $meta['signatures'];
        $tanggal_cetak = $meta['tanggal'];

        $attendance = [
            'sakit' => $raport->sakit ?? 0,
            'izin' => $raport->izin ?? 0,
            'tanpa_keterangan' => $raport->tanpa_keterangan ?? 0,
        ];

        return view('admin.raport.cetak_siswa', compact('raport', 'siswa', 'attendance', 'signatures', 'tanggal_cetak', 'master_mapel', 'mapel_values'));
    }

    public function cetakSemua(string $id, Request $request)
    {
        $raport = RaportNilai::with('siswa')->findOrFail($id);
        $siswaId = $raport->siswa_id;
        $tahun = $raport->tahun_ajaran;
        $semester = $raport->semester;
        $siswa = $raport->siswa;

        \Illuminate\Support\Facades\View::share('is_cetak_semua', true);
        $htmlPages = [];

        // 1. Rapor Umum
        $htmlPages[] = $this->cetakSiswa($id)->render();

        // 2. Rapor Praktik
        $htmlPages[] = $this->cetakPraktik($id)->render();

        // 3. Rapor Jilid (Jika ada)
        $rj = RaportJilid::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();
        if ($rj) {
            $jilidReq = new Request();
            $jilidReq->merge(['tahun_ajaran' => $tahun, 'semester' => $semester]);
            $htmlPages[] = $this->cetakJilid($siswaId, $jilidReq)->render();
        }

        // 4. Rapor Tahfidz (Jika ada)
        $rt = RaportTahfidz::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();
        if ($rt) {
            $tahfidzReq = new Request();
            $tahfidzReq->merge(['tahun_ajaran' => $tahun, 'semester' => $semester]);
            $htmlPages[] = $this->cetakTahfidz($siswaId, $tahfidzReq)->render();
        }

        return view('admin.raport.cetak_semua', compact('htmlPages', 'siswa'));
    }

    public function cetakPraktik(string $id)
    {
        $raport = RaportNilai::with(['siswa.infoPribadi', 'praktik'])->findOrFail($id);
        $siswa = $raport->siswa;

        // Data for the template provided by user
        $semester = $raport->semester;
        $tahun = $raport->tahun_ajaran;
        $tanggal = now()->locale('id')->translatedFormat('d F Y');
        $kelas = \App\Models\Siswa::getNamaKelas($raport->kelas);

        $praktik_pai = $raport->praktik->where('section', 'PAI')->values()->toArray();
        $praktik_adab = $raport->praktik->where('section', 'ADAB')->values()->toArray();

        $meta = $this->getPrintMetadata($raport);
        $signatures = $meta['signatures'];
        
        $data = [
            'siswa' => $siswa,
            'semester' => $semester,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'praktik_pai' => $praktik_pai,
            'praktik_adab' => $praktik_adab,
            'ortu' => strtoupper($signatures['ortu']),
            'tanggal' => $meta['tanggal'],
            'wali_kelas' => $signatures['wali_kelas'] ?: '_______________',
            'niy_wali' => $signatures['niy_wali'],
            'kepala_sekolah' => $signatures['kepala_sekolah'],
            'niy_kepsek' => str_replace('NIY. ', '', $signatures['niy_kepala']),
        ];

        return view('admin.raport.cetak_praktik', $data);
    }

    public function editJilid(string $siswaId, Request $request)
    {
        $siswa = Siswa::findOrFail($siswaId);
        [$tahun, $semester] = $this->resolveTahunSemester($request);
        $item = RaportJilid::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();

        return view('admin.raport.form_jilid', compact('siswa', 'item', 'tahun', 'semester'));
    }

    public function jilidStore(Request $request)
    {
        $request->validate([
            'siswa_id'     => 'required|exists:siswa,id',
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|string|in:Ganjil,Genap',
            'jilid'        => 'required|string|max:50',
            'guru'         => 'nullable|string|max:100',
            'deskripsi'    => 'nullable|string',
            'materi'       => 'nullable|array',
        ]);

        RaportJilid::updateOrCreate(
            [
                'siswa_id'     => $request->siswa_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ],
            [
                'jilid'     => $request->jilid,
                'guru'      => $request->guru,
                'deskripsi' => $request->deskripsi,
                'materi'    => array_values(array_filter($request->materi ?? [], fn($r) => !empty($r['materi']))),
            ]
        );

        $siswa = Siswa::findOrFail($request->siswa_id);
        $enrollment = \App\Models\Enrollment::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->first();
        return redirect()
            ->route('admin.raport.byKelas', [
                'kelas'        => $enrollment ? $enrollment->kelas : $siswa->kelas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ])
            ->with('success', 'Raport jilid berhasil disimpan.');
    }

    public function jilidUpdate(Request $request, string $id)
    {
        $item = RaportJilid::findOrFail($id);
        $request->validate([
            'jilid'     => 'required|string|max:50',
            'guru'      => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'materi'    => 'nullable|array',
        ]);

        $item->update([
            'jilid'     => $request->jilid,
            'guru'      => $request->guru,
            'deskripsi' => $request->deskripsi,
            'materi'    => array_values(array_filter($request->materi ?? [], fn($r) => !empty($r['materi']))),
        ]);

        $siswa = $item->siswa;
        $enrollment = \App\Models\Enrollment::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $item->tahun_ajaran)
            ->first();
        return redirect()
            ->route('admin.raport.byKelas', [
                'kelas'        => $enrollment ? $enrollment->kelas : $siswa->kelas,
                'tahun_ajaran' => $item->tahun_ajaran,
                'semester'     => $item->semester,
            ])
            ->with('success', 'Raport jilid berhasil diperbarui.');
    }

    public function cetakJilid(string $siswaId, Request $request)
    {
        $siswa = Siswa::with('infoPribadi')->findOrFail($siswaId);
        [$tahun, $semester] = $this->resolveTahunSemester($request);

        // Cari data raport jilid. Kalau belum ada, tampilkan template kosong.
        $raportJilid = RaportJilid::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();

        // Ambil nama wali kelas dari MasterKelas
        $masterKelas = \App\Models\MasterKelas::where('tingkat', $siswa->kelas)->with('waliKelas')->first();
        $guruAlQuran = $raportJilid?->guru
            ?? ($masterKelas?->waliKelas?->nama)
            ?? '_______________';

        // Nama ortu dari info pribadi
        $infoPribadi = $siswa->infoPribadi;
        $namaOrtu = $infoPribadi
            ? ($infoPribadi->nama_ibu ?: $infoPribadi->nama_ayah)
            : '_______________';

        $materi = $raportJilid?->materi ?? [];
        $jilidCounts = [];
        foreach($materi as $item) {
            $j = strtoupper(trim($item['jilid'] ?? '-'));
            $jilidCounts[$j] = ($jilidCounts[$j] ?? 0) + 1;
        }

        return view('admin.raport.cetak_jilid', [
            'tahun'       => $tahun,
            'semester'    => $semester,
            'nama'        => $siswa->nama,
            'kelas'       => \App\Models\Siswa::getNamaKelas($siswa->kelas),
            'jilid'       => $raportJilid?->jilid ?? '-',
            'deskripsi'   => $raportJilid?->deskripsi ?? '',
            'materi'      => $materi,
            'jilidCounts' => $jilidCounts,
            'guru'        => $guruAlQuran,
            'ortu'        => strtoupper($namaOrtu),
            'tanggal'     => now()->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function formTahfidz(string $siswaId, Request $request)
    {
        $siswa = Siswa::findOrFail($siswaId);
        [$tahun, $semester] = $this->resolveTahunSemester($request);
        $item = RaportTahfidz::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();

        return view('admin.raport.form_tahfidz', compact('siswa', 'item', 'tahun', 'semester'));
    }

    public function tahfidzStore(Request $request)
    {
        $request->validate([
            'siswa_id'     => 'required|exists:siswa,id',
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|string|in:Ganjil,Genap',
            'guru'         => 'nullable|string|max:100',
            'deskripsi'    => 'nullable|string',
            'materi'       => 'nullable|array',
        ]);

        RaportTahfidz::updateOrCreate(
            [
                'siswa_id'     => $request->siswa_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ],
            [
                'guru'      => $request->guru,
                'deskripsi' => $request->deskripsi,
                'materi'    => array_values($request->materi ?? []),
            ]
        );

        $siswa = Siswa::findOrFail($request->siswa_id);
        $enrollment = \App\Models\Enrollment::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->first();
        return redirect()
            ->route('admin.raport.byKelas', [
                'kelas'        => $enrollment ? $enrollment->kelas : $siswa->kelas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester'     => $request->semester,
            ])
            ->with('success', 'Raport Tahfidz berhasil disimpan.');
    }

    public function tahfidzUpdate(Request $request, string $id)
    {
        $item = RaportTahfidz::findOrFail($id);
        $request->validate([
            'guru'      => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'materi'    => 'nullable|array',
        ]);

        $item->update([
            'guru'      => $request->guru,
            'deskripsi' => $request->deskripsi,
            'materi'    => array_values($request->materi ?? []),
        ]);

        $siswa = $item->siswa;
        $enrollment = \App\Models\Enrollment::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $item->tahun_ajaran)
            ->first();
        return redirect()
            ->route('admin.raport.byKelas', [
                'kelas'        => $enrollment ? $enrollment->kelas : $siswa->kelas,
                'tahun_ajaran' => $item->tahun_ajaran,
                'semester'     => $item->semester,
            ])
            ->with('success', 'Raport Tahfidz berhasil diperbarui.');
    }

    public function cetakTahfidz(string $siswaId, Request $request)
    {
        $siswa = Siswa::with('infoPribadi')->findOrFail($siswaId);
        [$tahun, $semester] = $this->resolveTahunSemester($request);

        $tahfidz = RaportTahfidz::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahun)
            ->where('semester', $semester)
            ->first();

        $masterKelas = \App\Models\MasterKelas::where('tingkat', $siswa->kelas)->with('waliKelas')->first();
        $guruTahfidz = $tahfidz?->guru
            ?? ($masterKelas?->waliKelas?->nama)
            ?? '_______________';

        $infoPribadi = $siswa->infoPribadi;
        $namaOrtu = $infoPribadi
            ? ($infoPribadi->nama_ibu ?: $infoPribadi->nama_ayah)
            : '_______________';

        $kepalaSekolah = \App\Models\StaffSdm::where('jabatan', 'Kepala Sekolah')->first();
        $namaKepsek = $kepalaSekolah ? $kepalaSekolah->nama : 'KASMIDAR, S.Pd';
        $niyKepsek = $kepalaSekolah && $kepalaSekolah->niy ? $kepalaSekolah->niy : 'NIY. 2403001';

        // Pastikan ada prefix "NIY. " jika belum ada
        if ($niyKepsek && !str_starts_with(strtoupper($niyKepsek), 'NIY.')) {
            $niyKepsek = 'NIY. ' . $niyKepsek;
        }

        return view('admin.raport.cetak_tahfidz', [
            'tahun'    => $tahun,
            'semester' => $semester,
            'nama'     => $siswa->nama,
            'kelas'    => \App\Models\Siswa::getNamaKelas($siswa->kelas),
            'deskripsi'=> $tahfidz?->deskripsi ?? '',
            'materi'   => $tahfidz?->materi ?? [],
            'guru'     => $guruTahfidz,
            'ortu'     => strtoupper($namaOrtu),
            'kepala_sekolah' => strtoupper($namaKepsek),
            'niy_kepsek' => $niyKepsek,
            'tanggal'  => now()->locale('id')->translatedFormat('d F Y'),
        ]);
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

    private function resolveTahunSemester(Request $request): array
    {
        $semester = $request->get('semester', 'Ganjil');
        $tahun = $request->get('tahun_ajaran');
        
        if ($tahun) {
            session(['selected_tahun_ajaran' => $tahun]);
        } else {
            $tahun = session('selected_tahun_ajaran', MasterTahunAjaran::getAktif() ?: (MasterTahunAjaran::orderBy('urutan', 'desc')->first()?->nama ?: MasterTahunAjaran::getFallback()));
        }

        return [$tahun, $semester];
    }

    private function getSiswaByKelas(int $kelas, string $tahun)
    {
        return Enrollment::where('tahun_ajaran', $tahun)
            ->where('kelas', $kelas)
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();
    }

    private function syncRaportDetails(RaportNilai $raport, Request $request): void
    {
        if ($request->has('praktik')) {
            foreach ($request->praktik as $section => $categories) {
                foreach ($categories as $kategori => $nilaiData) {
                    RaportPraktik::updateOrCreate(
                        ['raport_id' => $raport->id, 'section' => $section, 'kategori' => $kategori],
                        ['nilai' => $nilaiData['nilai'] ?? null, 'deskripsi' => $nilaiData['deskripsi'] ?? null]
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
    }

    private function getPrintMetadata(RaportNilai $raport): array
    {
        $siswa = $raport->siswa;
        $infoPribadi = $siswa->infoPribadi;
        $namaOrtu = $infoPribadi ? ($infoPribadi->nama_ibu ?: $infoPribadi->nama_ayah) : '_______________';

        $kepalaSekolah = \App\Models\StaffSdm::where('jabatan', 'Kepala Sekolah')->first();
        
        // Ambil Wali Kelas dari MasterKelas
        $masterKelas = \App\Models\MasterKelas::where('tingkat', $raport->kelas)->with('waliKelas')->first();
        $waliKelas = $masterKelas?->waliKelas;

        return [
            'signatures' => [
                'ortu' => $namaOrtu,
                'kepala_sekolah' => $kepalaSekolah ? $kepalaSekolah->nama : 'KASMIDAR, S.Pd',
                'niy_kepala' => $kepalaSekolah && $kepalaSekolah->niy ? $kepalaSekolah->niy : 'NIY. 2403001',
                'wali_kelas' => $waliKelas ? $waliKelas->nama : '',
                'niy_wali' => $waliKelas && $waliKelas->niy ? $waliKelas->niy : '',
            ],
            'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
        ];
    }
}
