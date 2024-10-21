<?php

use App\Exports\FilteredDataExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // admin/dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // admin/users
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::post('users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/export', function (Request $request) {
        $department = $request->input('department');
        $position = $request->input('position');
        $name = $request->input('name');

        return Excel::download(new UsersExport($department, $position, $name), 'users.xlsx');
    })->name('admin.users.export');

    // admin/clients
    // admin/settings
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
