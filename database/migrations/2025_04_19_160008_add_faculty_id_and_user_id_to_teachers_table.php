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
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'faculty_id')) {
                $table->unsignedBigInteger('faculty_id')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('faculty_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'faculty_id')) {
                $table->dropColumn('faculty_id');
            }
            if (Schema::hasColumn('teachers', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
