<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_tahun_ajaran', function (Blueprint $table) {
            $table->unsignedTinyInteger('ummi_a')->default(90)->after('min_c');
            $table->unsignedTinyInteger('ummi_bplus')->default(85)->after('ummi_a');
            $table->unsignedTinyInteger('ummi_b')->default(80)->after('ummi_bplus');
            $table->unsignedTinyInteger('ummi_bminus')->default(75)->after('ummi_b');
            $table->unsignedTinyInteger('ummi_cplus')->default(70)->after('ummi_bminus');
            $table->unsignedTinyInteger('ummi_c')->default(65)->after('ummi_cplus');
            $table->unsignedTinyInteger('ummi_cminus')->default(60)->after('ummi_c');
        });
    }

    public function down(): void
    {
        Schema::table('master_tahun_ajaran', function (Blueprint $table) {
            $table->dropColumn([
                'ummi_a', 'ummi_bplus', 'ummi_b', 'ummi_bminus',
                'ummi_cplus', 'ummi_c', 'ummi_cminus'
            ]);
        });
    }
};
