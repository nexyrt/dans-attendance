<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $employee_id = $request->input("employee_id");
        $check_in_time = $request->input("check_in_time");
        $check_in_date = $request->input("check_in_date");

        // Store the check-in data in the attendance table
        Attendance::create([
            'employee_id' => $employee_id,
            'check_in' => $check_in_time, // Current time
            'date' => $check_in_date, // Current date
        ]);

        // Redirect back or return a response
        return back()->with('success', 'Check-in successful!');
    }

    public function checkOut(Request $request)
    {
        Attendance::where('employee_id', $request->employee_id)
            ->whereDate('date', $request->check_in_date)
            ->update(['check_out' => $request->check_out_time]);


        // Redirect back or return a response
        return back()->with('success', 'Check-in successful!');
    }

    public function edit($id)
    {
        $attendanceData = Attendance::where('employee_id', $id)
            ->whereDate('date', now()->toDateString())
            ->get();
            
        return view('components.staff.edit-attendance', compact('attendanceData'));
    }

    public function patch(Request $request, $employee_id)
    {
        $attendanceData = Attendance::where('employee_id', $employee_id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($attendanceData) {
            $attendanceData->update(['activity_log' => $request->input('content')]); // Replace 'field' and 'value' with your actual field and value to update
        } else {
            // Handle the case where no attendance record is found
        }
        return redirect()->route('dashboard');
    }
}
