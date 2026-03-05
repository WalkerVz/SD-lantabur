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

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalBerita'));
    }
}
