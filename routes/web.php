<?php

use App\Exports\FilteredDataExport;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
    Route::get('/activity-logs/{id}/edit', [AttendanceController::class, 'edit'])->name('activity-logs.edit');
    Route::patch('/activity-logs/{id}/patch', [AttendanceController::class, 'patch'])->name('activity-logs.patch');
    Route::get('/fetch-data', [DashboardController::class, 'fetchData']);
    Route::post('/export-table-data', [DashboardController::class, 'exportTableData'])->name('export-table');

});

require __DIR__ . '/auth.php';
