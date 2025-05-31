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
        Schema::table('users', function (Blueprint $table): void {
            $table->text('access_token')->nullable();
            $table->json('user_data')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('role')->nullable();
            $table->string('full_name')->nullable();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['access_token', 'user_data', 'faculty_id', 'role', 'full_name', 'code', 'type']);
        });
    }
};
