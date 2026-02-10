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
        Schema::create('master_mapel', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kelas'); // 1 or 2
            $table->integer('kkm')->default(75);
            $table->integer('urutan')->default(1);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_mapel');
    }
};
