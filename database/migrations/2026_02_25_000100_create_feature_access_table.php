<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_access', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50);
            $table->string('feature', 100);
            $table->boolean('allowed')->default(true);
            $table->unique(['role', 'feature']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_access');
    }
};

