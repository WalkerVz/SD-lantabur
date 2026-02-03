<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 20);
            $table->unsignedTinyInteger('kelas');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('staff_sdm')->nullOnDelete();
            $table->timestamps();
            $table->unique(['tahun_ajaran', 'kelas']);
        });

        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 20);
            $table->unsignedTinyInteger('kelas');
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['tahun_ajaran', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment');
        Schema::dropIfExists('tahun_kelas');
    }
};
