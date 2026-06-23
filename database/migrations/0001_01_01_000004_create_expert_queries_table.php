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
        Schema::create('expert_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('The MP who submitted the query');
            $table->string('title');
            $table->text('explicit_description');
            $table->string('audio_note_path')->nullable()->comment('Path to recorded audio note');
            $table->string('status_enum', 32)->default('pending')
                  ->comment('pending, assigned, in_progress, completed');
            $table->string('turnaround_tier_enum', 32)->default('standard_request')
                  ->comment('30min_floor_support, 48hr_analysis, standard_request');
            $table->foreignId('assigned_researcher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('target_deadline')->nullable();
            $table->text('historical_precedents_context')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status_enum');
            $table->index('assigned_researcher_id');
            $table->index('turnaround_tier_enum');
            $table->index('target_deadline');
            $table->index(['status_enum', 'assigned_researcher_id']);
            $table->index(['user_id', 'status_enum']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_queries');
    }
};
