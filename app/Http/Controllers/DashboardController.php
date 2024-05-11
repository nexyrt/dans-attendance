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

    public function fetchData(Request $request)
    {
        $department = $request->input('department');
        $position = $request->input('position');
        $user_name = $request->input('user_name');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = Attendance::with('user');

        if ($department) {
            $query->whereHas('user', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        if ($position) {
            $query->whereHas('user', function ($q) use ($position) {
                $q->where('position', $position);
            });
        }

        if ($user_name) {
            $query->whereHas('user', function ($q) use ($user_name) {
                $q->where('name', 'like', '%' . $user_name . '%');
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $data = $query->get();

        // Return the data as JSON
        return response()->json($data);
    }

    public function exportTableData(Request $request)
    {
        // Retrieve filter parameters from the request
        $department = $request->input('department');
        $position = $request->input('position');
        $user_name = $request->input('user_name');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Query to fetch attendance data based on filters
        $attendanceQuery = Attendance::query()
            ->select('attendances.*', 'users.name as user_name', 'users.department', 'users.position')
            ->join('users', 'attendances.user_id', '=', 'users.id');

        if (!empty($department)) {
            $attendanceQuery->where('users.department', $department);
        }

        if (!empty($position)) {
            $attendanceQuery->where('users.position', $position);
        }

        if (!empty($user_name)) {
            $attendanceQuery->where('users.name', 'LIKE', "%$user_name%");
        }

        if ($startDate && $endDate) {
            $attendanceQuery->whereBetween('date', [$startDate, $endDate]);
        }

        $filteredData = $attendanceQuery->get()->toArray();

        // Generate and return the Excel file
        notify()->success('Silakan di cek yaa absensinya 🤙', 'Export Berhasil!');
        return Excel::download(new FilteredTableExport($filteredData), 'filtered_data.xlsx');
    }
}
