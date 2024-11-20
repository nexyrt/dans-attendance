<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    // Relationship with Schedule Exceptions
    public function scheduleExceptions()
    {
        return $this->hasMany(ScheduleException::class);
    }
}
