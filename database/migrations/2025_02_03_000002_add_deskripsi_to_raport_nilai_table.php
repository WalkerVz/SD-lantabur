<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('raport_nilai', function (Blueprint $table) {
            // Tambah kolom deskripsi untuk setiap mata pelajaran
            $table->text('deskripsi_pai')->nullable()->after('alquran_hadist');
            $table->text('deskripsi_literasi')->nullable()->after('deskripsi_pai');
            $table->text('deskripsi_sains')->nullable()->after('deskripsi_literasi');
            $table->text('deskripsi_adab')->nullable()->after('deskripsi_sains');
        });
    }

    public function down(): void
    {
        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_pai', 'deskripsi_literasi', 'deskripsi_sains', 'deskripsi_adab']);
        });
    }
};
