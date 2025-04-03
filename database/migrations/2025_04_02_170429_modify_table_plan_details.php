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
        Schema::table('plan_details', function (Blueprint $table) {
            if (Schema::hasColumn('plan_details', 'plan_template_id')) {
                $table->dropColumn('plan_template_id');
            }
            if (!Schema::hasColumn('plan_details', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_details', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_template_id')->nullable();
            $table->dropColumn('plan_id');
        });
    }
};
