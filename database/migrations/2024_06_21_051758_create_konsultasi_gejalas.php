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
        Schema::create('konsultasi_gejalas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('konsultasi_id')->unsigned();
            $table->bigInteger('gejala_id')->unsigned();
            $table->timestamps();
            $table->foreign('konsultasi_id')->references('id')->on('konsultasi');
            $table->foreign('gejala_id')->references('id')->on('gejalas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_gejalas');
    }
};
