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
        Schema::table('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('biaya_seragam')->default(0)->nullable()->after('spp');
            $table->unsignedBigInteger('biaya_sarana_prasarana')->default(0)->nullable()->after('biaya_seragam');
            $table->unsignedBigInteger('biaya_kegiatan_tahunan')->default(0)->nullable()->after('biaya_sarana_prasarana');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['biaya_seragam', 'biaya_sarana_prasarana', 'biaya_kegiatan_tahunan']);
        });
    }
};
