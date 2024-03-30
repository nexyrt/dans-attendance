<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'date',
        'activity_log'
        // Add other fillable fields here if needed
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
