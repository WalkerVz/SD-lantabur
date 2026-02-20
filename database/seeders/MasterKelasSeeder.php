<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['tingkat' => 1, 'nama_surah' => 'An-Naas'],
            ['tingkat' => 2, 'nama_surah' => 'Al-Mulk'],
            ['tingkat' => 3, 'nama_surah' => 'Al-Haqqah'],
            ['tingkat' => 4, 'nama_surah' => 'Al-Waqiah'],
            ['tingkat' => 5, 'nama_surah' => 'Al-Mursalat'],
            ['tingkat' => 6, 'nama_surah' => 'An-Naba'],
        ];

        foreach ($classes as $classData) {
            // Hanya seed master_kelas (tingkat + nama_surah)
            // Wali Kelas di-assign otomatis dari SdmController berdasarkan jabatan
            \App\Models\MasterKelas::updateOrCreate(
                ['tingkat' => $classData['tingkat']],
                ['nama_surah' => $classData['nama_surah']]
            );
        }
    }
}
