<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\StaffSdm;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = StaffSdm::count();
        $totalSiswa = Siswa::count();
        $totalBerita = Berita::count();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalBerita'));
    }
}
