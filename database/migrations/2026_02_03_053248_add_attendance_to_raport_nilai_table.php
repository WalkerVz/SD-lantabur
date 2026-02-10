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
        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->integer('sakit')->default(0)->after('catatan_wali');
            $table->integer('izin')->default(0)->after('sakit');
            $table->integer('tanpa_keterangan')->default(0)->after('izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->dropColumn(['sakit', 'izin', 'tanpa_keterangan']);
        });
    }
};
