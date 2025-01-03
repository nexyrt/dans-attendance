<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payroll_id',
        'type',
        'amount',
        'is_recurring'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_recurring' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payrollRecord(): BelongsTo
    {
        return $this->belongsTo(Payroll::class,'payroll_id');
    }
}
