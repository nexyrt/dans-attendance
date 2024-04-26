<?php

namespace App\Http\Controllers;

use App\Exports\FilteredDataExport;
use App\Exports\FilteredTableExport;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $activity_log = Attendance::with('employee')->get();
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();

        $attendanceRecordExists = $this->checkAttendanceRecordExists($employee->id);
        $hasCheckedOut = $this->hasCheckedOut($employee->id);

        $attendance = Attendance::whereMonth('date', now()->month())
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

    public function fetchData(Request $request)
    {
        $department = $request->input('department');
        $position = $request->input('position');
        $employeeName = $request->input('employee_name');

        $query = Attendance::with('employee');

        if ($department) {
            $query->whereHas('employee', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        if ($position) {
            $query->whereHas('employee', function ($q) use ($position) {
                $q->where('position', $position);
            });
        }

        if ($employeeName) {
            $query->whereHas('employee', function ($q) use ($employeeName) {
                $q->where('name', 'like', '%' . $employeeName . '%');
            });
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
        $employeeName = $request->input('employeeName');

        // Query to fetch attendance data based on filters
        $attendanceQuery = Attendance::query()
            ->select('attendances.*', 'employees.name as employee_name', 'employees.department', 'employees.position')
            ->join('employees', 'attendances.employee_id', '=', 'employees.id');

        if (!empty($department)) {
            $attendanceQuery->where('employees.department', $department);
        }

        if (!empty($position)) {
            $attendanceQuery->where('employees.position', $position);
        }

        if (!empty($employeeName)) {
            $attendanceQuery->where('employees.name', 'LIKE', "%$employeeName%");
        }

        $filteredData = $attendanceQuery->get()->toArray();

        // Generate and return the Excel file
        return Excel::download(new FilteredTableExport($filteredData), 'filtered_data.xlsx');
    }
}
