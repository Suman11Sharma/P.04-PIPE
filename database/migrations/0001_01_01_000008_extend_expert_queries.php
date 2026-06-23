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
        Schema::table('expert_queries', function (Blueprint $table) {
            // File uploads
            $table->json('attachments')->nullable()
                ->after('audio_note_path')
                ->comment('JSON array of uploaded file paths');

            // Associated bill (required for 30-min floor support tier)
            $table->foreignId('bill_id')->nullable()
                ->after('assigned_researcher_id')
                ->constrained('bills')
                ->nullOnDelete()
                ->comment('Associated bill for floor support requests');

            // Response and review content
            $table->text('response_text')->nullable()
                ->after('historical_precedents_context')
                ->comment('The researcher\'s response/analysis text');

            $table->text('senior_notes')->nullable()
                ->after('response_text')
                ->comment('Senior researcher editorial notes and modifications');

            $table->foreignId('reviewed_by')->nullable()
                ->after('assigned_researcher_id')
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Senior researcher who performed editorial review');

            // SLA breach tracking
            $table->timestamp('sla_breached_at')->nullable()
                ->after('resolved_at')
                ->comment('When the SLA deadline was breached');

            $table->boolean('sla_breach_notified')->default(false)
                ->after('sla_breached_at')
                ->comment('Whether a breach notification has been sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expert_queries', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'attachments',
                'bill_id',
                'response_text',
                'senior_notes',
                'reviewed_by',
                'sla_breached_at',
                'sla_breach_notified',
            ]);
        });
    }
};
