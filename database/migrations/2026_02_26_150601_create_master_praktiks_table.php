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
        Schema::create('master_praktik', function (Blueprint $table) {
            $table->id();
            $table->string('section', 50); // e.g: 'PAI', 'ADAB', or 'DOA'
            $table->string('kategori', 100); // e.g: 'Adzan', 'Iqomah'
            $table->integer('urutan')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_praktiks');
    }
};
