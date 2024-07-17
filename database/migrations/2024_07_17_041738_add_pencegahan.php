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
        Schema::table('penyakits', function (Blueprint $table) {
            $table->text('keterangan')->after('nama')->nullable();
            $table->text('pencegahan')->after('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyakits', function (Blueprint $table) {
            $table->dropColumn('keterangan');
            $table->dropColumn('pencegahan');
        });
    }
};
