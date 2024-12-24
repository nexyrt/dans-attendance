<?php

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Http\Requests\StoreLeaveRequestRequest;
use App\Http\Requests\UpdateLeaveRequestRequest;
use App\Livewire\Staff\LeaveRequest\CreateComponent;
use App\Livewire\Staff\LeaveRequest\IndexComponent;
use App\Livewire\Staff\LeaveRequest\ShowComponent;

class LeaveController extends Controller
{
    public function index()
    {
        return view('staff.leave.index', [
            'indexComponent' => app(IndexComponent::class)
        ]);
    }

    public function create()
    {
        return view('staff.leave.create', [
            'createComponent' => app(CreateComponent::class)
        ]);
    }

    public function store(StoreLeaveRequestRequest $request)
    {
        $leaveRequest = LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->attachment->store('leave-attachments', 'public');
            $leaveRequest->update(['attachment_path' => $path]);
        }

        return redirect()->route('staff.leave.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        return view('staff.leave.show', [
            'showComponent' => app(ShowComponent::class, ['leaveRequest' => $leaveRequest])
        ]);
    }

    // Add update and destroy methods as needed
}