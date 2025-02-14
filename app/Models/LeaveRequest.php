<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory;

    // Status Constants - Matching database enum values exactly
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CANCEL = 'cancel';

    // Leave Type Constants
    public const TYPE_SICK = 'sick';
    public const TYPE_ANNUAL = 'annual';
    public const TYPE_IMPORTANT = 'important';
    public const TYPE_OTHER = 'other';

    // Arrays for Validation
    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
        self::STATUS_CANCEL
    ];

    public const TYPES = [
        self::TYPE_SICK,
        self::TYPE_ANNUAL,
        self::TYPE_IMPORTANT,
        self::TYPE_OTHER
    ];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCEL;
    }

    public function canBeCancelled(): bool
    {
        return $this->isPending();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            self::STATUS_CANCEL => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function cancel(): bool
    {
        if ($this->canBeCancelled()) {
            return $this->update([
                'status' => self::STATUS_CANCEL
            ]);
        }
        return false;
    }

    public function getDurationInDays(): float
    {
        $start = Chronos::parse($this->start_date);
        $end = Chronos::parse($this->end_date);

        $duration = 0;
        for ($date = $start; $date->lessThanOrEquals($end); $date = $date->addDays(1)) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        return $duration;
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
            ->where('end_date', '>=', now());
    }
}
