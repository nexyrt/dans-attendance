<?php

namespace App\Models;

use App\Models\User;
use App\Models\ScheduleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'manager_id', // Add manager_id to fillable
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Add the manager relationship
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Relationship with Schedule Exceptions
    public function scheduleExceptions()
    {
        return $this->belongsToMany(ScheduleException::class, 'department_schedule_exception')
            ->withTimestamps();
    }
}
