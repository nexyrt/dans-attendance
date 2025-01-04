<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->initializeYearlyLeaveBalance();
        });
    }

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

    public function leaveBalance()
    {
        return $this->hasOne(LeaveBalance::class);
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

    public function approvedLeaves()
    {
        return $this->hasMany(LeaveRequest::class, 'approved_by');
    }

    public function financialDetails(): HasOne
    {
        return $this->hasOne(EmployeeFinancialDetail::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function payrollBatches()
    {
        return $this->hasMany(PayrollBatch::class);
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
