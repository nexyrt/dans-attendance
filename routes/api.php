<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ManagerLeaveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Manager Leave API Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager/leave')->group(function () {
    Route::post('/approve', [ManagerLeaveController::class, 'approve']);
    Route::post('/reject', [ManagerLeaveController::class, 'reject']);
});

// Universal attendance endpoint (new) - supports both GET and POST
Route::match(['get', 'post'], '/attendance/universal', [AttendanceController::class, 'universalAttendance'])->name('attendance.api.universal');

// Get attendance status
Route::get('/attendance/status', [AttendanceController::class, 'getAttendanceStatus'])->name('attendance.api.status');

// Optional: QR code file saving endpoint (if you want server-side QR storage)
Route::post('/qr-codes/save', function(\Illuminate\Http\Request $request) {
    // Handle QR code file saving if needed
    return response()->json(['success' => true, 'message' => 'QR code saved']);
})->name('qr.save');