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
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'plan_template_id')) {
                $table->dropColumn('plan_template_id');
            }

            if (!Schema::hasColumn('campaigns', 'plan_id')) {
                $table->unsignedBigInteger('plan_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('plan_id');
            $table->unsignedBigInteger('plan_template_id')->after('id');
        });
    }
};
