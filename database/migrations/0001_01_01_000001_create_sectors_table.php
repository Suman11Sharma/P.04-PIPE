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
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g. Health, Economy, Agritech');
            $table->string('slug')->unique();
            $table->string('icon_class')->nullable()->comment('CSS class or icon identifier for UI');
            $table->timestamps();
        });

        Schema::create('user_sector', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sector_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'sector_id']);
            $table->timestamps();

            $table->index('sector_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sector');
        Schema::dropIfExists('sectors');
    }
};
