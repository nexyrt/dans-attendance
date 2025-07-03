<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FaceEnrollmentController extends Controller
{
    /**
     * Store a new face enrollment
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'face_image' => 'required|file|image|mimes:jpeg,jpg,png|max:5120', // Max 5MB
                'username' => 'required|string|min:2|max:50|regex:/^[a-zA-Z0-9_-]+$/', // Alphanumeric, underscore, hyphen only
                'timestamp' => 'required|date'
            ], [
                'face_image.required' => 'Face image is required',
                'face_image.image' => 'File must be a valid image',
                'face_image.mimes' => 'Only JPEG, JPG, and PNG images are allowed',
                'face_image.max' => 'Image size cannot exceed 5MB',
                'username.required' => 'Username is required',
                'username.min' => 'Username must be at least 2 characters',
                'username.max' => 'Username cannot exceed 50 characters',
                'username.regex' => 'Username can only contain letters, numbers, underscores, and hyphens',
                'timestamp.required' => 'Timestamp is required',
                'timestamp.date' => 'Invalid timestamp format'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $username = trim($request->input('username'));
            $faceImage = $request->file('face_image');
            
            // Additional validation
            if (!$faceImage->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or corrupted image file'
                ], 400);
            }

            // Validate image dimensions (optional)
            $imageInfo = getimagesize($faceImage->getPathname());
            if (!$imageInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to read image file'
                ], 400);
            }

            [$width, $height] = $imageInfo;
            if ($width < 100 || $height < 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image dimensions too small. Minimum 100x100 pixels required'
                ], 400);
            }

            // Sanitize username for file system
            $sanitizedUsername = $this->sanitizeUsername($username);
            
            // Create directory in public path
            $publicPath = public_path('faces/' . $sanitizedUsername);
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }

            // Generate unique filename
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $randomString = Str::random(6);
            $extension = $faceImage->getClientOriginalExtension();
            $filename = $sanitizedUsername . '_' . $timestamp . '_' . $randomString . '.' . $extension;
            
            // Check if file already exists (very unlikely but good to check)
            $counter = 1;
            $originalFilename = $filename;
            while (file_exists($publicPath . '/' . $filename)) {
                $pathInfo = pathinfo($originalFilename);
                $filename = $pathInfo['filename'] . '_' . $counter . '.' . $pathInfo['extension'];
                $counter++;
            }

            // Move the uploaded file to public directory
            $moved = $faceImage->move($publicPath, $filename);

            if (!$moved) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save face image to storage'
                ], 500);
            }

            // Verify the file was actually saved
            $fullPath = $publicPath . '/' . $filename;
            if (!file_exists($fullPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image file was not saved properly'
                ], 500);
            }

            // Get file information
            $fileSize = filesize($fullPath);
            $relativePath = 'faces/' . $sanitizedUsername . '/' . $filename;
            $fileUrl = asset($relativePath);

            // Optional: Save to database for tracking
            $this->saveFaceEnrollmentToDatabase($username, $relativePath, $filename, $fileSize);

            // Log successful enrollment
            Log::info('Face enrollment successful', [
                'username' => $username,
                'filename' => $filename,
                'path' => $relativePath,
                'size' => $fileSize,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Face enrolled successfully',
                'data' => [
                    'username' => $username,
                    'filename' => $filename,
                    'path' => $relativePath,
                    'url' => $fileUrl,
                    'size' => $fileSize,
                    'dimensions' => [
                        'width' => $width,
                        'height' => $height
                    ],
                    'enrolled_at' => Carbon::now()->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Face enrollment error: ' . $e->getMessage(), [
                'username' => $request->input('username', 'unknown'),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['face_image']) // Don't log file data
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while enrolling face',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get all enrolled faces
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $username = $request->query('username');
            $facesDirectory = public_path('faces');
            $enrolledFaces = [];

            if (is_dir($facesDirectory)) {
                if ($username) {
                    // Get faces for specific username
                    $sanitizedUsername = $this->sanitizeUsername($username);
                    $userDirectory = $facesDirectory . '/' . $sanitizedUsername;
                    
                    if (is_dir($userDirectory)) {
                        $files = glob($userDirectory . '/*.{jpg,jpeg,png}', GLOB_BRACE);
                        $userFaces = $this->processImageFiles($files, $sanitizedUsername);
                        
                        $enrolledFaces[] = [
                            'username' => $username,
                            'face_count' => count($userFaces),
                            'faces' => $userFaces
                        ];
                    }
                } else {
                    // Get all enrolled faces
                    $directories = glob($facesDirectory . '/*', GLOB_ONLYDIR);
                    
                    foreach ($directories as $directory) {
                        $username = basename($directory);
                        $files = glob($directory . '/*.{jpg,jpeg,png}', GLOB_BRACE);
                        $userFaces = $this->processImageFiles($files, $username);
                        
                        if (!empty($userFaces)) {
                            $enrolledFaces[] = [
                                'username' => $username,
                                'face_count' => count($userFaces),
                                'faces' => $userFaces,
                                'latest_enrollment' => max(array_column($userFaces, 'last_modified'))
                            ];
                        }
                    }

                    // Sort by latest enrollment
                    usort($enrolledFaces, function ($a, $b) {
                        return ($b['latest_enrollment'] ?? 0) <=> ($a['latest_enrollment'] ?? 0);
                    });
                }
            }

            return response()->json([
                'success' => true,
                'data' => $enrolledFaces,
                'total_users' => count($enrolledFaces),
                'total_faces' => array_sum(array_column($enrolledFaces, 'face_count'))
            ]);

        } catch (\Exception $e) {
            Log::error('Face enrollment fetch error: ' . $e->getMessage(), [
                'username' => $username ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching enrolled faces',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Delete an enrolled face
     */
    public function destroy(Request $request, $identifier): JsonResponse
    {
        try {
            $validator = Validator::make([
                'identifier' => $identifier,
                'filename' => $request->input('filename')
            ], [
                'identifier' => 'required|string',
                'filename' => 'required_without:delete_all|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sanitizedUsername = $this->sanitizeUsername($identifier);
            $userDirectory = public_path('faces/' . $sanitizedUsername);

            if (!is_dir($userDirectory)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User face directory not found'
                ], 404);
            }

            $filename = $request->input('filename');
            $deleteAll = $request->input('delete_all', false);

            if ($deleteAll) {
                // Delete entire user directory
                $deleted = $this->deleteDirectory($userDirectory);
                
                if ($deleted) {
                    Log::info('All face enrollments deleted for user', [
                        'username' => $identifier,
                        'directory' => $userDirectory
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => "All face enrollments deleted for user: {$identifier}"
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to delete user face directory'
                    ], 500);
                }
            } else {
                // Delete specific file
                $filePath = $userDirectory . '/' . basename($filename);
                
                if (!file_exists($filePath)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Face image file not found'
                    ], 404);
                }

                $deleted = unlink($filePath);
                
                if ($deleted) {
                    Log::info('Face enrollment deleted', [
                        'username' => $identifier,
                        'filename' => $filename,
                        'path' => $filePath
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Face enrollment deleted successfully',
                        'data' => [
                            'username' => $identifier,
                            'filename' => $filename,
                            'deleted_at' => Carbon::now()->toISOString()
                        ]
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to delete face image file'
                    ], 500);
                }
            }

        } catch (\Exception $e) {
            Log::error('Face enrollment delete error: ' . $e->getMessage(), [
                'identifier' => $identifier,
                'filename' => $request->input('filename'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting face enrollment',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get face enrollment statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $facesDirectory = public_path('faces');
            $stats = [
                'total_users' => 0,
                'total_faces' => 0,
                'total_storage_size' => 0,
                'recent_enrollments' => []
            ];

            if (is_dir($facesDirectory)) {
                $directories = glob($facesDirectory . '/*', GLOB_ONLYDIR);
                $stats['total_users'] = count($directories);

                $recentEnrollments = [];

                foreach ($directories as $directory) {
                    $files = glob($directory . '/*.{jpg,jpeg,png}', GLOB_BRACE);
                    $stats['total_faces'] += count($files);

                    foreach ($files as $file) {
                        $fileSize = filesize($file);
                        $stats['total_storage_size'] += $fileSize;
                        
                        $recentEnrollments[] = [
                            'username' => basename($directory),
                            'filename' => basename($file),
                            'size' => $fileSize,
                            'enrolled_at' => filemtime($file)
                        ];
                    }
                }

                // Sort by enrollment date and get recent 10
                usort($recentEnrollments, function ($a, $b) {
                    return $b['enrolled_at'] <=> $a['enrolled_at'];
                });

                $stats['recent_enrollments'] = array_slice($recentEnrollments, 0, 10);
            }

            // Format storage size
            $stats['formatted_storage_size'] = $this->formatBytes($stats['total_storage_size']);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Face enrollment statistics error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics'
            ], 500);
        }
    }

    /**
     * Sanitize username for file system use
     */
    private function sanitizeUsername($username)
    {
        $sanitized = Str::slug(trim($username), '_');
        $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $sanitized);
        
        if (empty($sanitized)) {
            throw new \InvalidArgumentException('Username contains no valid characters');
        }
        
        return $sanitized;
    }

    /**
     * Process image files and return formatted array
     */
    private function processImageFiles($files, $username)
    {
        $imageFiles = [];
        
        foreach ($files as $file) {
            $filename = basename($file);
            $relativePath = 'faces/' . $username . '/' . $filename;
            $url = asset($relativePath);
            
            $imageFiles[] = [
                'filename' => $filename,
                'path' => $relativePath,
                'url' => $url,
                'size' => filesize($file),
                'formatted_size' => $this->formatBytes(filesize($file)),
                'last_modified' => filemtime($file),
                'enrolled_at' => Carbon::createFromTimestamp(filemtime($file))->toISOString()
            ];
        }

        // Sort by last modified (newest first)
        usort($imageFiles, function ($a, $b) {
            return $b['last_modified'] <=> $a['last_modified'];
        });

        return $imageFiles;
    }

    /**
     * Delete directory recursively
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        
        return rmdir($dir);
    }

    /**
     * Save face enrollment to database (optional)
     */
    private function saveFaceEnrollmentToDatabase($username, $path, $filename, $fileSize)
    {
        // Uncomment and modify this if you create the FaceEnrollment model
        /*
        try {
            \App\Models\FaceEnrollment::create([
                'username' => $username,
                'image_path' => $path,
                'original_filename' => $filename,
                'file_size' => $fileSize,
                'metadata' => json_encode([
                    'enrollment_ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'enrolled_at' => Carbon::now()->toISOString()
                ]),
                'enrolled_at' => Carbon::now()
            ]);
            
            Log::info('Face enrollment database record created', [
                'username' => $username,
                'path' => $path
            ]);
            
        } catch (\Exception $e) {
            Log::warning('Failed to save face enrollment to database: ' . $e->getMessage(), [
                'username' => $username,
                'path' => $path
            ]);
        }
        */
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}