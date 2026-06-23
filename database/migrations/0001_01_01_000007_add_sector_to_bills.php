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
        Schema::table('bills', function (Blueprint $table) {
            $table->foreignId('sector_id')
                ->nullable()
                ->after('current_stage_description')
                ->constrained('sectors')
                ->nullOnDelete();

            $table->index('sector_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropIndex(['sector_id']);
            $table->dropColumn('sector_id');
        });
    }
};
