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
            $toDrop = ['ipas', 'olahraga', 'tahfiz', 'jilid', 'praktik'];
            foreach ($toDrop as $col) {
                if (Schema::hasColumn('raport_nilai', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raport_nilai', function (Blueprint $table) {
            $table->decimal('ipas', 5, 2)->nullable();
            $table->decimal('olahraga', 5, 2)->nullable();
            $table->json('tahfiz')->nullable();
            $table->json('jilid')->nullable();
            $table->json('praktik')->nullable();
        });
    }
};
