<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'basic_salary',
        'monthly_hourly_rate',
        'overtime_rate',
        'effective_date',
    ];


    protected $casts = [
        'basic_salary' => 'decimal:2',
        'monthly_hourly_rate' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'effective_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
}
