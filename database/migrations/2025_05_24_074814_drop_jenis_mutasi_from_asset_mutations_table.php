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
        Schema::table('asset_mutations', function (Blueprint $table) {
             $table->dropColumn('jenis_mutasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_mutations', function (Blueprint $table) {
             $table->string('jenis_mutasi')->nullable(); // atau dengan default, kalau ingin restore
        });
    }
};
