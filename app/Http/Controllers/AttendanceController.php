<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $user_id = $request->input("user_id");
        $check_in_time = $request->input("check_in_time");
        $check_in_date = $request->input("check_in_date");

        // Store the check-in data in the attendance table
        Attendance::create([
            'user_id' => $user_id,
            'check_in' => $check_in_time, // Current time
            'date' => $check_in_date, // Current date
        ]);

        // Redirect back or return a response
        return back()->with('success', 'Check-in successful!');
    }

    public function checkOut(Request $request)
    {
        Attendance::where('user_id', $request->user_id)
            ->whereDate('date', $request->check_in_date)
            ->update(['check_out' => $request->check_out_time]);


        // Redirect back or return a response
        return back()->with('success', 'Check-in successful!');
    }

    public function edit($id)
    {
        $attendanceData = Attendance::where('user_id', $id)
            ->whereDate('date', now()->toDateString())
            ->get();

        return view('components.staff.edit-attendance')->with('attendanceData', $attendanceData[0]);
    }

    public function update(Request $request, $id)
    {
        $attendanceData = Attendance::find($id);
        $attendanceData->activity_log = $request->input('content');

        $attendanceData->save();
        notify()->success('Good job, keep it up ⚡️', 'Aktivitas ditambahkan!');

        return redirect()->route('dashboard');
    }
}
