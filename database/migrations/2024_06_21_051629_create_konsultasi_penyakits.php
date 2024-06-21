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
        Schema::create('konsultasi_penyakits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('konsultasi_id')->unsigned();
            $table->bigInteger('penyakit_id')->unsigned();
            $table->double('persentase')->default(0);
            $table->timestamps();
            $table->foreign('konsultasi_id')->references('id')->on('konsultasi');
            $table->foreign('penyakit_id')->references('id')->on('penyakits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_penyakits');
    }
};
