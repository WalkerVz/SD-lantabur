<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_spp', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 10);
            $table->unsignedTinyInteger('kelas');
            $table->decimal('nominal', 12, 0)->default(0);
            $table->timestamps();
            $table->unique(['tahun_ajaran', 'kelas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_spp');
    }
};
