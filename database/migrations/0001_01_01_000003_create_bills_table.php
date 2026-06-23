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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('local_identifier')->unique()->comment('Local bill tracking number/ID');
            $table->string('house_origin', 64)->nullable()->comment('House of origin (e.g. National Assembly, Senate)');
            $table->string('status_enum', 32)->default('tabled')
                  ->comment('tabled, first_reading, second_reading, committee_stage, passed, vetoed');
            $table->text('current_stage_description')->nullable();
            $table->text('constitutional_implications_summary')->nullable();
            $table->json('comparison_matrix')->nullable()->comment('Structured JSON comparing bill versions');
            $table->timestamp('tabled_at')->nullable();
            $table->json('voting_records')->nullable()->comment('JSON mapping yea/nay/abstain counts');
            $table->timestamps();

            $table->index('status_enum');
            $table->index('local_identifier');
            $table->index('house_origin');
            $table->index(['status_enum', 'house_origin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
