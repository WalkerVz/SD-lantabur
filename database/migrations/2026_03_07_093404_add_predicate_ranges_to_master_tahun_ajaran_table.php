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
        Schema::table('master_tahun_ajaran', function (Blueprint $table) {
            $table->integer('min_a')->default(91)->after('urutan');
            $table->integer('min_b')->default(83)->after('min_a');
            $table->integer('min_c')->default(75)->after('min_b');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_tahun_ajaran', function (Blueprint $table) {
            $table->dropColumn(['min_a', 'min_b', 'min_c']);
        });
    }
};
