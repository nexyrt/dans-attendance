<?php

use Illuminate\Support\Facades\Route;

// Controller Imports
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Office\OfficeLocation;
use App\Http\Controllers\Admin\{
    DashboardController,
    UsersController,
    ScheduleController,
    Leave\LeaveDashboard
};
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;

// Livewire Component Imports
use App\Livewire\Admin\Leave\{
    LeaveBalance,
    LeaveRequestsTable
};
use App\Livewire\Admin\Attendances\AttendanceRecord;

use App\Livewire\Staff\{
    Dashboard as StaffDashboard,
    Attendance as StaffAttendance,
    Leave\LeaveManagement as StaffLeave,
    Payroll as StaffPayroll,
    Profile as StaffProfile,
};

use App\Livewire\Manager\{
    Dashboard as ManagerDashboard,
    Leave as ManagerLeave,
};

use App\Livewire\Director\Schedules\SchedulesCalendar as DirectorSchedulesCalendar;
use App\Livewire\Director\Schedules\DefaultSchedules as DirectorDefaultSchedule;
use App\Livewire\Director\{
    Dashboard as DirectorDashboard,
    Users as DirectorUsers,
    Leave as DirectorLeaves,
    Attendances as DirectorAttendances,
    Offices as DirectorOffices,
};

use App\Livewire\Hr\{
    Leave as HrLeave,
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Users Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [DashboardController::class, 'users'])->name('index');
            Route::post('/store', [UsersController::class, 'store'])->name('store');
            Route::put('/{user}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
            Route::get('/{user}', [UsersController::class, 'detail'])->name('detail');
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
            Route::get('/hr-leave', HrLeave::class)->name('hr-leave');
        });

        // Office
        Route::prefix('office')->name('office.')->group(function () {
            Route::get('/', [OfficeLocation::class, 'index'])->name('index');
        });
    });

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', StaffDashboard::class)->name('dashboard');
        Route::get('/attendance', action: StaffAttendance::class)->name('attendance.index');
        Route::get('/leave', StaffLeave::class)->name('leave.index');
        Route::get('/payroll', StaffPayroll::class)->name('payroll.index');
        Route::get('/profile', StaffProfile::class)->name('profile.index');
    });

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', ManagerDashboard::class)->name('dashboard');
        Route::get('/leave', ManagerLeave::class)->name('leave.index');
    });

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:director'])
    ->prefix('director')
    ->name('director.')
    ->group(function () {
        Route::get('/dashboard', DirectorDashboard::class)->name('dashboard');
        Route::get('/users', DirectorUsers::class)->name('users.index');
        Route::get('/leave', DirectorLeaves::class)->name('leaves.index');
        Route::get('/attendances', DirectorAttendances::class)->name('attendances.index');
        Route::get('/office', DirectorOffices::class)->name('office.index');
        Route::get('/default-schedules', DirectorDefaultSchedule::class)->name('schedules.default');
        Route::get('/schedules-calendar', DirectorSchedulesCalendar::class)->name('schedules.calendar');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';