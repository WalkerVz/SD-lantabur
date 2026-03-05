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
        if (!Schema::hasTable('tahun_kelas')) {
            Schema::create('tahun_kelas', function (Blueprint $table) {
                $table->id();
                $table->string('tahun_ajaran', 20);
                $table->integer('kelas');
                $table->foreignId('wali_kelas_id')->nullable()->constrained('staff_sdm')->nullOnDelete();
                $table->timestamps();

                $table->unique(['tahun_ajaran', 'kelas']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_kelas');
    }
};
