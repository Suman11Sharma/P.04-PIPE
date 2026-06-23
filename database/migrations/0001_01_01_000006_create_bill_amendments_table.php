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
        Schema::create('bill_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete();
            $table->unsignedSmallInteger('version')->default(1)->comment('Sequential version number');
            $table->text('original_text')->nullable()->comment('The bill text as originally written');
            $table->text('amended_text')->nullable()->comment('The bill text as amended in this version');
            $table->json('diff_summary')->nullable()->comment('Structured diff data: added/removed sections');
            $table->text('amendment_notes')->nullable()->comment('Notes describing what changed and why');
            $table->foreignId('proposed_by')->nullable()->constrained('users')->nullOnDelete()->comment('The user who proposed this amendment');
            $table->timestamp('applied_at')->nullable()->comment('When this amendment was formally applied');
            $table->timestamps();

            $table->unique(['bill_id', 'version']);
            $table->index('bill_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_amendments');
    }
};
