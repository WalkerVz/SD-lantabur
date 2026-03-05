<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_materi_jilid', function (Blueprint $table) {
            $table->id();
            $table->string('jilid', 30);
            $table->string('materi', 255);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Seed default data
        $data = [
            // Jilid I
            ['jilid' => 'I', 'materi' => 'Pengenalan huruf tunggal (Hijaiyah) Alif-Ya.', 'urutan' => 1],
            ['jilid' => 'I', 'materi' => 'Pengenala huruf tunggal berharakat fathah A-Ya', 'urutan' => 2],
            ['jilid' => 'I', 'materi' => 'Membaca 2-3 huruf tunggal berharakat fathah A-Ya', 'urutan' => 3],

            // Jilid II
            ['jilid' => 'II', 'materi' => 'Pengenalan harakat kasrah dan dhammah, fathatain, kasratain dan dhammahtain.', 'urutan' => 1],
            ['jilid' => 'II', 'materi' => 'Pengenala huruf sambung Alif - Ya', 'urutan' => 2],
            ['jilid' => 'II', 'materi' => 'Pengenalan Angka Arab 1-99', 'urutan' => 3],

            // Jilid III
            ['jilid' => 'III', 'materi' => "Pengenalan tanda baca panjang (Mad Thabi'i): Fathah diikuti Alif dan fathah panjang, Kasrah diikuti Ya' sukun dan kasrah panjang, Dhammah diikuti Wawu sukun dan kasrah panjang", 'urutan' => 1],
            ['jilid' => 'III', 'materi' => 'Pengenalan tanda baca panjang (Mad wajib Muttashil dan Mad Jaiz Munfashil)', 'urutan' => 2],
            ['jilid' => 'III', 'materi' => 'Pengenalan Angka Arab 100-500', 'urutan' => 3],

            // Jilid IV
            ['jilid' => 'IV', 'materi' => 'Pengenalan huruf yang disukun ditekan membacanya', 'urutan' => 1],
            ['jilid' => 'IV', 'materi' => 'Pengenalan tanda Tasydid/Syiddah ditekan membacanya.', 'urutan' => 2],
            ['jilid' => 'IV', 'materi' => "Membedakan cara membaca huruf-huruf: Tsa', Sin dan Syin yang disukun, 'Ain, Hamzah yang disukun, Ha', Kha', dan Hha' yang disukun.", 'urutan' => 3],

            // Jilid V
            ['jilid' => 'V', 'materi' => 'Pengenalan cara membaca Waqaf/mewakafkan', 'urutan' => 1],
            ['jilid' => 'V', 'materi' => 'Pengenalan bacaan Ghunnah/dengung', 'urutan' => 2],
            ['jilid' => 'V', 'materi' => 'Pengenalan bacaan ikhfa/samar', 'urutan' => 3],
            ['jilid' => 'V', 'materi' => 'Pengenalan bacaan Idgham Bighunnah', 'urutan' => 4],
            ['jilid' => 'V', 'materi' => 'Pengenalan bacaan Iqlab', 'urutan' => 5],
            ['jilid' => 'V', 'materi' => 'Pengenalan cara membaca lafadz Allah', 'urutan' => 6],

            // Jilid VI
            ['jilid' => 'VI', 'materi' => 'Pengenalan bacaan Qalqalah/mantul', 'urutan' => 1],
            ['jilid' => 'VI', 'materi' => 'Pengenalan bacaan Idgham bilaghunnah', 'urutan' => 2],
            ['jilid' => 'VI', 'materi' => 'Pengenalan bacaan Izhar/jelas.', 'urutan' => 3],
            ['jilid' => 'VI', 'materi' => 'Pengenalan macam-macam tanda Waqaf/washal', 'urutan' => 4],
            ['jilid' => 'VI', 'materi' => 'Cara membaca Nun-iwadh di awal dan ditengah ayat', 'urutan' => 5],
            ['jilid' => 'VI', 'materi' => 'Membaca Ana, na-nya dibaca dipendek', 'urutan' => 6],

            // Al Qur'an
            ["jilid" => "Al Qur'an", 'materi' => "Melafadzkan Al Qur'an dengan lancar", 'urutan' => 1],
            ["jilid" => "Al Qur'an", 'materi' => 'Membaca dengan makhorijul huruf yang benar', 'urutan' => 2],
            ["jilid" => "Al Qur'an", 'materi' => 'Memahami tajwid yang benar', 'urutan' => 3],

            // Al Qur'an (Ghorib)
            ["jilid" => "Al Qur'an (Ghorib)", 'materi' => "Pengenalan bacaan Ghrib dalam Al-Qur'an", 'urutan' => 1],
            ["jilid" => "Al Qur'an (Ghorib)", 'materi' => "Pengenalan bacaan hati-hati dalam Al-Qur'an", 'urutan' => 2],

            // Al Qur'an (Tajwid)
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Hukum Nun Sukunatau Tanwin', 'urutan' => 1],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Ghunnah (Nun dan Min bertasydid)', 'urutan' => 2],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Hukum Mim Sukun', 'urutan' => 3],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Macam-macam Idgham', 'urutan' => 4],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Hukum lafadz Allah', 'urutan' => 5],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Qalqalah', 'urutan' => 6],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => 'Idzhar wajib', 'urutan' => 7],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => "Hukum Ro'", 'urutan' => 8],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => "Hukum Lam Ta'rif (Al)", 'urutan' => 9],
            ["jilid" => "Al Qur'an (Tajwid)", 'materi' => "Macam Mad (Mad Thabi'l dan Mad Far'i)", 'urutan' => 10],
        ];

        $now = now();
        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        DB::table('master_materi_jilid')->insert($data);
    }

    public function down(): void
    {
        Schema::dropIfExists('master_materi_jilid');
    }
};
