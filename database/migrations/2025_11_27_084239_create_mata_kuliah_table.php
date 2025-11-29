<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mata_kuliah')->unique();
            $table->timestamps();

            $table->string('dosen_pengampu')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};