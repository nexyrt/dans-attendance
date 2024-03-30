<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activity_log = Attendance::with('employee')->get();
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();

        $attendanceRecordExists = $this->checkAttendanceRecordExists($employee->id);
        $hasCheckedOut = $this->hasCheckedOut($employee->id);

        $attendance = Attendance::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('employee_id', $employee->id)
            ->get();

        return view('dashboard', compact(['activity_log', 'user', 'employee', 'attendanceRecordExists', 'hasCheckedOut', 'attendance']));
    }

    public function checkAttendanceRecordExists($employeeId)
    {
        // Get today's date
        $todayDate = now()->toDateString();

        // Check if there's an attendance record for today's date for the given user ID
        $attendanceRecordExists = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $todayDate)
            ->exists();

        return $attendanceRecordExists;
    }

    public function hasCheckedOut($employeeId)
    {
        // Get today's date
        $today = now()->toDateString();

        return Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->whereNotNull('check_out')
            ->exists();
    }

    public function filter(Request $request)
    {
        $selectedMonth = $request->input('month');
        // Query your database to filter data based on the selected month
        // Example:
        $filteredData = Attendance::whereMonth('date', $selectedMonth)->get();

        // Return the filtered data to the same view
        return view('dashboard', ['data' => $filteredData]);
    }
}
