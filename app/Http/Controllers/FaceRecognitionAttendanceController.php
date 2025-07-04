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
        Log::info('Face recognition attendance request received', [
            'has_image' => $request->hasFile('image'),
            'username' => $request->input('username'),
            'auto_checkin' => $request->input('auto_checkin'),
            'confidence' => $request->input('confidence'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            // Enhanced validation with better error messages
            $validator = Validator::make($request->all(), [
                'image' => 'required|file|image|mimes:jpeg,jpg,png|max:10240', // Increased to 10MB
                'timestamp' => 'required|date',
                'username' => 'sometimes|string|max:255',
                'confidence' => 'sometimes|numeric|min:0|max:100',
                'auto_checkin' => 'sometimes|boolean'
            ], [
                'image.required' => 'Attendance image is required',
                'image.file' => 'Invalid file uploaded',
                'image.image' => 'File must be a valid image',
                'image.mimes' => 'Only JPEG, JPG, and PNG images are allowed',
                'image.max' => 'Image size cannot exceed 10MB',
                'timestamp.required' => 'Timestamp is required',
                'timestamp.date' => 'Invalid timestamp format',
                'username.string' => 'Username must be a string',
                'username.max' => 'Username cannot exceed 255 characters',
                'confidence.numeric' => 'Confidence must be a number',
                'confidence.min' => 'Confidence cannot be negative',
                'confidence.max' => 'Confidence cannot exceed 100',
                'auto_checkin.boolean' => 'Auto check-in must be true or false'
            ]);

            if ($validator->fails()) {
                Log::warning('Face recognition attendance validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->except(['image'])
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $image = $request->file('image');
            $timestamp = Carbon::parse($request->input('timestamp'));
            $username = $request->input('username');
            $confidence = $request->input('confidence');
            $isAutoCheckin = $request->boolean('auto_checkin');

            // Validate image file more thoroughly
            if (!$image->isValid()) {
                Log::error('Invalid image file uploaded', [
                    'error' => $image->getErrorMessage(),
                    'username' => $username
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or corrupted image file: ' . $image->getErrorMessage()
                ], 400);
            }

            // Check image properties
            $imageInfo = @getimagesize($image->getPathname());
            if (!$imageInfo) {
                Log::error('Unable to read image properties', [
                    'username' => $username,
                    'file_size' => $image->getSize(),
                    'mime_type' => $image->getMimeType()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to process image file. Please try with a different image.'
                ], 400);
            }

            // Find user if username is provided
            $user = null;
            if ($username) {
                // Try multiple search strategies
                $user = User::where('name', $username)->first();
                
                if (!$user) {
                    // Try case-insensitive search
                    $user = User::whereRaw('LOWER(name) = ?', [strtolower($username)])->first();
                }
                
                if (!$user) {
                    // Try partial name match
                    $user = User::where('name', 'like', '%' . $username . '%')->first();
                }
                
                if (!$user) {
                    // Try email search
                    $user = User::where('email', 'like', '%' . $username . '%')->first();
                }

                if (!$user) {
                    Log::warning('User not found for face recognition attendance', [
                        'username' => $username,
                        'confidence' => $confidence
                    ]);
                    
                    // For auto check-in, we might want to continue without user
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
                } else {
                    Log::info('User found for attendance', [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'searched_username' => $username
                    ]);
                }
            }

            // Check if user already has attendance for today
            $today = $timestamp->format('Y-m-d');
            if ($user) {
                $existingAttendance = Attendance::where('user_id', $user->id)
                    ->where('date', $today)
                    ->whereNotNull('check_in')
                    ->first();

                if ($existingAttendance) {
                    Log::info('User already checked in today', [
                        'user_id' => $user->id,
                        'username' => $username,
                        'existing_checkin' => $existingAttendance->check_in->format('H:i:s'),
                        'attempted_checkin' => $timestamp->format('H:i:s')
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Already checked in today',
                        'data' => [
                            'existing_checkin' => $existingAttendance->check_in->format('H:i:s'),
                            'user' => $user->name,
                            'date' => $today
                        ]
                    ], 409);
                }
            }

            // Store the attendance image with better error handling
            $imagePath = null;
            try {
                $directory = 'attendance/' . $today;
                $filename = ($username ?: 'unknown') . '_' . 
                           $timestamp->format('H-i-s') . '_' . 
                           uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Ensure directory exists
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                
                $imagePath = Storage::disk('public')->putFileAs($directory, $image, $filename);
                
                if (!$imagePath) {
                    throw new \Exception('Failed to store image file');
                }
                
                Log::info('Attendance image saved successfully', [
                    'path' => $imagePath,
                    'size' => $image->getSize(),
                    'original_name' => $image->getClientOriginalName()
                ]);
                
            } catch (\Exception $storageError) {
                Log::error('Failed to save attendance image', [
                    'error' => $storageError->getMessage(),
                    'username' => $username,
                    'timestamp' => $timestamp->toISOString()
                ]);
                
                // Continue without image - don't fail the attendance
                $imagePath = null;
            }

            // Create attendance record with comprehensive data
            $attendanceData = [
                'date' => $today,
                'check_in' => $timestamp,
                'status' => 'present',
                'device_type' => 'web_face_recognition'
            ];

            if ($user) {
                $attendanceData['user_id'] = $user->id;
            }

            // Create comprehensive face recognition metadata
            $faceRecognitionData = [
                'method' => 'face_recognition',
                'auto_checkin' => $isAutoCheckin,
                'confidence' => $confidence,
                'image_path' => $imagePath,
                'timestamp' => $timestamp->toISOString(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'image_size' => $image->getSize(),
                'image_dimensions' => $imageInfo ? [$imageInfo[0], $imageInfo[1]] : null,
                'detected_face_count' => 1, // Assuming single face detection
                'processing_version' => '1.0'
            ];

            if ($username && !$user) {
                $faceRecognitionData['detected_name'] = $username;
                $faceRecognitionData['user_matched'] = false;
            } else {
                $faceRecognitionData['user_matched'] = true;
            }

            $attendanceData['notes'] = json_encode($faceRecognitionData);

            // Create attendance record
            $attendance = Attendance::create($attendanceData);

            if (!$attendance) {
                throw new \Exception('Failed to create attendance record');
            }

            Log::info('Face recognition attendance recorded successfully', [
                'attendance_id' => $attendance->id,
                'user_id' => $user?->id,
                'username' => $username,
                'confidence' => $confidence,
                'auto_checkin' => $isAutoCheckin,
                'date' => $today,
                'check_in_time' => $timestamp->format('H:i:s')
            ]);

            // Prepare comprehensive response data
            $responseData = [
                'attendance_id' => $attendance->id,
                'date' => $today,
                'check_in_time' => $timestamp->format('H:i:s'),
                'check_in_full' => $timestamp->toISOString(),
                'method' => 'face_recognition',
                'auto_checkin' => $isAutoCheckin,
                'confidence' => $confidence,
                'status' => 'success'
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

            return response()->json([
                'success' => true,
                'message' => $isAutoCheckin ? 
                    'Automatic attendance recorded successfully' : 
                    'Attendance recorded successfully',
                'data' => $responseData
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error in face recognition attendance', [
                'errors' => $e->errors(),
                'username' => $request->input('username')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Face recognition attendance error: ' . $e->getMessage(), [
                'username' => $request->input('username'),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while recording attendance',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                'debug_info' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
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
}