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
            $table->string('class', 20)->nullable()->change();
            $table->unsignedBigInteger('course_id')->nullable()->change();
            $table->integer('credit')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('class', 20)->change();
            $table->unsignedBigInteger('course_id')->change();
            $table->integer('credit')->change();
        });
    }
};
