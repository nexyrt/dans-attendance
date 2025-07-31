<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class FaceRecognitionAttendanceController extends Controller
{
    /**
     * Store face recognition attendance
     */
    public function store(Request $request): JsonResponse
    {
        Log::info('🚀 STEP 8: ATTENDANCE REQUEST RECEIVED', [
            '═══════════════════════════════════════════════════════════',
            'timestamp' => now()->toISOString(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            '═══════════════════════════════════════════════════════════',
        ]);
        
        Log::info('📝 REQUEST DATA ANALYSIS', [
            'has_image' => $request->hasFile('image'),
            'has_username' => $request->has('username'),
            'has_timestamp' => $request->has('timestamp'),
            'has_confidence' => $request->has('confidence'),
            'has_auto_checkin' => $request->has('auto_checkin'),
            'csrf_token_present' => $request->has('_token'),
            'all_form_keys' => array_keys($request->all()),
            'files_count' => count($request->allFiles()),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            Log::info('📸 IMAGE FILE ANALYSIS', [
                'original_name' => $image->getClientOriginalName(),
                'mime_type' => $image->getMimeType(),
                'size_bytes' => $image->getSize(),
                'size_mb' => round($image->getSize() / 1024 / 1024, 2),
                'is_valid' => $image->isValid(),
                'extension' => $image->getClientOriginalExtension(),
                'temporary_path' => $image->getPathname(),
            ]);
        }

        $inputData = $request->only(['username', 'timestamp', 'confidence', 'auto_checkin']);
        Log::info('📊 INPUT PARAMETERS', $inputData);

        try {
            Log::info('🔍 STEP 8a: STARTING VALIDATION');
            
            // Your existing validation code here...
            $validator = Validator::make($request->all(), [
                'image' => 'required|file|image|mimes:jpeg,jpg,png|max:10240',
                'timestamp' => 'required|date',
                'username' => 'sometimes|string|max:255',
                'confidence' => 'sometimes|numeric|min:0|max:100',
                'auto_checkin' => 'sometimes|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('❌ STEP 8a FAILED: VALIDATION ERRORS', [
                    'errors' => $validator->errors()->toArray(),
                    'failed_rules' => $validator->failed(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            Log::info('✅ STEP 8a: VALIDATION PASSED');

            // Extract validated data
            $image = $request->file('image');
            $timestamp = Carbon::parse($request->input('timestamp'));
            $username = $request->input('username');
            $confidence = $request->input('confidence');
            $isAutoCheckin = $request->boolean('auto_checkin');

            $currentTimeMakassar = Carbon::now('Asia/Makassar');
            $todayMakassar = $currentTimeMakassar->format('Y-m-d');

            Log::info('📋 STEP 8b: PROCESSED DATA', [
                'parsed_timestamp' => $timestamp->toISOString(),
                'username' => $username,
                'confidence' => $confidence,
                'is_auto_checkin' => $isAutoCheckin,
                'today_date' => $timestamp->format('Y-m-d'),
            ]);

            // Image validation
            Log::info('🔍 STEP 8c: IMAGE VALIDATION');
            
            if (!$image->isValid()) {
                Log::error('❌ STEP 8c FAILED: INVALID IMAGE', [
                    'error_message' => $image->getErrorMessage(),
                    'error_code' => $image->getError(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or corrupted image file: ' . $image->getErrorMessage()
                ], 400);
            }

            $imageInfo = @getimagesize($image->getPathname());
            if (!$imageInfo) {
                Log::error('❌ STEP 8c FAILED: CANNOT READ IMAGE PROPERTIES', [
                    'file_size' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                    'temp_path' => $image->getPathname(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to process image file. Please try with a different image.'
                ], 400);
            }

            Log::info('✅ STEP 8c: IMAGE VALIDATION PASSED', [
                'dimensions' => $imageInfo[0] . 'x' . $imageInfo[1],
                'channels' => $imageInfo['channels'] ?? 'unknown',
                'bits_per_pixel' => $imageInfo['bits'] ?? 'unknown',
            ]);


            // User search
            Log::info('🔍 STEP 8d: USER SEARCH');
            $user = null;

            if ($username) {
                Log::info('├── Searching for user with multiple strategies...', ['username' => $username]);
                
                // Strategy 1: Exact name match
                $user = User::where('name', $username)->first();
                Log::info('├── Strategy 1 (exact name):', ['result' => $user ? 'Found ID ' . $user->id : 'Not found']);
                
                if (!$user) {
                    // Strategy 2: Case-insensitive name match
                    $user = User::whereRaw('LOWER(name) = ?', [strtolower($username)])->first();
                    Log::info('├── Strategy 2 (case-insensitive):', ['result' => $user ? 'Found ID ' . $user->id : 'Not found']);
                }
                
                if (!$user) {
                    // Strategy 3: Partial name match
                    $user = User::where('name', 'like', '%' . $username . '%')->first();
                    Log::info('├── Strategy 3 (partial name):', ['result' => $user ? 'Found ID ' . $user->id : 'Not found']);
                }
                
                if (!$user) {
                    // Strategy 4: Email search
                    $user = User::where('email', 'like', '%' . $username . '%')->first();
                    Log::info('├── Strategy 4 (email search):', ['result' => $user ? 'Found ID ' . $user->id : 'Not found']);
                }

                if ($user) {
                    Log::info('✅ STEP 8d: USER FOUND', [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'department_id' => $user->department_id,
                        'searched_username' => $username,
                    ]);
                } else {
                    Log::warning('⚠️ STEP 8d: USER NOT FOUND', [
                        'searched_username' => $username,
                        'search_strategies_tried' => 4,
                        'is_auto_checkin' => $isAutoCheckin,
                    ]);
                    
                    if (!$isAutoCheckin) {
                        return response()->json([
                            'success' => false,
                            'message' => "User '{$username}' not found in the system",
                            'data' => [
                                'searched_username' => $username,
                                'suggestion' => 'Please check the username or enroll the user first'
                            ]
                        ], 404);
                    }
                }
            } else {
                Log::info('├── No username provided, proceeding without user', ['auto_checkin' => $isAutoCheckin]);
            }

            // Duplicate check
            Log::info('🔍 STEP 8e: DUPLICATE CHECK');
            $today = $timestamp->format('Y-m-d');
            
            if ($user) {
                $existingAttendance = Attendance::where('user_id', $user->id)
                    ->where('date', $today)
                    ->whereNotNull('check_in')
                    ->first();

                if ($existingAttendance) {
                    Log::warning('⚠️ STEP 8e: DUPLICATE ATTENDANCE DETECTED', [
                        'user_id' => $user->id,
                        'username' => $username,
                        'existing_attendance_id' => $existingAttendance->id,
                        'existing_checkin' => $existingAttendance->check_in->format('H:i:s'),
                        'attempted_checkin' => $timestamp->format('H:i:s'),
                        'time_difference_minutes' => $existingAttendance->check_in->diffInMinutes($timestamp),
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Already checked in today',
                        'data' => [
                            'existing_checkin' => $existingAttendance->check_in->format('H:i:s'),
                            'user' => $user->name,
                            'date' => $today,
                            'attendance_id' => $existingAttendance->id
                        ]
                    ], 409);
                }
                
                Log::info('✅ STEP 8e: NO DUPLICATE FOUND');
            }

            // Image storage
            Log::info('STEP 8f: IMAGE STORAGE STARTED');
            $imagePath = null;

            try {
                $directory = 'attendance/' . $today;
                $filename = ($username ?: 'unknown') . '_' . 
                        $timestamp->format('H-i-s') . '_' . 
                        uniqid() . '.' . $image->getClientOriginalExtension();
                
                Log::info('Storage details prepared', [
                    'directory' => $directory,
                    'filename' => $filename,
                    'full_path' => $directory . '/' . $filename,
                    'storage_disk' => 'public',
                ]);
                
                // Check directory exists
                if (!Storage::disk('public')->exists($directory)) {
                    Log::info('Creating directory', ['directory' => $directory]);
                    Storage::disk('public')->makeDirectory($directory);
                }
                
                $storageStart = microtime(true);
                $imagePath = Storage::disk('public')->putFileAs($directory, $image, $filename);
                $storageEnd = microtime(true);
                
                if (!$imagePath) {
                    throw new \Exception('Storage::putFileAs returned false');
                }
                
                Log::info('STEP 8f SUCCESS: IMAGE STORED', [
                    'storage_path' => $imagePath,
                    'storage_time_ms' => round(($storageEnd - $storageStart) * 1000, 2),
                    'file_exists' => Storage::disk('public')->exists($imagePath),
                    'file_size' => Storage::disk('public')->size($imagePath),
                    'public_url' => Storage::disk('public')->url($imagePath),
                ]);
                
            } catch (\Exception $storageError) {
                Log::error('STEP 8f FAILED: IMAGE STORAGE ERROR', [
                    'error_message' => $storageError->getMessage(),
                    'error_file' => $storageError->getFile(),
                    'error_line' => $storageError->getLine(),
                    'directory' => $directory ?? 'unknown',
                    'filename' => $filename ?? 'unknown',
                ]);
                
                // Continue without image - don't fail the attendance
                $imagePath = null;
            }

            // LATE HOURS CALCULATION
            Log::info('STEP 8f: CALCULATING LATE HOURS AND STATUS');

            // Define work start time (8:30 AM) for the SAME DATE as check-in
            $checkInDate = $timestamp->format('Y-m-d'); // Get the date from check-in timestamp
            $workStartTime = Carbon::parse($checkInDate . ' 08:30:00', 'Asia/Makassar');

            Log::info('Late calculation details - DEBUGGING', [
                'check_in_timestamp_original' => $request->input('timestamp'),
                'check_in_timestamp_parsed' => $timestamp->toISOString(),
                'check_in_date_extracted' => $checkInDate,
                'work_start_time_created' => $workStartTime->toISOString(),
                'work_start_formatted' => $workStartTime->format('Y-m-d H:i:s'),
                'check_in_formatted' => $timestamp->format('Y-m-d H:i:s'),
                'timezone' => 'Asia/Makassar'
            ]);

            // Calculate if late and late hours
            $isLate = $timestamp->isAfter($workStartTime);
            $lateHours = 0;
            $status = 'present'; // Default status

            if ($isLate) {
                // Calculate late duration in minutes - FIXED CALCULATION
                $lateMinutes = $workStartTime->diffInMinutes($timestamp);
                
                // Convert to hours (decimal format: 1.5 hours = 1 hour 30 minutes)
                $lateHours = round($lateMinutes / 60, 2);
                
                // Set status to late
                $status = 'late';
                
                Log::info('LATE ATTENDANCE DETECTED - FIXED CALCULATION', [
                    'user' => $username,
                    'work_start_date' => $workStartTime->format('Y-m-d'),
                    'work_start_time' => $workStartTime->format('H:i:s'),
                    'check_in_date' => $timestamp->format('Y-m-d'),
                    'check_in_time' => $timestamp->format('H:i:s'),
                    'time_difference_calculation' => [
                        'work_start_timestamp' => $workStartTime->timestamp,
                        'check_in_timestamp' => $timestamp->timestamp,
                        'difference_seconds' => $timestamp->timestamp - $workStartTime->timestamp,
                        'difference_minutes' => $lateMinutes,
                        'difference_hours_decimal' => $lateHours
                    ],
                    'late_minutes' => $lateMinutes,
                    'late_hours' => $lateHours,
                    'status' => $status
                ]);
                
                // Additional validation to catch errors
                if ($lateHours > 12) {
                    Log::error('SUSPICIOUS LATE HOURS DETECTED - POSSIBLE CALCULATION ERROR', [
                        'late_hours_calculated' => $lateHours,
                        'late_minutes_calculated' => $lateMinutes,
                        'work_start_full' => $workStartTime->toISOString(),
                        'check_in_full' => $timestamp->toISOString(),
                        'carbon_diff_result' => $workStartTime->diffInMinutes($timestamp),
                        'manual_calculation' => [
                            'work_start_hour' => $workStartTime->hour,
                            'work_start_minute' => $workStartTime->minute,
                            'check_in_hour' => $timestamp->hour,
                            'check_in_minute' => $timestamp->minute,
                            'hour_diff' => $timestamp->hour - $workStartTime->hour,
                            'minute_diff' => $timestamp->minute - $workStartTime->minute,
                            'manual_late_minutes' => (($timestamp->hour - $workStartTime->hour) * 60) + ($timestamp->minute - $workStartTime->minute),
                            'manual_late_hours' => round(((($timestamp->hour - $workStartTime->hour) * 60) + ($timestamp->minute - $workStartTime->minute)) / 60, 2)
                        ]
                    ]);
                    
                    // Use manual calculation as fallback
                    $manualLateMinutes = (($timestamp->hour - $workStartTime->hour) * 60) + ($timestamp->minute - $workStartTime->minute);
                    
                    // Only use manual calculation if it's reasonable (less than 12 hours)
                    if ($manualLateMinutes > 0 && $manualLateMinutes < 720) { // 720 minutes = 12 hours
                        $lateMinutes = $manualLateMinutes;
                        $lateHours = round($lateMinutes / 60, 2);
                        
                        Log::info('USED MANUAL CALCULATION AS FALLBACK', [
                            'corrected_late_minutes' => $lateMinutes,
                            'corrected_late_hours' => $lateHours
                        ]);
                    }
                }
            } else {
                Log::info('ON TIME ATTENDANCE', [
                    'user' => $username,
                    'work_start' => $workStartTime->format('H:i:s'),
                    'check_in' => $timestamp->format('H:i:s'),
                    'status' => $status
                ]);
            }

            // Final validation
            Log::info('FINAL LATE CALCULATION RESULT', [
                'is_late' => $isLate,
                'late_hours' => $lateHours,
                'late_minutes' => $isLate ? $lateMinutes : 0,
                'status' => $status,
                'calculation_method' => $lateHours > 12 ? 'manual_fallback' : 'carbon_diff'
            ]);




            // Create attendance record
             Log::info('STEP 8g: CREATING ATTENDANCE RECORD WITH LATE CALCULATION');
        
            $attendanceData = [
                'date' => $todayMakassar,
                'check_in' => $timestamp,
                'status' => $status,                    // 'present' or 'late'
                'late_hours' => $lateHours,            // Decimal hours (e.g., 1.5 for 1h 30m)
                'device_type' => 'web_face_recognition'
            ];

            if ($user) {
                $attendanceData['user_id'] = $user->id;
            }

            // Enhanced metadata with late information
            $faceRecognitionData = [
                'method' => 'face_recognition',
                'auto_checkin' => $isAutoCheckin,
                'confidence' => $confidence,
                'image_path' => $imagePath,
                'timestamp' => $timestamp->toISOString(),
                'timezone' => 'Asia/Makassar',
                
                // Late calculation metadata
                'work_start_time' => $workStartTime->format('H:i:s'),
                'check_in_time' => $timestamp->format('H:i:s'),
                'is_late' => $isLate,
                'late_minutes' => $isLate ? $workStartTime->diffInMinutes($timestamp) : 0,
                'late_hours_calculated' => $lateHours,
                'attendance_status' => $status,
                
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'image_size' => $image->getSize(),
                'image_dimensions' => $imageInfo ? [$imageInfo[0], $imageInfo[1]] : null,
                'detected_face_count' => 1,
                'processing_version' => '1.0',
                'request_id' => uniqid('req_'),
            ];

            if ($username && !$user) {
                $faceRecognitionData['detected_name'] = $username;
                $faceRecognitionData['user_matched'] = false;
            } else {
                $faceRecognitionData['user_matched'] = true;
            }

            $attendanceData['notes'] = json_encode($faceRecognitionData);

            Log::info('Attendance data prepared with late calculation', [
                'user_id' => $attendanceData['user_id'] ?? null,
                'date' => $attendanceData['date'],
                'check_in_makassar' => $attendanceData['check_in']->format('Y-m-d H:i:s'),
                'status' => $attendanceData['status'],
                'late_hours' => $attendanceData['late_hours'],
                'is_late' => $isLate,
                'timezone' => 'Asia/Makassar',
            ]);

            $dbStart = microtime(true);
            $attendance = Attendance::create($attendanceData);
            $dbEnd = microtime(true);

            if (!$attendance) {
                throw new \Exception('Attendance::create returned null');
            }

            Log::info('STEP 8g SUCCESS: ATTENDANCE RECORD CREATED WITH LATE CALCULATION', [
                'attendance_id' => $attendance->id,
                'database_time_ms' => round(($dbEnd - $dbStart) * 1000, 2),
                'status' => $attendance->status,
                'late_hours' => $attendance->late_hours,
                'is_late' => $isLate,
                'work_start_time' => $workStartTime->format('H:i:s'),
                'check_in_time' => $timestamp->format('H:i:s'),
            ]);

            // Enhanced response with late information
            $responseData = [
                'attendance_id' => $attendance->id,
                'date' => $todayMakassar,
                'check_in_time' => $timestamp->format('H:i:s'),
                'check_in_full' => $timestamp->toISOString(),
                'timezone' => 'Asia/Makassar',
                'method' => 'face_recognition',
                'auto_checkin' => $isAutoCheckin,
                'confidence' => $confidence,
                'status' => $status,
                
                // Late information in response
                'is_late' => $isLate,
                'late_hours' => $lateHours,
                'work_start_time' => $workStartTime->format('H:i:s'),
                'late_message' => $isLate ? 
                    "Late by " . $this->formatLateHours($lateHours) : 
                    "On time",
            ];

            if ($user) {
                $responseData['user'] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'department' => $user->department?->name
                ];
            } else {
                $responseData['detected_name'] = $username;
                $responseData['user_matched'] = false;
            }

            if ($imagePath) {
                $responseData['image_url'] = Storage::disk('public')->url($imagePath);
                $responseData['image_path'] = $imagePath;
            }

            Log::info('STEP 8 COMPLETED: ATTENDANCE WITH LATE CALCULATION PROCESSED', [
                'attendance_id' => $attendance->id,
                'user_id' => $user?->id,
                'username' => $username,
                'check_in_time_makassar' => $timestamp->format('H:i:s'),
                'status' => $status,
                'is_late' => $isLate,
                'late_hours' => $lateHours,
                'late_message' => $responseData['late_message'],
            ]);

            // Success message based on late status
            $successMessage = $isAutoCheckin ? 'Automatic attendance recorded successfully' : 'Attendance recorded successfully';
            if ($isLate) {
                $successMessage .= ' (Late arrival detected)';
            }

            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'data' => $responseData
            ], 201);

        } catch (\Exception $e) {
            Log::error('STEP 8 FAILED: UNEXPECTED ERROR', [
                'error_class' => get_class($e),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'username' => $request->input('username'),
                'auto_checkin' => $request->input('auto_checkin'),
                'timezone' => 'Asia/Makassar',
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while recording attendance',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get today's attendance records with enhanced error handling
     */
    public function getTodaysAttendance(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'sometimes|date|date_format:Y-m-d'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format. Use YYYY-MM-DD format.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = $request->query('date', Carbon::today()->format('Y-m-d'));
            
            Log::info('Fetching today\'s attendance', [
                'date' => $date,
                'requested_by' => $request->ip()
            ]);

            $attendances = Attendance::with(['user:id,name,email,department_id', 'user.department:id,name'])
                ->where('date', $date)
                ->whereNotNull('check_in')
                ->orderBy('check_in', 'desc')
                ->get();

            $formattedAttendances = $attendances->map(function ($attendance) {
                $notes = null;
                
                // Safely decode JSON notes
                if ($attendance->notes) {
                    try {
                        $notes = is_string($attendance->notes) ? 
                            json_decode($attendance->notes, true) : 
                            $attendance->notes;
                    } catch (\Exception $e) {
                        Log::warning('Failed to decode attendance notes', [
                            'attendance_id' => $attendance->id,
                            'notes' => $attendance->notes
                        ]);
                        $notes = null;
                    }
                }
                
                $data = [
                    'id' => $attendance->id,
                    'date' => $attendance->date,
                    'check_in' => $attendance->check_in->toISOString(),
                    'check_in_time' => $attendance->check_in->format('H:i:s'),
                    'status' => $attendance->status,
                    'created_at' => $attendance->created_at->toISOString(),
                ];

                // Add user information
                if ($attendance->user) {
                    $data['user_name'] = $attendance->user->name;
                    $data['user_email'] = $attendance->user->email;
                    $data['user_id'] = $attendance->user->id;
                    
                    if ($attendance->user->department) {
                        $data['department'] = $attendance->user->department->name;
                    }
                } elseif (is_array($notes) && isset($notes['detected_name'])) {
                    $data['user_name'] = $notes['detected_name'];
                    $data['user_matched'] = false;
                }

                // Add face recognition specific data
                if (is_array($notes)) {
                    $data['confidence'] = $notes['confidence'] ?? null;
                    $data['auto_checkin'] = $notes['auto_checkin'] ?? false;
                    $data['method'] = $notes['method'] ?? 'unknown';
                    
                    if (isset($notes['image_path']) && $notes['image_path']) {
                        try {
                            $data['image_url'] = Storage::disk('public')->url($notes['image_path']);
                        } catch (\Exception $e) {
                            Log::warning('Failed to generate image URL', [
                                'attendance_id' => $attendance->id,
                                'image_path' => $notes['image_path']
                            ]);
                        }
                    }
                }

                return $data;
            });

            Log::info('Successfully fetched today\'s attendance', [
                'date' => $date,
                'count' => $formattedAttendances->count()
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'date' => $date,
                    'attendances' => $formattedAttendances,
                    'total_count' => $formattedAttendances->count()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching today\'s attendance: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching attendance records',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get attendance statistics with enhanced metrics
     */
    public function getStatistics(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'sometimes|date|date_format:Y-m-d',
                'start_date' => 'sometimes|date|date_format:Y-m-d',
                'end_date' => 'sometimes|date|date_format:Y-m-d|after_or_equal:start_date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date parameters',
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = $request->query('date', Carbon::today()->format('Y-m-d'));
            $startDate = $request->query('start_date', $date);
            $endDate = $request->query('end_date', $date);
            
            $stats = [
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'is_single_day' => $startDate === $endDate
                ],
                'total_checkins' => 0,
                'auto_checkins' => 0,
                'manual_checkins' => 0,
                'face_recognition_checkins' => 0,
                'average_confidence' => 0,
                'unique_users' => 0,
                'hourly_distribution' => []
            ];

            $attendances = Attendance::whereBetween('date', [$startDate, $endDate])
                ->whereNotNull('check_in')
                ->with('user:id,name')
                ->get();

            $stats['total_checkins'] = $attendances->count();

            $confidences = [];
            $autoCount = 0;
            $faceRecognitionCount = 0;
            $userIds = [];
            $hourlyData = [];

            foreach ($attendances as $attendance) {
                $notes = null;
                
                if ($attendance->notes) {
                    try {
                        $notes = is_string($attendance->notes) ? 
                            json_decode($attendance->notes, true) : 
                            $attendance->notes;
                    } catch (\Exception $e) {
                        continue; // Skip invalid notes
                    }
                }
                
                // Track unique users
                if ($attendance->user_id) {
                    $userIds[] = $attendance->user_id;
                }
                
                // Track hourly distribution
                $hour = $attendance->check_in->format('H');
                $hourlyData[$hour] = ($hourlyData[$hour] ?? 0) + 1;
                
                if (is_array($notes)) {
                    if (isset($notes['method']) && $notes['method'] === 'face_recognition') {
                        $faceRecognitionCount++;
                        
                        if (isset($notes['confidence']) && is_numeric($notes['confidence'])) {
                            $confidences[] = floatval($notes['confidence']);
                        }
                        
                        if ($notes['auto_checkin'] ?? false) {
                            $autoCount++;
                        }
                    }
                }
            }

            $stats['auto_checkins'] = $autoCount;
            $stats['manual_checkins'] = $faceRecognitionCount - $autoCount;
            $stats['face_recognition_checkins'] = $faceRecognitionCount;
            $stats['unique_users'] = count(array_unique($userIds));
            
            if (count($confidences) > 0) {
                $stats['average_confidence'] = round(array_sum($confidences) / count($confidences), 1);
                $stats['min_confidence'] = round(min($confidences), 1);
                $stats['max_confidence'] = round(max($confidences), 1);
            }

            // Format hourly distribution
            for ($h = 0; $h < 24; $h++) {
                $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                $stats['hourly_distribution'][] = [
                    'hour' => $hour . ':00',
                    'count' => $hourlyData[$hour] ?? 0
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching attendance statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    private function formatLateHours($lateHours)
    {
        if ($lateHours == 0) {
            return "0 minutes";
        }
        
        $hours = floor($lateHours);
        $minutes = round(($lateHours - $hours) * 60);
        
        $result = '';
        if ($hours > 0) {
            $result .= $hours . ($hours == 1 ? ' hour' : ' hours');
        }
        
        if ($minutes > 0) {
            if ($hours > 0) {
                $result .= ' ';
            }
            $result .= $minutes . ($minutes == 1 ? ' minute' : ' minutes');
        }
        
        return $result;
    }
}