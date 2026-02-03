<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('master_tahun_ajaran')->exists()) {
            return;
        }
        DB::table('master_tahun_ajaran')->insert([
            ['nama' => '24/25', 'is_aktif' => false, 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => '25/26', 'is_aktif' => true, 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('master_tahun_ajaran')->truncate();
    }
};
