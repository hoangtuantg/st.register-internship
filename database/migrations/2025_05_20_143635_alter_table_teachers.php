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
            if (!Schema::hasColumn('teachers', 'topic')) {
                $table->string('topic', 255)->nullable();
            }

            if (!Schema::hasColumn('teachers', 'code')) {
                $table->string('code', 20)->nullable();
            }

            if (!Schema::hasColumn('teachers', 'name')) {
                $table->string('name', 100)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'topic')) {
                $table->dropColumn('topic');
            }

            if (Schema::hasColumn('teachers', 'code')) {
                $table->dropColumn('code');
            }

            if (Schema::hasColumn('teachers', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
