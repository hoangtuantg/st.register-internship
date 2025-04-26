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
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'faculty_id')) {
                $table->unsignedBigInteger('faculty_id')->nullable();
            }
            if (!Schema::hasColumn('students', 'email')) {
                $table->string('email', 255)->nullable();
            }
            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone', 20)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'faculty_id')) {
                $table->dropForeign(['faculty_id']);
                $table->dropColumn('faculty_id');
            }
            if (Schema::hasColumn('students', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('students', 'phone')) {
                $table->dropForeign(['phone']);
                $table->dropColumn('phone');
            }
        });
    }
};
