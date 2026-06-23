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
        Schema::create('policy_brief_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_brief_id')->constrained('policy_briefs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('rating')->nullable()->comment('true = thumbs up, false = thumbs down');
            $table->json('error_tags')->nullable()->comment('Selected classification tags: Data Outdated, Local Context Missing, etc.');
            $table->text('revision_request')->nullable()->comment('Free-text revision request from the MP');
            $table->string('status_enum', 32)->default('submitted')->comment('submitted, acknowledged, in_revision, resolved');
            $table->timestamps();

            // An MP can only have one active feedback per brief
            $table->unique(['policy_brief_id', 'user_id']);

            $table->index('policy_brief_id');
            $table->index('user_id');
            $table->index('status_enum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_brief_feedback');
    }
};
