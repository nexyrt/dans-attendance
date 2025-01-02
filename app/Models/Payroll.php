<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payroll_batches_id',
        'run_reference',
        'approved_by',
        'processed_at',
        'paid_at',
        'status',
        'notes',
    ];

    public function payrollBatch(): BelongsTo
    {
        return $this->belongsTo(PayrollBatch::class,'payroll_batches_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deductions(): HasMany
    {
        return $this->hasMany(Deduction::class);
    }

    public function allowances(): HasMany
    {
        return $this->hasMany(Allowance::class);
    }
}
