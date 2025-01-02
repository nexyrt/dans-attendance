<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can cancel the leave request.
     */
    public function cancel(User $user, LeaveRequest $leave): bool
    {
        // User can only cancel their own leave requests
        return $user->id === $leave->user_id &&
            in_array($leave->status, ['pending', 'approved']);
    }

    /**
     * Determine if the user can view the leave request.
     */
    public function view(User $user, LeaveRequest $leave): bool
    {
        // Users can only view their own leave requests
        return $user->id === $leave->user_id;
    }
}