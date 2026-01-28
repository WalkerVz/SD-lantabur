<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\RaportNilai;
use App\Models\Siswa;
use App\Models\Spesialisasi;
use App\Models\StaffSdm;
use App\Models\StrukturOrganisasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@sdlantabur.sch.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        if (!$admin->wasRecentlyCreated) {
            $admin->update(['password' => Hash::make('admin123')]);
        }

        if (Spesialisasi::exists()) {
            return;
        }

        $sp = [];
        foreach (['Kepala Sekolah', 'Guru Umum', 'Pengajar Al-Quran', 'Administrasi'] as $n) {
            $sp[$n] = Spesialisasi::create(['nama' => $n]);
        }

        StaffSdm::insert([
            ['nama' => 'Ustadz Angga Tri Kumala, S.E.,M.M', 'jabatan' => 'Kepala Sekolah SDIT Nizhammuddin', 'email' => 'angga.trikumala.scout@gmail.com', 'spesialisasi_id' => $sp['Kepala Sekolah']->id, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ustadz Ali Sahbana, S. Ag', 'jabatan' => 'Wakil Kepala sekolah', 'email' => 'alikepenuhanhilir@gmail.com', 'spesialisasi_id' => $sp['Pengajar Al-Quran']->id, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ustadzah Puji Lestari S. Pd. I', 'jabatan' => 'Walas Kelas VI', 'email' => 'ipuji667@yahoo.com', 'spesialisasi_id' => $sp['Guru Umum']->id, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ustadzah Febria Syabatini', 'jabatan' => 'Guru Kelas IV', 'email' => 'febria@example.com', 'spesialisasi_id' => $sp['Guru Umum']->id, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ustadzah Dila Roza', 'jabatan' => 'Guru Kelas III', 'email' => 'dilaroza@example.com', 'spesialisasi_id' => $sp['Guru Umum']->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        StrukturOrganisasi::insert([
            ['nama' => 'Ir. H. Zulkifli Said, M.Si', 'jabatan' => 'Ketua Yayasan Nizhamuddin', 'level' => 1, 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dr. Ahmad Fauzi', 'jabatan' => 'Kepala Divisi Keuangan', 'level' => 2, 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Siti Aminah, S.Pd', 'jabatan' => 'Kepala Divisi Pendidikan', 'level' => 2, 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $siswaKelas = [];
        foreach ([1,2,3,4,5,6] as $k) {
            for ($i = 1; $i <= 5; $i++) {
                $siswaKelas[] = Siswa::create([
                    'nama' => 'Siswa Kelas ' . $k . ' - ' . $i,
                    'kelas' => $k,
                    'nis' => 'NIS' . $k . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'tempat_lahir' => 'Pekanbaru',
                    'tanggal_lahir' => now()->subYears(7)->subMonths($k),
                ]);
            }
        }

        $kategoriBerita = ['Akademik', 'Kegiatan', 'Prestasi', 'Pengumuman', 'Akademik', 'Kegiatan', 'Prestasi', 'Pengumuman'];
        for ($i = 1; $i <= 8; $i++) {
            Berita::create([
                'judul' => 'Berita SD Lantabur #' . $i,
                'kategori' => $kategoriBerita[$i - 1] ?? null,
                'isi' => 'Lorem ipsum contoh berita untuk mengisi halaman berita sekolah. Konten berita dapat dikelola dari halaman admin.',
                'published_at' => now()->subDays($i),
            ]);
        }

        $tahun = date('Y') . '/' . (date('Y') + 1);
        foreach (Siswa::whereIn('kelas', [1,2])->get() as $s) {
            RaportNilai::create([
                'siswa_id' => $s->id,
                'kelas' => $s->kelas,
                'semester' => 'Ganjil',
                'tahun_ajaran' => $tahun,
                'bahasa_indonesia' => rand(70, 95),
                'matematika' => rand(72, 98),
                'pendidikan_pancasila' => rand(75, 92),
                'ipas' => rand(70, 90),
                'olahraga' => rand(80, 98),
                'alquran_hadist' => rand(78, 96),
            ]);
        }
    }
}
