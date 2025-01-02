<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFinancialDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_account_number',
        'grade',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
