@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Report</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">KTS Car Rental - Employee List Report</h4>
            <small>Generated on: {{ date('F d, Y h:i A') }}</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Date Hired</th>
                            <th>Salary</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->department }}</td>
                            <td>{{ $employee->contact_number }}</td>
                            <td>{{ date('M d, Y', strtotime($employee->date_hired)) }}</td>
                            <td>₱{{ number_format($employee->salary, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $employee->employment_status == 'Active' ? 'success' : 'danger' }}">
                                    {{ $employee->employment_status }}
                                </span>
                             </td>
                         </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <strong>Total Employees:</strong> {{ $employees->count() }} |
                <strong>Active:</strong> {{ $employees->where('employment_status', 'Active')->count() }} |
                <strong>Inactive:</strong> {{ $employees->where('employment_status', 'Inactive')->count() }}
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .sidebar, .navbar {
            display: none !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
        .card {
            border: none !important;
        }
    }
</style>
@endsection