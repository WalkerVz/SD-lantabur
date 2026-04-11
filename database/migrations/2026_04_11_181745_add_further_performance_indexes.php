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
        Schema::table('siswa', function (Blueprint $table) {
            $table->index('nama', 'siswa_nama_index');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->index('jenis_pembayaran', 'pembayaran_jenis_index');
        });

        Schema::table('raport_mapel_nilai', function (Blueprint $table) {
            $table->index(['raport_id', 'mapel_id'], 'mapel_nilai_lookup_index');
        });

        Schema::table('raport_praktik', function (Blueprint $table) {
            $table->index('raport_id', 'praktik_raport_index');
        });

        Schema::table('raport_jilid', function (Blueprint $table) {
            $table->index(['siswa_id', 'tahun_ajaran', 'semester'], 'jilid_lookup_index');
        });

        Schema::table('raport_tahfidz', function (Blueprint $table) {
            $table->index(['siswa_id', 'tahun_ajaran', 'semester'], 'tahfidz_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raport_tahfidz', function (Blueprint $table) {
            $table->dropIndex('tahfidz_lookup_index');
        });

        Schema::table('raport_jilid', function (Blueprint $table) {
            $table->dropIndex('jilid_lookup_index');
        });

        Schema::table('raport_praktik', function (Blueprint $table) {
            $table->dropIndex('praktik_raport_index');
        });

        Schema::table('raport_mapel_nilai', function (Blueprint $table) {
            $table->dropIndex('mapel_nilai_lookup_index');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropIndex('pembayaran_jenis_index');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropIndex('siswa_nama_index');
        });
    }
};
