<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('staff.leaves.index', compact('leaveRequests'));
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        // Simple update to change status to rejected
        $leaveRequest->update(['status' => 'cancel']);
        
        return redirect()->route('staff.leave.index')
            ->with('success', 'Leave request has been rejected.');
    }
}