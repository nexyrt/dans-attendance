<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'position',
        'salary',
        'address',
        'phone_number',
        'birthdate',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function isAdmin($role)
    {
        return $role === 'admin';
    }

    public function isUser($role)
    {
        return $role === 'user';
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Get current year's leave balance
     */
    public function currentLeaveBalance()
    {
        return $this->leaveBalances()
            ->where('year', now()->year)
            ->first();
    }

    /**
     * Get leave balance for a specific year
     */
    public function getLeaveBalance($year)
    {
        return $this->leaveBalances()
            ->where('year', $year)
            ->first();
    }

    /**
     * Check if user has enough leave balance
     */
    public function hasEnoughLeaveBalance($days)
    {
        $balance = $this->currentLeaveBalance();
        return $balance && $balance->remaining_balance >= $days;
    }

    /**
     * Update leave balance after approved leave
     */
    public function updateLeaveBalance($days)
    {
        $balance = $this->currentLeaveBalance();
        if ($balance) {
            $balance->updateBalance($balance->used_balance + $days);
        }
    }

    /**
     * Initialize leave balance for current year
     */
    public function initializeYearlyLeaveBalance($totalBalance = 12)
    {
        return $this->leaveBalances()->create([
            'year' => now()->year,
            'total_balance' => $totalBalance,
            'used_balance' => 0,
            'remaining_balance' => $totalBalance
        ]);
    }
}
