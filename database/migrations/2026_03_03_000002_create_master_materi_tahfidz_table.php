<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_materi_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->string('jilid', 50);
            $table->string('materi', 255);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        $data = [
            // Jilid 1
            ['jilid' => '1', 'materi' => 'An Naas', 'urutan' => 1],
            ['jilid' => '1', 'materi' => 'Al Falaq', 'urutan' => 2],
            ['jilid' => '1', 'materi' => 'Al Ikhlas', 'urutan' => 3],
            ['jilid' => '1', 'materi' => 'Al Lahab', 'urutan' => 4],
            // Jilid 2
            ['jilid' => '2', 'materi' => 'An Nasr', 'urutan' => 5],
            ['jilid' => '2', 'materi' => 'Al Kafirun', 'urutan' => 6],
            ['jilid' => '2', 'materi' => 'Al Kautsar', 'urutan' => 7],
            // Jilid 3
            ['jilid' => '3', 'materi' => "Al Ma'un", 'urutan' => 8],
            ['jilid' => '3', 'materi' => 'Al Quraisy', 'urutan' => 9],
            ['jilid' => '3', 'materi' => 'Al Fiil', 'urutan' => 10],
            // Jilid 4
            ['jilid' => '4', 'materi' => 'Al Humazah', 'urutan' => 11],
            ['jilid' => '4', 'materi' => "Al 'Asr", 'urutan' => 12],
            ['jilid' => '4', 'materi' => 'At Takatsur', 'urutan' => 13],
            // Jilid 5
            ['jilid' => '5', 'materi' => "Al Qori'ah", 'urutan' => 14],
            ['jilid' => '5', 'materi' => "Al 'Adiyat", 'urutan' => 15],
            // Jilid 6
            ['jilid' => '6', 'materi' => 'Al Zalzalah', 'urutan' => 16],
            ['jilid' => '6', 'materi' => 'Al Bayyinah', 'urutan' => 17],
            // Al Qur'an
            ["jilid" => "Al Qur'an", 'materi' => 'Al Qodr', 'urutan' => 18],
            ["jilid" => "Al Qur'an", 'materi' => "Al 'Alaq", 'urutan' => 19],
            // Ghorib 1
            ['jilid' => 'Ghorib 1', 'materi' => 'At Tiin', 'urutan' => 20],
            ['jilid' => 'Ghorib 1', 'materi' => 'Al Insyiroh', 'urutan' => 21],
            ['jilid' => 'Ghorib 1', 'materi' => 'Adh Dhuha', 'urutan' => 22],
            // Ghorib 2
            ['jilid' => 'Ghorib 2', 'materi' => 'Al Lail', 'urutan' => 23],
            ['jilid' => 'Ghorib 2', 'materi' => 'Asy Syams', 'urutan' => 24],
            // Tajwid 1
            ['jilid' => 'Tajwid 1', 'materi' => 'Al Balad', 'urutan' => 25],
            ['jilid' => 'Tajwid 1', 'materi' => 'Al Fajr', 'urutan' => 26],
            // Tajwid 2
            ['jilid' => 'Tajwid 2', 'materi' => 'Al Ghosyiyah', 'urutan' => 27],
            ['jilid' => 'Tajwid 2', 'materi' => "Al A'la", 'urutan' => 28],
            // Pengembangan 1
            ['jilid' => 'Pengembangan 1', 'materi' => 'Ath Thoriq', 'urutan' => 29],
            ['jilid' => 'Pengembangan 1', 'materi' => 'Al Buruj', 'urutan' => 30],
            ['jilid' => 'Pengembangan 1', 'materi' => 'Al Insyiqoq', 'urutan' => 31],
            ['jilid' => 'Pengembangan 1', 'materi' => 'Al Mutoffifin', 'urutan' => 32],
            ['jilid' => 'Pengembangan 1', 'materi' => 'Al Infithor', 'urutan' => 33],
            ['jilid' => 'Pengembangan 1', 'materi' => 'At Takwir', 'urutan' => 34],
            ['jilid' => 'Pengembangan 1', 'materi' => 'Abasa', 'urutan' => 35],
            ['jilid' => 'Pengembangan 1', 'materi' => "An Nazi'at", 'urutan' => 36],
            ['jilid' => 'Pengembangan 1', 'materi' => "An Naba'", 'urutan' => 37],
            // Pengembangan 2
            ['jilid' => 'Pengembangan 2', 'materi' => 'Pemeliharaan hafalan juz 30', 'urutan' => 38],
            ['jilid' => 'Pengembangan 2', 'materi' => 'Penambahan hafalan baru juz 29', 'urutan' => 39],
        ];

        $now = now();
        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        DB::table('master_materi_tahfidz')->insert($data);
    }

    public function down(): void
    {
        Schema::dropIfExists('master_materi_tahfidz');
    }
};
