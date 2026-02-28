<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiayaSpp;
use App\Models\Enrollment;
use App\Models\MasterTahunAjaran;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public const JENIS_PEMBAYARAN = [
        'spp' => 'SPP',
        'seragam' => 'Seragam',
        'sarana_prasarana' => 'Sarana & Prasarana',
        'kegiatan_tahunan' => 'Kegiatan Tahunan',
    ];

    public static function getTahunAjaranList(): array
    {
        $fromMaster = MasterTahunAjaran::getListForDropdown();
        $fromPembayaran = Pembayaran::select('tahun_ajaran')->distinct()->pluck('tahun_ajaran')->all();
        $merged = array_unique(array_merge($fromMaster, $fromPembayaran));
        rsort($merged);
        return empty($merged) ? [date('y') . '/' . (date('y') + 1)] : array_values($merged);
    }

    public function index(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $listTahun = self::getTahunAjaranList();
        if (!$tahunAjaran || !in_array($tahunAjaran, $listTahun)) {
            $tahunAjaran = MasterTahunAjaran::getAktif() ?? $listTahun[0] ?? (date('y') . '/' . (date('y') + 1));
        }
        $kelas = (int) $request->get('kelas', 0);
        $siswaId = (int) $request->get('siswa_id', 0);

        $siswaList = collect();
        $riwayat = collect();
        $siswaTerpilih = null;
        $sppBulanan = 0;

        if ($kelas >= 1 && $kelas <= 6) {
            $siswaList = Enrollment::where('tahun_ajaran', $tahunAjaran)
                ->where('kelas', $kelas)
                ->with('siswa')
                ->get()
                ->pluck('siswa')
                ->filter()
                ->sortBy('nama')
                ->values();
            $sppBulanan = BiayaSpp::getNominal($tahunAjaran, $kelas);

            if ($siswaId > 0) {
                $siswaTerpilih = Siswa::find($siswaId);
                if ($siswaTerpilih) {
                    $riwayat = Pembayaran::where('tahun_ajaran', $tahunAjaran)
                        ->where('siswa_id', $siswaId)
                        ->where('kelas', $kelas)
                        ->orderByDesc('tahun')
                        ->orderByDesc('bulan')
                        ->get();
                }
            }
        }

        return view('admin.pembayaran.index', [
            'tahun_ajaran' => $tahunAjaran,
            'list_tahun' => $listTahun,
            'kelas' => $kelas,
            'siswa_id' => $siswaId,
            'siswa_list' => $siswaList,
            'siswa_terpilih' => $siswaTerpilih,
            'riwayat' => $riwayat,
            'spp_bulanan' => $sppBulanan,
            'jenis_pembayaran_list' => self::JENIS_PEMBAYARAN,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'siswa_id' => 'required|exists:siswa,id',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'jenis_pembayaran' => 'required|string|in:spp,seragam,sarana_prasarana,kegiatan_tahunan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2030',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
        ]);

        $p = Pembayaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'siswa_id' => $request->siswa_id,
            'kelas' => $request->kelas,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'nominal' => (int) round($request->nominal),
            'status' => $request->status,
            'tanggal_bayar' => $request->filled('tanggal_bayar') ? $request->tanggal_bayar : now(),
            'kwitansi_no' => Pembayaran::generateKwitansiNo(),
            'keterangan' => $request->keterangan,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $p->id]);
        }
        return redirect()->route('admin.pembayaran.index', [
            'tahun_ajaran' => $request->tahun_ajaran,
            'kelas' => $request->kelas,
            'siswa_id' => $request->siswa_id,
        ])->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function kwitansi(int $id)
    {
        $p = Pembayaran::with('siswa')->findOrFail($id);
        $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulanStr = $bulanNama[$p->bulan] ?? $p->bulan;

        return view('admin.pembayaran.kwitansi', [
            'p' => $p,
            'bulan_str' => $bulanStr,
            'tanggal_str' => $p->tanggal_bayar?->format('d/m/Y') ?? '-',
            'jenis_pembayaran' => self::JENIS_PEMBAYARAN[$p->jenis_pembayaran] ?? 'SPP',
        ]);
    }

    public function edit(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $jenis_pembayaran_list = self::JENIS_PEMBAYARAN;

        return view('admin.pembayaran.edit', compact('pembayaran', 'jenis_pembayaran_list'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
            'tanggal_bayar' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jenis_pembayaran' => 'required|in:spp,seragam,sarana_prasarana,kegiatan_tahunan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2030',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
            'status' => $request->status,
            'tanggal_bayar' => $request->tanggal_bayar,
            'keterangan' => $request->keterangan,
        ]);

        if ($pembayaran->status === 'lunas' && empty($pembayaran->kwitansi_no)) {
            $pembayaran->update([
                'kwitansi_no' => Pembayaran::generateKwitansiNo()
            ]);
        }

        return redirect()->route('admin.pembayaran.index', [
            'tahun_ajaran' => $pembayaran->tahun_ajaran,
            'kelas' => $pembayaran->kelas,
            'siswa_id' => $pembayaran->siswa_id
        ])->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(int $id, Request $request)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswaId = $pembayaran->siswa_id;
        $kelas = $pembayaran->kelas;
        $tahunAjaran = $pembayaran->tahun_ajaran;
        
        $pembayaran->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.pembayaran.index', [
            'tahun_ajaran' => $tahunAjaran,
            'kelas' => $kelas,
            'siswa_id' => $siswaId,
        ])->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $siswaId = (int) $request->get('siswa_id');
        $kelas = (int) $request->get('kelas');
        $jenis = $request->get('jenis_pembayaran', 'spp');

        if ($siswaId < 1 || $kelas < 1 || $kelas > 6 || !array_key_exists($jenis, self::JENIS_PEMBAYARAN)) {
            return redirect()->route('admin.pembayaran.index')->with('error', 'Parameter tidak valid.');
        }

        $siswa = Siswa::findOrFail($siswaId);
        $riwayat = Pembayaran::where('tahun_ajaran', $tahunAjaran)
            ->where('siswa_id', $siswaId)
            ->where('kelas', $kelas)
            ->where('jenis_pembayaran', $jenis)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();
        
        $sppBulanan = BiayaSpp::getNominal($tahunAjaran, $kelas);
        
        $namaJenis = self::JENIS_PEMBAYARAN[$jenis] ?? 'SPP';
        $filename = 'laporan_pembayaran_' . $jenis . '_' . str_replace('/', '-', $tahunAjaran) . '_' . $siswa->nama . '_Kelas' . $kelas . '_' . date('Y-m-d_His') . '.pdf';
        
        $pdf = Pdf::loadView('admin.pembayaran.export-pdf', [
            'siswa' => $siswa,
            'riwayat' => $riwayat,
            'tahun_ajaran' => $tahunAjaran,
            'kelas' => $kelas,
            'spp_bulanan' => $sppBulanan,
            'jenis' => $jenis,
            'nama_jenis' => $namaJenis,
        ])->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }

    public function rekapPdfPerKelas(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $kelas = (int) $request->get('kelas');
        $jenis = $request->get('jenis_pembayaran', 'spp');

        if (!$tahunAjaran || $kelas < 1 || $kelas > 6 || !array_key_exists($jenis, self::JENIS_PEMBAYARAN)) {
            return redirect()->route('admin.pembayaran.index')->with('error', 'Parameter tidak valid.');
        }

        $siswaList = Enrollment::where('tahun_ajaran', $tahunAjaran)
            ->where('kelas', $kelas)
            ->with(['siswa.pembayaran' => function($q) use ($tahunAjaran, $kelas, $jenis) {
                $q->where('tahun_ajaran', $tahunAjaran)
                  ->where('kelas', $kelas)
                  ->where('jenis_pembayaran', $jenis)
                  ->orderBy('bulan');
            }])
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('nama')
            ->values();

        $namaJenis = self::JENIS_PEMBAYARAN[$jenis] ?? 'SPP';
        $filename = 'rekap_pembayaran_' . $jenis . '_Kelas' . $kelas . '_' . str_replace('/', '-', $tahunAjaran) . '_' . date('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('admin.pembayaran.rekap-pdf', [
            'siswa_list' => $siswaList,
            'tahun_ajaran' => $tahunAjaran,
            'kelas' => $kelas,
            'jenis' => $jenis,
            'nama_jenis' => $namaJenis,
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
