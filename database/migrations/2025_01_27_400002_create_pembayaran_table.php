<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 10);
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->unsignedTinyInteger('kelas');
            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            $table->decimal('nominal', 12, 0);
            $table->enum('status', ['lunas', 'belum_lunas'])->default('lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->string('kwitansi_no', 50)->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->index(['tahun_ajaran', 'siswa_id', 'kelas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
