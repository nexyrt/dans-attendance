<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now();
        $events = [
            '2024-11-24' => [
                ['title' => 'Team Meeting'],
                ['title' => 'Project Review']
            ],
            '2024-11-25' => [
                ['title' => 'Client Call']
            ]
        ];

        // Check today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        return view('staff.dashboard.index', compact('todayAttendance', 'user', 'today', 'events'));
    }
}
