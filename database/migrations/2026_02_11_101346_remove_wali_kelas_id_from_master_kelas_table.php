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
        Schema::table('master_kelas', function (Blueprint $table) {
            // Drop foreign key constraint terlebih dahulu (jika ada)
            if (Schema::hasColumn('master_kelas', 'wali_kelas_id')) {
                $table->dropForeign(['wali_kelas_id']);
                $table->dropColumn('wali_kelas_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_kelas', function (Blueprint $table) {
            // Restore kolom jika rollback
            $table->unsignedBigInteger('wali_kelas_id')->nullable()->after('nama_surah');
            $table->foreign('wali_kelas_id')->references('id')->on('staff_sdm')->onDelete('set null');
        });
    }
};
