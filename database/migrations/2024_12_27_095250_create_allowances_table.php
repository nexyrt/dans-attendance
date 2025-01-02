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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_id')->constrained('payrolls')->onDelete('cascade');
            $table->enum('allowance_type', ['Bonus Kinerja', 'Reimbuse','Lemburan','Honor Proyek','Lainnya']);
            $table->decimal('amount', 12, 2)->default(0);
            $table->boolean('is_recurring')->default(false);


            $table->index(['user_id', 'payroll_id']);
            $table->index(['allowance_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowances');
    }
};
