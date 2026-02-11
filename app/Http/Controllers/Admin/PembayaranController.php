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
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'siswa_id' => 'required|exists:siswa,id',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2030',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
        ]);

        $p = Pembayaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'siswa_id' => $request->siswa_id,
            'kelas' => $request->kelas,
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

        $pdf = Pdf::loadView('admin.pembayaran.kwitansi', [
            'p' => $p,
            'bulan_str' => $bulanStr,
            'tanggal_str' => $p->tanggal_bayar?->format('d/m/Y') ?? '-',
        ]);
        return $pdf->stream('kwitansi-' . $p->kwitansi_no . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');
        $siswaId = (int) $request->get('siswa_id');
        $kelas = (int) $request->get('kelas');

        if ($siswaId < 1 || $kelas < 1 || $kelas > 6) {
            return redirect()->route('admin.pembayaran.index')->with('error', 'Pilih siswa dan kelas terlebih dahulu.');
        }

        $siswa = Siswa::findOrFail($siswaId);
        $riwayat = Pembayaran::where('tahun_ajaran', $tahunAjaran)
            ->where('siswa_id', $siswaId)
            ->where('kelas', $kelas)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();
        $sppBulanan = BiayaSpp::getNominal($tahunAjaran, $kelas);

        $pdf = Pdf::loadView('admin.pembayaran.export-pdf', [
            'siswa' => $siswa,
            'riwayat' => $riwayat,
            'tahun_ajaran' => $tahunAjaran,
            'kelas' => $kelas,
            'spp_bulanan' => $sppBulanan,
        ]);
        return $pdf->download('riwayat-pembayaran-' . $siswa->nama . '-' . $tahunAjaran . '.pdf');
    }
}
