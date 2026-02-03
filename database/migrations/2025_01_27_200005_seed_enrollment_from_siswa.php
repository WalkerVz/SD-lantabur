<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tahun = date('y');
        $tahunNext = $tahun + 1;
        $tahunAjaran = $tahun . '/' . $tahunNext;

        foreach ([1, 2, 3, 4, 5, 6] as $kelas) {
            if (! DB::table('tahun_kelas')->where('tahun_ajaran', $tahunAjaran)->where('kelas', $kelas)->exists()) {
                DB::table('tahun_kelas')->insert([
                    'tahun_ajaran' => $tahunAjaran,
                    'kelas' => $kelas,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $siswa = DB::table('siswa')->get();
        foreach ($siswa as $s) {
            $exists = DB::table('enrollment')
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('siswa_id', $s->id)
                ->exists();
            if (! $exists) {
                DB::table('enrollment')->insert([
                    'tahun_ajaran' => $tahunAjaran,
                    'kelas' => $s->kelas,
                    'siswa_id' => $s->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // optional: remove seeded enrollment
    }
};
