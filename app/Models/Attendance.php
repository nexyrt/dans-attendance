<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'date',
        'status',
        'working_hours',
        'early_leave_reason',
        'notes',
        // Add other fillable fields here if needed
    ];

    protected $casts = [
        'date' => 'datetime',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
