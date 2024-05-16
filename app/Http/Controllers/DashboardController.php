<?php

namespace App\Http\Controllers;

use App\Exports\FilteredDataExport;
use App\Exports\FilteredTableExport;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Current Date
        $month = Carbon::now()->month;
        $user = auth()->user();

        // Check today's attendance
        $attendanceRecordExists = $this->checkAttendanceRecordExists($user->id);
        $hasCheckedOut = $this->hasCheckedOut($user->id);

        // Employee Records
        $admin_attendance = Attendance::with('user')->get();
        $user_attendance = Attendance::where('user_id', $user->id)
            ->whereMonth('date', $month)
            ->get();


        return view('dashboard', compact(['admin_attendance', 'user_attendance', 'attendanceRecordExists', 'hasCheckedOut', 'user']));
    }

    public function checkAttendanceRecordExists($userId)
    {
        // Get today's date
        $todayDate = now()->toDateString();

        // Check if there's an attendance record for today's date for the given user ID
        $attendanceRecordExists = Attendance::where('user_id', $userId)
            ->whereDate('date', $todayDate)
            ->exists();

        return $attendanceRecordExists;
    }

    public function hasCheckedOut($userId)
    {
        // Get today's date
        $today = now()->toDateString();

        return Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->whereNotNull('check_out')
            ->exists();
    }
}
