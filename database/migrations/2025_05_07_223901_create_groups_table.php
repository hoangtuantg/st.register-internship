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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('supervisor', 255)->nullable();
            $table->text('topic')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->timestamps();
        });

        Schema::create('group_students', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_captain')->default(false);
            $table->string('internship_company', 255)->nullable();
            $table->string('phone', 255);
            $table->string('phone_family', 255);
            $table->string('email', 255);
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_students');    }
};
