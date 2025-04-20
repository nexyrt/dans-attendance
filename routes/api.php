<?php

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
