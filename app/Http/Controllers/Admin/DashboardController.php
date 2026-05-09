<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('employment_status', 'Active')->count();
        $inactiveEmployees = Employee::where('employment_status', 'Inactive')->count();
        
        $todayAttendance = Attendance::whereDate('date', today())->count();
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->count();
        
        $monthlyPayroll = Payroll::where('payroll_month', date('F'))
            ->where('year', date('Y'))
            ->sum('total_salary');
        
        $recentActivities = LeaveRequest::with('employee')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalEmployees', 'activeEmployees', 'inactiveEmployees',
            'todayAttendance', 'pendingLeaves', 'monthlyPayroll', 'recentActivities'
        ));
    }
}