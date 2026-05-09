<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->orderBy('year', 'desc')
            ->orderBy('payroll_month', 'desc')
            ->paginate(10);
        
        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::where('employment_status', 'Active')->get();
        return view('admin.payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'payroll_month' => 'required',
            'year' => 'required',
            'overtime_hours' => 'required|numeric',
            'deductions' => 'required|numeric',
        ]);

        $employee = Employee::find($request->employee_id);
        $overtimeRate = ($employee->salary / 30 / 8) * 1.25; // 1.25x overtime rate
        $overtimePay = $request->overtime_hours * $overtimeRate;
        
        $totalSalary = $employee->salary + $overtimePay - $request->deductions;

        Payroll::create([
            'employee_id' => $request->employee_id,
            'payroll_month' => $request->payroll_month,
            'year' => $request->year,
            'basic_salary' => $employee->salary,
            'overtime_hours' => $request->overtime_hours,
            'overtime_pay' => $overtimePay,
            'deductions' => $request->deductions,
            'total_salary' => $totalSalary,
        ]);

        return redirect()->route('admin.payrolls.index')
            ->with('success', 'Payroll calculated and saved successfully');
    }

    public function show(Payroll $payroll)
    {
        return view('admin.payrolls.show', compact('payroll'));
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('admin.payrolls.index')
            ->with('success', 'Payroll record deleted');
    }
}