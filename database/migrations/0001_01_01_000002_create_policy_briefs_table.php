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
        Schema::create('policy_briefs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->comment('One-page executive summary text');
            $table->longText('full_content')->comment('Full markdown content');
            $table->json('attachments')->nullable()->comment('JSON array of file paths (PDFs, Talking Points, etc.)');
            $table->foreignId('sector_id')->nullable()->constrained('sectors')->nullOnDelete();
            $table->string('urgency_level_enum', 16)->default('medium')->comment('low, medium, high');
            $table->string('status_enum', 32)->default('draft')->comment('draft, under_review, published');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('compiled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('status_enum');
            $table->index('sector_id');
            $table->index('urgency_level_enum');
            $table->index('compiled_by');
            $table->index('verified_by');
            $table->index(['status_enum', 'urgency_level_enum']);
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_briefs');
    }
};
