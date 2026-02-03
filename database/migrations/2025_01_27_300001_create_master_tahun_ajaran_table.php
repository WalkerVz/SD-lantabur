<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 20)->unique(); // e.g. "25/26"
            $table->boolean('is_aktif')->default(false);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_tahun_ajaran');
    }
};
