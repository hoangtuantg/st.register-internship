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
        Schema::table('user_role', function (Blueprint $table) {
            if (!Schema::hasColumn('user_role', 'is_super_admin')) {
                $table->boolean('is_super_admin')->after('role_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_role', function (Blueprint $table) {
            if (Schema::hasColumn('user_role', 'is_super_admin')) {
                $table->dropColumn('is_super_admin');
            }
        });
    }
};
