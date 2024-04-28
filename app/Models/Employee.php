<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'employee_number', 'user_id', 'department', 'position', 'salary', 'address', 'phone_number', 'birthdate'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }
}
