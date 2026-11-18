<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('umur');
            $table->string('keahlian');
            $table->string('jenis_kelamin');
            $table->integer('status_kerja');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entitas');
    }
};
