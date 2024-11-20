<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Current Date
        $month = Carbon::now()->month;
        $user = auth()->user();
        $attendances = Attendance::with('user')->get();

        // Check today's attendance
        $attendanceRecordExists = $this->checkAttendanceRecordExists($user->id);
        $hasCheckedOut = $this->hasCheckedOut($user->id);

        return view('admin.index', compact(['attendances', 'attendanceRecordExists', 'hasCheckedOut', 'user']));
    }

    public function users()
    {
        $users = User::all();
        // Check today's attendance
        $user = auth()->user();
        $attendanceRecordExists = $this->checkAttendanceRecordExists($user->id);
        $hasCheckedOut = $this->hasCheckedOut($user->id);

        return view('admin.user', compact(['attendanceRecordExists', 'hasCheckedOut', 'user']));
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
