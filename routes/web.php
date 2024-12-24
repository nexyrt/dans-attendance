<?php

// Framework & Package Imports
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\{
    DashboardController,
    UsersController,
    ScheduleController,
    Leave\LeaveDashboard
};
use App\Http\Controllers\Staff\{
    DashboardController as StaffDashboardController,
    AttendanceController
};

// Livewire Components
use App\Livewire\KanbanBoard;
use App\Livewire\Admin\Users\UserDetail;
use App\Livewire\Admin\Leave\{
    LeaveBalance,
    LeaveRequestsTable
};
use App\Livewire\Admin\Attendances\AttendanceRecord;
use App\Livewire\Admin\Schedules\ScheduleTable;

// Models & Exports
use App\Models\{
    Attendance,
    LeaveRequest
};
use App\Exports\UsersExport;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kanban', KanbanBoard::class)->name('kanban');

// Admin Routes
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Users Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [DashboardController::class, 'users'])->name('index');
            Route::post('/store', [UsersController::class, 'store'])->name('store');
            Route::put('/{user}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
            Route::get('/export', function (Request $request) {
                return Excel::download(
                    new UsersExport(
                        $request->input('department'),
                        $request->input('position'),
                        $request->input('name')
                    ),
                    'users.xlsx'
                );
            })->name('export');
            Route::get('/{user}', UserDetail::class)->name('detail');
        });

        // Schedules
        Route::prefix('schedules')->name('schedules.')->group(function () {
            Route::get('/dashboard', [ScheduleController::class, 'index'])->name('dashboard');
            Route::get('/default-schedules', [ScheduleController::class, 'shift'])->name('default-schedules');
        });

        // Attendances
        Route::prefix('attendances')->name('attendances.')->group(function () {
            Route::get('/', AttendanceRecord::class)->name('index');
        });

        // Leave Management
        Route::prefix('leave')->name('leave.')->group(function () {
            Route::get('/', [LeaveDashboard::class, 'index'])->name('dashboard');
            Route::get('/leave-request', LeaveRequestsTable::class)->name('leave-request');
            Route::get('/leave-balance', LeaveBalance::class)->name('leave-balance');
        });
    });

// Staff Routes
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // Attendance
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
        });

        // Leave Management - Commented routes preserved for future implementation
        Route::prefix('leave')->name('leave.')->group(function () {
            // Future implementation
        });
    });

// Manager Routes
Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    });

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';
