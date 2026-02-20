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
        // 1. Add wali_kelas_id back to master_kelas
        Schema::table('master_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('wali_kelas_id')->nullable()->after('nama_surah');
            $table->foreign('wali_kelas_id')->references('id')->on('staff_sdm')->nullOnDelete();
        });

        // 2. Drop tahun_kelas table
        Schema::dropIfExists('tahun_kelas');
    }

    public function down(): void
    {
        // 1. Create tahun_kelas table again
        Schema::create('tahun_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 10);
            $table->integer('kelas');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('staff_sdm')->nullOnDelete();
            $table->timestamps();

            $table->unique(['tahun_ajaran', 'kelas']);
        });

        // 2. Drop wali_kelas_id from master_kelas
        Schema::table('master_kelas', function (Blueprint $table) {
            $table->dropForeign(['wali_kelas_id']);
            $table->dropColumn('wali_kelas_id');
        });
    }
};
