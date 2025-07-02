<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'device_type' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);
        $today = Carbon::now()->format('Y-m-d');

        // Check if already checked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in today'
            ], 409);
        }

        // Create or update attendance record
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => $today
            ],
            [
                'check_in' => Carbon::now(),
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'device_type' => $request->device_type,
                'status' => 'present'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful',
            'data' => [
                'user' => $user->name,
                'check_in_time' => $attendance->check_in->format('H:i:s'),
                'date' => $attendance->date,
                'action' => 'check-in'
            ]
        ]);
    }

    public function checkOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);
        $today = Carbon::now()->format('Y-m-d');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'No check-in record found for today'
            ], 404);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked out today'
            ], 409);
        }

        // Calculate working hours
        $checkOut = Carbon::now();
        $workingHours = $attendance->check_in->diffInHours($checkOut, false);

        $attendance->update([
            'check_out' => $checkOut,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'working_hours' => round($workingHours, 2)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out successful',
            'data' => [
                'user' => $user->name,
                'check_out_time' => $attendance->check_out->format('H:i:s'),
                'working_hours' => round($workingHours, 2),
                'date' => $attendance->date,
                'action' => 'check-out'
            ]
        ]);
    }

    /**
     * Universal attendance endpoint that determines action based on time and existing records
     * Supports both GET and POST requests
     */
    public function universalAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'device_type' => 'nullable|string',
            'action' => 'nullable|string|in:check-in,check-out',
            'scan_time' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now();

        // Get existing attendance for today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // Determine action if not provided
        $action = $request->action;
        if (!$action) {
            $action = $this->determineActionByTime($currentTime, $existingAttendance);
        }

        // For GET requests (from QR code), redirect to a success page or return JSON
        if ($request->isMethod('get')) {
            // You can either return JSON or redirect to a web page
            return $this->handleGetRequest($user, $action, $existingAttendance, $currentTime);
        }

        // For POST requests (from web scanner), perform the action normally
        if ($action === 'check-in') {
            return $this->performCheckIn($user, $existingAttendance, $request, $currentTime);
        } else {
            return $this->performCheckOut($user, $existingAttendance, $request, $currentTime);
        }
    }

    /**
     * Handle GET requests from QR code scans (when user clicks the QR link)
     */
    private function handleGetRequest($user, $action, $existingAttendance, $currentTime)
    {
        // Create a mock request with default values for GET requests
        $mockRequest = new \Illuminate\Http\Request([
            'user_id' => $user->id,
            'latitude' => null,
            'longitude' => null,
            'device_type' => 'qr_direct'
        ]);

        // Perform the action
        if ($action === 'check-in') {
            $result = $this->performCheckIn($user, $existingAttendance, $mockRequest, $currentTime);
        } else {
            $result = $this->performCheckOut($user, $existingAttendance, $mockRequest, $currentTime);
        }

        // Convert to array to check success
        $resultData = json_decode($result->getContent(), true);

        if ($resultData['success']) {
            // Return a simple success page or JSON
            return response()->json([
                'success' => true,
                'message' => $resultData['message'],
                'data' => $resultData['data'],
                'user' => $user->name,
                'action' => $action,
                'time' => $currentTime->format('H:i:s'),
                'date' => $currentTime->format('Y-m-d')
            ]);
        } else {
            return $result; // Return the error response
        }
    }

    /**
     * Determine action based on current time and existing attendance
     */
    private function determineActionByTime($currentTime, $existingAttendance = null)
    {
        $currentHour = $currentTime->hour;

        // If user hasn't checked in today, it's always check-in
        if (!$existingAttendance || !$existingAttendance->check_in) {
            return 'check-in';
        }

        // If user has checked in but not checked out
        if ($existingAttendance->check_in && !$existingAttendance->check_out) {
            // Time-based logic for check-out
            if ($currentHour >= 14 && $currentHour < 22) {
                return 'check-out'; // Evening check-out
            } elseif ($currentHour >= 12 && $currentHour < 14) {
                return 'check-out'; // Lunch time check-out
            } else {
                return 'check-out'; // Default to check-out if already checked in
            }
        }

        // Default fallback
        return 'check-in';
    }

    /**
     * Perform check-in operation
     */
    private function performCheckIn($user, $existingAttendance, $request, $currentTime)
    {
        if ($existingAttendance && $existingAttendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in today at ' . $existingAttendance->check_in->format('H:i:s')
            ], 409);
        }

        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => $currentTime->format('Y-m-d')
            ],
            [
                'check_in' => $currentTime,
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'device_type' => $request->device_type ?? 'web_qr',
                'status' => 'present'
            ]
        );

        $timeOfDay = $this->getTimeOfDayGreeting($currentTime);

        return response()->json([
            'success' => true,
            'message' => "{$timeOfDay} {$user->name}! Check-in successful",
            'data' => [
                'user' => $user->name,
                'check_in_time' => $attendance->check_in->format('H:i:s'),
                'date' => $attendance->date,
                'action' => 'check-in',
                'time_of_day' => $timeOfDay
            ]
        ]);
    }

    /**
     * Perform check-out operation
     */
    private function performCheckOut($user, $existingAttendance, $request, $currentTime)
    {
        if (!$existingAttendance || !$existingAttendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'No check-in record found for today. Please check-in first.'
            ], 404);
        }

        if ($existingAttendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked out today at ' . $existingAttendance->check_out->format('H:i:s')
            ], 409);
        }

        // Calculate working hours
        $workingHours = $existingAttendance->check_in->diffInHours($currentTime, false);

        $existingAttendance->update([
            'check_out' => $currentTime,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'working_hours' => round($workingHours, 2)
        ]);

        $timeOfDay = $this->getTimeOfDayGreeting($currentTime);

        return response()->json([
            'success' => true,
            'message' => "{$timeOfDay} {$user->name}! Check-out successful",
            'data' => [
                'user' => $user->name,
                'check_out_time' => $existingAttendance->check_out->format('H:i:s'),
                'working_hours' => round($workingHours, 2),
                'date' => $existingAttendance->date,
                'action' => 'check-out',
                'time_of_day' => $timeOfDay,
                'total_hours_today' => round($workingHours, 2)
            ]
        ]);
    }

    /**
     * Get appropriate greeting based on time of day
     */
    private function getTimeOfDayGreeting($time)
    {
        $hour = $time->hour;

        if ($hour >= 5 && $hour < 12) {
            return 'Good morning';
        } elseif ($hour >= 12 && $hour < 17) {
            return 'Good afternoon';
        } elseif ($hour >= 17 && $hour < 22) {
            return 'Good evening';
        } else {
            return 'Good night';
        }
    }

    /**
     * Get attendance status for a user
     */
    public function getAttendanceStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);
        $today = Carbon::now()->format('Y-m-d');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $status = [
            'user' => $user->name,
            'date' => $today,
            'checked_in' => false,
            'checked_out' => false,
            'check_in_time' => null,
            'check_out_time' => null,
            'working_hours' => 0,
            'next_action' => 'check-in'
        ];

        if ($attendance) {
            if ($attendance->check_in) {
                $status['checked_in'] = true;
                $status['check_in_time'] = $attendance->check_in->format('H:i:s');
                $status['next_action'] = 'check-out';
            }

            if ($attendance->check_out) {
                $status['checked_out'] = true;
                $status['check_out_time'] = $attendance->check_out->format('H:i:s');
                $status['working_hours'] = $attendance->working_hours ?? 0;
                $status['next_action'] = 'completed';
            }
        }

        return response()->json([
            'success' => true,
            'data' => $status
        ]);
    }
}