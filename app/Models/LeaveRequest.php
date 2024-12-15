<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'attachment_path'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public const TYPES = [
        'sick',
        'annual',
        'important',
        'other'
    ];

    public const STATUSES = [
        'pending',
        'approved',
        'rejected'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
{
    return $this->belongsTo(User::class, 'approved_by');
}

    public function getDurationInDays()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approve($approverId)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approverId,
            'approved_at' => now()
        ]);
    }

    public function reject($approverId)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $approverId,
            'approved_at' => now()
        ]);
    }
}
