<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\StaffSdm;
use App\Models\Siswa;
use App\Models\Enrollment;
use App\Models\MasterTahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = StaffSdm::count();
        
        $tahunAjaranAktif = MasterTahunAjaran::getAktif() ?? (date('y') . '/' . (date('y') + 1));
        $totalSiswa = Enrollment::where('tahun_ajaran', $tahunAjaranAktif)->count();
        
        $totalBerita = Berita::count();

        // Data Web Traffic
        $pengunjungHariIni = \App\Models\WebTraffic::whereDate('date', today())->value('visits') ?? 0;
        $pengunjungBulanIni = \App\Models\WebTraffic::whereMonth('date', date('m'))->whereYear('date', date('Y'))->sum('visits');
        $totalPengunjung = \App\Models\WebTraffic::sum('visits');

        // Data Grafik 7 Hari Terakhir
        $grafikTraffic = \App\Models\WebTraffic::where('date', '>=', today()->subDays(6))
            ->orderBy('date', 'asc')
            ->get();
            
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateString = today()->subDays($i)->format('Y-m-d');
            $chartLabels[] = today()->subDays($i)->format('d M');
            
            $visit = $grafikTraffic->first(function ($item) use ($dateString) {
                $itemDate = is_string($item->date) ? $item->date : $item->date->format('Y-m-d');
                return str_starts_with($itemDate, $dateString);
            });
            $chartData[] = $visit ? $visit->visits : 0;
        }

        return view('admin.dashboard', compact(
            'totalGuru', 'totalSiswa', 'totalBerita', 
            'pengunjungHariIni', 'pengunjungBulanIni', 'totalPengunjung', 'chartLabels', 'chartData'
        ));
    }
}
