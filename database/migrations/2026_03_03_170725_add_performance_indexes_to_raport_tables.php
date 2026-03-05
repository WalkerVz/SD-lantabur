<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->index(['kelas', 'tahun_ajaran', 'semester'], 'raport_nilai_lookup_index');
            $table->index(['siswa_id', 'tahun_ajaran', 'semester'], 'raport_siswa_lookup_index');
        });

        Schema::table('enrollment', function (Blueprint $table) {
            $table->index(['tahun_ajaran', 'kelas'], 'enrollment_lookup_index');
        });

        Schema::table('master_mapel', function (Blueprint $table) {
            $table->index(['kelas', 'is_aktif', 'urutan'], 'mapel_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_mapel', function (Blueprint $table) {
            $table->dropIndex('mapel_lookup_index');
        });

        Schema::table('enrollment', function (Blueprint $table) {
            $table->dropIndex('enrollment_lookup_index');
        });

        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->dropIndex('raport_nilai_lookup_index');
            $table->dropIndex('raport_siswa_lookup_index');
        });
    }
};
