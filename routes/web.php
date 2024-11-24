<?php

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Livewire\Admin\Schedules\ScheduleTable;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kanban', App\Livewire\KanbanBoard::class)->name('kanban');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [DashboardController::class, 'users'])->name('index');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::put('/{user}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
        Route::get('/export', function (Request $request) {
            $department = $request->input('department');
            $position = $request->input('position');
            $name = $request->input('name');
            return Excel::download(new UsersExport($department, $position, $name), 'users.xlsx');
        })->name('export');
    });

    //Schedules
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/dashboard', [ScheduleController::class, 'index'])->name('dashboard');
        Route::get('/default-schedules', [ScheduleController::class, 'shift'])->name('default-schedules');
    });

    // Future Routes
    // Route::prefix('clients')->name('clients.')->group(function () {});
    // Route::prefix('settings')->name('settings.')->group(function () {});
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::prefix('attendance')->name('attendance.')->group(function () {
        // History/Record
        Route::get('/', [App\Http\Controllers\Staff\AttendanceController::class, 'index'])->name('index');
    //     Route::get('/history', [Staff\AttendanceController::class, 'history'])->name('history');
    //     Route::get('/detail/{attendance}', [Staff\AttendanceController::class, 'show'])->name('show');
    });

    // // Leave Management
    // Route::prefix('leave')->name('leave.')->group(function () {
    //     Route::get('/', [Staff\LeaveController::class, 'index'])->name('index');
    //     Route::get('/create', [Staff\LeaveController::class, 'create'])->name('create');
    //     Route::post('/store', [Staff\LeaveController::class, 'store'])->name('store');
    //     Route::get('/{leave}', [Staff\LeaveController::class, 'show'])->name('show');
    //     Route::delete('/{leave}', [Staff\LeaveController::class, 'destroy'])->name('destroy');
        
    //     // Leave Balance
    //     Route::get('/balance', [Staff\LeaveController::class, 'balance'])->name('balance');
    // });

    // // Schedule
    // Route::prefix('schedule')->name('schedule.')->group(function () {
    //     Route::get('/', [Staff\ScheduleController::class, 'index'])->name('index');
    //     Route::get('/calendar', [Staff\ScheduleController::class, 'calendar'])->name('calendar');
    //     Route::get('/exceptions', [Staff\ScheduleController::class, 'exceptions'])->name('exceptions');
    // });

    // // Profile Management
    // Route::prefix('profile')->name('profile.')->group(function () {
    //     Route::get('/', [Staff\ProfileController::class, 'edit'])->name('edit');
    //     Route::patch('/', [Staff\ProfileController::class, 'update'])->name('update');
    //     Route::patch('/password', [Staff\ProfileController::class, 'updatePassword'])->name('password.update');
    //     Route::patch('/photo', [Staff\ProfileController::class, 'updatePhoto'])->name('photo.update');
    // });
});

Route::middleware('auth')->group(function () {
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';
