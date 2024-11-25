<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now();

        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('staff.attendance.index', [
            'todayAttendance' => $todayAttendance,
            'attendances' => $attendances,
        ]);
    }
}
