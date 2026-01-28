<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raport_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->unsignedTinyInteger('kelas');
            $table->string('semester', 20); // Ganjil/Genap
            $table->string('tahun_ajaran', 20); // 2024/2025
            // Mapel: bahasa_indonesia, matematika, pendidikan_pancasila, ipas, olahraga, alquran_hadist
            $table->decimal('bahasa_indonesia', 5, 2)->nullable();
            $table->decimal('matematika', 5, 2)->nullable();
            $table->decimal('pendidikan_pancasila', 5, 2)->nullable();
            $table->decimal('ipas', 5, 2)->nullable();
            $table->decimal('olahraga', 5, 2)->nullable();
            $table->decimal('alquran_hadist', 5, 2)->nullable();
            $table->text('catatan_wali')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raport_nilai');
    }
};
