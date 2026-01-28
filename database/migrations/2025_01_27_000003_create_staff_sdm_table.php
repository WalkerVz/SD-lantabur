<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_sdm', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan'); // teks bebas
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->foreignId('spesialisasi_id')->nullable()->constrained('spesialisasi')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_sdm');
    }
};
