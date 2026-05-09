<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employees', EmployeeController::class);
    
    // Add password reset route
    Route::post('/employees/{employee}/reset-password', [EmployeeController::class, 'resetPassword'])->name('employees.reset-password');
    
    Route::resource('attendance', AttendanceController::class);
    
    Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::put('/leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::put('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
    Route::get('/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave-requests.show');
    
    Route::resource('payrolls', PayrollController::class);
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/leaves', [ReportController::class, 'leaves'])->name('reports.leaves');
    Route::get('/reports/payrolls', [ReportController::class, 'payrolls'])->name('reports.payrolls');
});

// Employee Routes - WITH TIME IN/OUT
Route::middleware(['auth', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::post('/leave/store', [EmployeeDashboardController::class, 'storeLeaveRequest'])->name('leave.store');
    
    // Add these time in/out routes
    Route::post('/timein', [EmployeeDashboardController::class, 'timeIn'])->name('timein');
    Route::post('/timeout', [EmployeeDashboardController::class, 'timeOut'])->name('timeout');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employee Profile Routes
Route::middleware(['auth', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::post('/leave/store', [EmployeeDashboardController::class, 'storeLeaveRequest'])->name('leave.store');
    Route::post('/timein', [EmployeeDashboardController::class, 'timeIn'])->name('timein');
    Route::post('/timeout', [EmployeeDashboardController::class, 'timeOut'])->name('timeout');
    
    // Profile Routes - Add these
    Route::get('/profile/edit', [App\Http\Controllers\Employee\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Employee\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Employee\ProfileController::class, 'updatePassword'])->name('password.update');
});