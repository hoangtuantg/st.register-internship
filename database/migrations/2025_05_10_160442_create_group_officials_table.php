<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ReportStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_officials', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('supervisor', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->unsignedBigInteger('teacher_id',)->nullable();
            $table->text('topic')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->enum('report_status', array_map(fn($status) => $status->value, ReportStatusEnum::cases()))
                ->default(ReportStatusEnum::PENDING->value);
            $table->string('report_file')->nullable();
            $table->timestamps();
        });

        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'group_official_id')) {
                $table->unsignedBigInteger('group_official_id')->nullable();
            }
        });
        Schema::create('student_group_officials', function (Blueprint $table) {
            $table->id();
            $table->string('internship_company', 255)->nullable();
            $table->string('supervisor_company', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('phone_family', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('supervisor_company_email', 255)->nullable();
            $table->string('supervisor_company_phone', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_officials');
        Schema::dropIfExists('student_group_officials');
    }
};
