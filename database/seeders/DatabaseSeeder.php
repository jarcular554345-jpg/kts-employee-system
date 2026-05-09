<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('leave_requests')->truncate();
        DB::table('users')->where('role', 'employee')->delete();
        DB::table('employees')->truncate();
        
        // Create Employee FIRST
        $employee = Employee::create([
            'employee_id' => 'EMP001',
            'full_name' => 'John Doe',
            'position' => 'Driver',
            'department' => 'Operations',
            'contact_number' => '09123456789',
            'address' => '123 Main St, Manila, Philippines',
            'email' => 'john.doe@kts.com',
            'date_hired' => '2024-01-01',
            'salary' => 25000.00,
            'employment_status' => 'Active',
        ]);
        
        echo "Employee created with ID: " . $employee->id . "\n";
        
        // Create Employee User Account with CORRECT linking
        $user = User::create([
            'name' => $employee->full_name,
            'email' => $employee->email,
            'password' => Hash::make('password'),
            'role' => 'employee',
            'employee_id' => $employee->id, // THIS IS CRITICAL
        ]);
        
        echo "User created with ID: " . $user->id . " linked to employee ID: " . $user->employee_id . "\n";
        
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@kts.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'employee_id' => null,
        ]);
        
        // Create Sample Leave Requests
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => 'Vacation Leave',
            'start_date' => '2024-02-01',
            'end_date' => '2024-02-03',
            'reason' => 'Family vacation to Boracay',
            'status' => 'Pending',
        ]);
        
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => 'Sick Leave',
            'start_date' => '2024-02-15',
            'end_date' => '2024-02-16',
            'reason' => 'Flu and fever, need to rest',
            'status' => 'Pending',
        ]);
        
        echo "Created 2 sample leave requests\n";
    }
}