<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('status')->default('Aktif')->after('kategori');
            $table->string('kondisi')->default('Baik')->after('status');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['status', 'kondisi']);
        });
    }
};
