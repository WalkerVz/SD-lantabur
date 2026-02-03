<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_sdm', function (Blueprint $table) {
            $table->string('jenis_kelamin', 20)->nullable()->after('nomor_handphone');
            $table->string('tempat_lahir', 100)->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('agama', 30)->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('staff_sdm', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'agama']);
        });
    }
};
