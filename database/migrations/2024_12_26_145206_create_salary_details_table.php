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
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('monthly_hourly_rate', 10, 2)->nullable();
            $table->enum('payment_type', ['monthly', 'hourly'])->default('monthly');
            $table->decimal('overtime_rate', 10, 2)->default(20000);
            $table->date('effective_date');
            $table->timestamps();

            $table->index(['effective_date']);
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};
