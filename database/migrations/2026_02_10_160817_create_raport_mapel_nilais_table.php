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
        Schema::create('raport_mapel_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raport_id');
            $table->unsignedBigInteger('mapel_id');
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('raport_id')->references('id')->on('raport_nilai')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('master_mapel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport_mapel_nilai');
    }
};
