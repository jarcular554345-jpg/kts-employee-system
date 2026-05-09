<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:employees',
            'full_name' => 'required',
            'position' => 'required',
            'department' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:employees',
            'date_hired' => 'required|date',
            'salary' => 'required|numeric',
            'employment_status' => 'required',
        ]);

        $employee = Employee::create($request->all());

        // Create login account for employee
        $defaultPassword = 'password123';
        User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($defaultPassword),
            'role' => 'employee',
            'employee_id' => $employee->id
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully!<br>
                    <strong>Login Credentials:</strong><br>
                    Email: ' . $request->email . '<br>
                    Password: ' . $defaultPassword . '<br>
                    <small class="text-muted">Please provide these credentials to the employee.</small>');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_id' => 'required|unique:employees,employee_id,' . $employee->id,
            'full_name' => 'required',
            'position' => 'required',
            'department' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'date_hired' => 'required|date',
            'salary' => 'required|numeric',
            'employment_status' => 'required',
        ]);

        $employee->update($request->all());

        // Update user email if changed
        if ($employee->user) {
            $employee->user->update(['email' => $request->email]);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully');
    }
    
    // Add this new method to reset password
    public function resetPassword(Employee $employee)
    {
        if ($employee->user) {
            $defaultPassword = 'password123';
            $employee->user->update([
                'password' => Hash::make($defaultPassword)
            ]);
            
            return redirect()->route('admin.employees.show', $employee)
                ->with('success', 'Password reset successfully!<br>
                        New password: <strong>' . $defaultPassword . '</strong>');
        }
        
        return redirect()->route('admin.employees.show', $employee)
            ->with('error', 'No user account found for this employee.');
    }
}