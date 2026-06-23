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
        Schema::create('constituencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('province_name');
            $table->string('geographic_coordinates')->nullable()->comment('Polygon/MultiPolygon WKT string for spatial boundaries');
            $table->json('socio_economic_indicators')->nullable()->comment('JSON blob for dynamic chart rendering');
            $table->timestamps();

            $table->index('province_name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role_enum', 32)->default('mp')->comment('admin, senior_researcher, junior_researcher, committee_chair, mp, staff');
            $table->foreignId('constituency_id')->nullable()->constrained('constituencies')->nullOnDelete();
            $table->unsignedBigInteger('committee_id')->nullable()->comment('External reference or FK to committees table');
            $table->string('phone_number', 32)->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->json('dynamic_preferences')->nullable()->comment('JSON configuration for notification preferences');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('role_enum');
            $table->index('constituency_id');
            $table->index('committee_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('constituencies');
    }
};
