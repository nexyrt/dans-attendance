<?php

use App\Exports\FilteredDataExport;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Employee routes
Route::prefix('employee')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('employee.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
    Route::get('/activity-logs/{id}/edit', [AttendanceController::class, 'edit'])->name('activity-logs.edit');
    Route::put('/activity-logs/{id}/put', [AttendanceController::class, 'update'])->name('activity-logs.update');
    Route::get('/fetch-data', [DashboardController::class, 'fetchData']);
    Route::post('/export-table-data', [DashboardController::class, 'exportTableData'])->name('export-table');

    //employee management route
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee-management');

    //some trial route
    Route::post('/send-data', [AttendanceController::class, 'receiveData'])->name('receive-data');
});

require __DIR__ . '/auth.php';
