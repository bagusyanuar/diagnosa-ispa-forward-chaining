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
        Schema::table('aturans', function (Blueprint $table) {
            $table->integer('bobot')->default(0)->after('gejala_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aturans', function (Blueprint $table) {
            $table->dropColumn('bobot');
        });
    }
};
