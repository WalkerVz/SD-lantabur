<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterMapel;
use App\Models\MasterKelas;
use App\Models\MasterMateriJilid;
use App\Models\MasterMateriTahfidz;
use App\Models\MasterPraktik;
use App\Models\RaportPraktik;
use App\Models\RaportJilid;
use App\Models\RaportTahfidz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    // ─── Mapel Umum ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $classes = MasterKelas::orderBy('tingkat')->get();
        $selectedKelas = $request->get('kelas', $classes->first()?->tingkat ?? 1);
        
        $mapels = MasterMapel::where('kelas', $selectedKelas)
            ->orderBy('urutan')
            ->get();

        // Urutan berikutnya untuk default field "Tambah Mapel"
        $nextUrutan = $mapels->max('urutan') + 1;
        if ($nextUrutan < 1) $nextUrutan = 1;

        $tahunAjaranList = \App\Models\MasterTahunAjaran::orderBy('urutan')->orderByDesc('nama')->get();

        return view('admin.mapel.index', compact('classes', 'selectedKelas', 'mapels', 'nextUrutan', 'tahunAjaranList'));
    }

    public function indexPredikat()
    {
        $tahunAjaranList = \App\Models\MasterTahunAjaran::orderBy('urutan')->orderByDesc('nama')->get();
        return view('admin.mapel.predikat', compact('tahunAjaranList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|integer|exists:master_kelas,tingkat',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
        ]);

        $kelas = $request->kelas;
        $urutan = (int) $request->urutan;

        DB::transaction(function () use ($request, $kelas, $urutan) {
            // Geser mapel lain yang urutannya >= urutan baru ke bawah
            MasterMapel::where('kelas', $kelas)
                ->where('urutan', '>=', $urutan)
                ->orderBy('urutan', 'desc')
                ->increment('urutan');

            MasterMapel::create($request->only('nama', 'kelas', 'kkm', 'urutan'));
        });

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $mapel = MasterMapel::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:1',
            'is_aktif' => 'required|boolean',
        ]);

        $oldUrutan = (int) $mapel->urutan;
        $newUrutan = (int) $request->urutan;
        $kelas = $mapel->kelas;

        DB::transaction(function () use ($mapel, $request, $oldUrutan, $newUrutan, $kelas) {
            if ($oldUrutan !== $newUrutan) {
                if ($newUrutan < $oldUrutan) {
                    // Mapel naik ke atas: geser mapel di antara posisi baru & lama ke bawah
                    MasterMapel::where('kelas', $kelas)
                        ->where('id', '!=', $mapel->id)
                        ->whereBetween('urutan', [$newUrutan, $oldUrutan - 1])
                        ->increment('urutan');
                } else {
                    // Mapel turun ke bawah: geser mapel di antara posisi lama & baru ke atas
                    MasterMapel::where('kelas', $kelas)
                        ->where('id', '!=', $mapel->id)
                        ->whereBetween('urutan', [$oldUrutan + 1, $newUrutan])
                        ->decrement('urutan');
                }
            }

            $mapel->update($request->only('nama', 'kkm', 'urutan', 'is_aktif'));
        });

        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mapel = MasterMapel::findOrFail($id);

        DB::transaction(function () use ($mapel) {
            // Hapus semua record nilai terkait (termasuk yang sudah terisi)
            $mapel->nilai()->delete();
            $mapel->delete();
        });

        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    // ─── Praktik ────────────────────────────────────────────────
    public function indexPraktik(Request $request)
    {
        $classes = MasterKelas::orderBy('tingkat')->get();
        $selectedKelas = $request->get('kelas', $classes->first()?->tingkat ?? 1);

        $items = MasterPraktik::where('kelas', $selectedKelas)
            ->orderBy('section')
            ->orderBy('urutan')
            ->get();
            
        return view('admin.mapel.index_praktik', compact('items', 'classes', 'selectedKelas'));
    }

    public function storePraktik(Request $request)
    {
        $request->validate([
            'kelas' => 'required|integer',
            'section' => 'required|string|max:50',
            'kategori' => 'required|string|max:255',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:0',
        ]);

        MasterPraktik::create($request->only('kelas', 'section', 'kategori', 'kkm', 'urutan'));

        return back()->with('success', 'Kategori praktik berhasil ditambahkan.');
    }

    public function updatePraktik(Request $request, $id)
    {
        $item = MasterPraktik::findOrFail($id);
        $request->validate([
            'kelas' => 'required|integer',
            'section' => 'required|string|max:50',
            'kategori' => 'required|string|max:255',
            'kkm' => 'required|integer|min:0|max:100',
            'urutan' => 'required|integer|min:0',
        ]);

        $oldSection = $item->section;
        $oldKategori = $item->kategori;

        DB::transaction(function () use ($item, $request, $oldSection, $oldKategori) {
            $item->update($request->only('kelas', 'section', 'kategori', 'kkm', 'urutan'));

            // Cascade rename ke tabel raport_praktik jika ada perubahan nama/seksi
            if ($oldSection !== $item->section || $oldKategori !== $item->kategori) {
                RaportPraktik::where('section', $oldSection)
                    ->where('kategori', $oldKategori)
                    ->update([
                        'section' => $item->section,
                        'kategori' => $item->kategori,
                    ]);
            }
        });

        return back()->with('success', 'Kategori praktik berhasil diperbarui.');
    }

    public function destroyPraktik($id)
    {
        $item = MasterPraktik::findOrFail($id);

        DB::transaction(function () use ($item) {
            // Hapus semua record di raport_praktik terkait (termasuk yang sudah terisi)
            RaportPraktik::where('section', $item->section)
                ->where('kategori', $item->kategori)
                ->delete();

            $item->delete();
        });
        return back()->with('success', 'Kategori praktik berhasil dihapus.');
    }

    // ─── Jilid ──────────────────────────────────────────────────
    public function indexJilid()
    {
        $items = MasterMateriJilid::orderByRaw("
            CASE jilid
                WHEN 'I' THEN 1
                WHEN 'II' THEN 2
                WHEN 'III' THEN 3
                WHEN 'IV' THEN 4
                WHEN 'V' THEN 5
                WHEN 'VI' THEN 6
                ELSE 100
            END
        ")->orderBy('jilid')->orderBy('urutan')->get();
        return view('admin.mapel.index_jilid', compact('items'));
    }

    public function storeJilid(Request $request)
    {
        $request->validate([
            'jilid' => 'required|string|max:30',
            'materi' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        MasterMateriJilid::create($request->only('jilid', 'materi', 'urutan'));

        return back()->with('success', "Materi Al-Qur'an berhasil ditambahkan.");
    }

    public function updateJilid(Request $request, $id)
    {
        $item = MasterMateriJilid::findOrFail($id);
        $request->validate([
            'jilid' => 'required|string|max:30',
            'materi' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        $item->update($request->only('jilid', 'materi', 'urutan'));

        return back()->with('success', "Materi Al-Qur'an berhasil diperbarui.");
    }

    public function destroyJilid($id)
    {
        $item = MasterMateriJilid::findOrFail($id);

        // Ambil semua raport yang mengandung materi ini
        $allReports = RaportJilid::whereJsonContains('materi', ['materi' => $item->materi])->get();

        // Cleanup: Hapus entry materi dari semua raport siswa (termasuk yang sudah terisi)
        DB::transaction(function () use ($item, $allReports) {
            foreach ($allReports as $r) {
                $materiList = $r->materi ?? [];
                $newList = array_values(array_filter($materiList, function($m) use ($item) {
                    // Filter out the exact match of materi + jilid
                    return !(($m['materi'] ?? '') === $item->materi && strcasecmp($m['jilid'] ?? '', $item->jilid) === 0);
                }));
                
                if (count($materiList) !== count($newList)) {
                    $r->update(['materi' => $newList]);
                }
            }
            $item->delete();
        });

        return back()->with('success', "Materi Al-Qur'an berhasil dihapus.");
    }

    // ─── Tahfidz ────────────────────────────────────────────────
    public function indexTahfidz()
    {
        $items = MasterMateriTahfidz::orderBy('urutan')->get();
        return view('admin.mapel.index_tahfidz', compact('items'));
    }

    public function storeTahfidz(Request $request)
    {
        $request->validate([
            'jilid' => 'required|string|max:50',
            'materi' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        MasterMateriTahfidz::create($request->only('jilid', 'materi', 'urutan'));

        return back()->with('success', 'Materi tahfidz berhasil ditambahkan.');
    }

    public function updateTahfidz(Request $request, $id)
    {
        $item = MasterMateriTahfidz::findOrFail($id);
        $request->validate([
            'jilid' => 'required|string|max:50',
            'materi' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        $item->update($request->only('jilid', 'materi', 'urutan'));

        return back()->with('success', 'Materi tahfidz berhasil diperbarui.');
    }

    public function destroyTahfidz($id)
    {
        $item = MasterMateriTahfidz::findOrFail($id);

        // Ambil semua raport yang mengandung materi ini
        $allReports = RaportTahfidz::whereJsonContains('materi', ['materi' => $item->materi])->get();

        // Cleanup: Hapus entry materi dari semua raport siswa (termasuk yang sudah terisi)
        DB::transaction(function () use ($item, $allReports) {
            foreach ($allReports as $r) {
                $materiList = $r->materi ?? [];
                $newList = array_values(array_filter($materiList, function($m) use ($item) {
                    return !(($m['materi'] ?? '') === $item->materi && strcasecmp($m['jilid'] ?? '', $item->jilid) === 0);
                }));
                
                if (count($materiList) !== count($newList)) {
                    $r->update(['materi' => $newList]);
                }
            }
            $item->delete();
        });

        return back()->with('success', 'Materi tahfidz berhasil dihapus.');
    }
}
