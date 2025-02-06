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
        Schema::table('schedule_exceptions', function (Blueprint $table) {
            $table->integer('late_tolerance')->nullable()->default(30)->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_exceptions', function (Blueprint $table) {
            $table->dropColumn('late_tolerance');
        });
    }
};
