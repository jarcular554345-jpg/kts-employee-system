<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@kts.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Create sample employee
        $employee = Employee::create([
            'employee_id' => 'EMP001',
            'full_name' => 'John Doe',
            'position' => 'Driver',
            'department' => 'Operations',
            'contact_number' => '09123456789',
            'address' => 'Manila, Philippines',
            'email' => 'john.doe@kts.com',
            'date_hired' => '2024-01-01',
            'salary' => 25000,
            'employment_status' => 'Active',
        ]);
        
        // Create employee user account
        User::create([
            'name' => $employee->full_name,
            'email' => $employee->email,
            'password' => Hash::make('password'),
            'role' => 'employee',
            'employee_id' => $employee->id,
        ]);
    }
}