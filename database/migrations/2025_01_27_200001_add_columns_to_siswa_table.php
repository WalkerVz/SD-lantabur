<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->after('nis');
            $table->string('jenis_kelamin', 20)->nullable()->after('nisn');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('agama', 30)->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'jenis_kelamin', 'alamat', 'agama']);
        });
    }
};
