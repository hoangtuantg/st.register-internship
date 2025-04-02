<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CampaignStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('start');
            $table->date('end');
            $table->integer('max_student_group');
            $table->integer('faculty_id');
            $table->enum('status', array_map(fn($status) => $status->value, CampaignStatusEnum::cases()))
            ->default(CampaignStatusEnum::Active->value);
            $table->integer('plan_template_id')->nullable();
            $table->date('official_end')->nullable();
            $table->boolean('official_end_public')->default(false);        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
