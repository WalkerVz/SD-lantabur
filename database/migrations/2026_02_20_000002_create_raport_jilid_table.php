<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raport_jilid', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->string('tahun_ajaran', 20);
            $table->string('semester', 10)->default('Ganjil');   // Ganjil / Genap
            $table->string('jilid', 20)->nullable();              // misal: "Jilid 3", "Al-Qur'an"
            $table->text('deskripsi')->nullable();
            $table->string('guru', 100)->nullable();
            $table->json('materi')->nullable();                   // [{jilid, materi, nilai, keterangan}]
            $table->timestamps();

            $table->unique(['siswa_id', 'tahun_ajaran', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raport_jilid');
    }
};
