<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'duration_type',
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
        'rejected',
        'cancelled'
    ];

    public const DURATION_TYPES = [
        'full_day',
        'first_half',
        'second_half'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getDurationInDays(): float
    {
        if ($this->duration_type && $this->duration_type !== 'full_day') {
            return 0.5;
        }

        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled(): bool
    {
        return $this->status === 'pending';
    }

    public function approve($approverId)
    {
        if ($this->isPending()) {
            $this->update([
                'status' => 'approved',
                'approved_by' => $approverId,
                'approved_at' => now()
            ]);

            return true;
        }

        return false;
    }

    public function reject($approverId)
    {
        if ($this->isPending()) {
            $this->update([
                'status' => 'rejected',
                'approved_by' => $approverId,
                'approved_at' => now()
            ]);

            return true;
        }

        return false;
    }

    public function cancel()
    {
        if ($this->canBeCancelled()) {
            $this->update([
                'status' => 'cancelled',
                'updated_at' => now()
            ]);

            return true;
        }

        return false;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getFormattedDurationAttribute(): string
    {
        if ($this->duration_type === 'full_day') {
            return $this->start_date->format('M d, Y') . ' - ' . $this->end_date->format('M d, Y');
        }

        $period = $this->duration_type === 'first_half' ? 'Morning' : 'Afternoon';
        return $this->start_date->format('M d, Y') . ' (' . $period . ')';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'approved'])
            ->where('end_date', '>=', now());
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($leaveRequest) {
            // Set end_date same as start_date for half-day leaves
            if ($leaveRequest->duration_type !== 'full_day') {
                $leaveRequest->end_date = $leaveRequest->start_date;
            }
        });
    }
}
