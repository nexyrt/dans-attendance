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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_id')->constrained('payrolls')->onDelete('cascade');
            $table->enum('deduction_type', ['BPJS Kesehatan', 'BPJS TK','PPH 21','Pinjaman','Terlambat','Lainnya']);
            $table->decimal('amount', 12, 2)->default(0);
            $table->boolean('is_recurring')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'payroll_id']);
            $table->index(['deduction_type', 'is_recurring']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
