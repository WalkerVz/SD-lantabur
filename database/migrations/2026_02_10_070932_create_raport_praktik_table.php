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
        Schema::create('raport_praktik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raport_id')->constrained('raport_nilai')->onDelete('cascade');
            $table->string('section'); // e.g., 'PAI', 'ADAB'
            $table->string('kategori'); // e.g., 'Adzan', 'Adab kepada Allah'
            $table->integer('kkm')->default(75);
            $table->integer('nilai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport_praktik');
    }
};
