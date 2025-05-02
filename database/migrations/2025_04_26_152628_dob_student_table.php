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
            // Đảm bảo rằng cột 'dob' có thể nhận giá trị NULL
            $table->date('dob')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Khôi phục lại trạng thái cột 'dob' không cho phép NULL
            $table->date('dob')->nullable(false)->change();
        });
    }
};
