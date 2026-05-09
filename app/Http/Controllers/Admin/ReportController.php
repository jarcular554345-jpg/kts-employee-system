<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function employees()
    {
        $employees = Employee::all();
        return view('admin.reports.employees', compact('employees'));
    }

    public function attendance(Request $request)
    {
        $query = Attendance::with('employee');
        
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        
        $attendances = $query->orderBy('date', 'desc')->get();
        return view('admin.reports.attendance', compact('attendances'));
    }

    public function leaves(Request $request)
    {
        $query = LeaveRequest::with('employee');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $leaveRequests = $query->orderBy('created_at', 'desc')->get();
        return view('admin.reports.leaves', compact('leaveRequests'));
    }

    public function payrolls(Request $request)
    {
        $query = Payroll::with('employee');
        
        if ($request->month && $request->year) {
            $query->where('payroll_month', $request->month)
                  ->where('year', $request->year);
        }
        
        $payrolls = $query->get();
        return view('admin.reports.payrolls', compact('payrolls'));
    }
}