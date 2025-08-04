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
            $table->foreignId('from_user_id')->nullable()->after('asset_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_mutations', function (Blueprint $table) {
             $table->dropForeign(['from_user_id']);
             $table->dropColumn('from_user_id');
        });
    }
};
