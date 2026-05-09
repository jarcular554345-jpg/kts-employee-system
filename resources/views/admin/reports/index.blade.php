@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Report Generation</h2>
    
    <div class="row">
        <!-- Employee Report Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Employee Report</h5>
                </div>
                <div class="card-body">
                    <p>Generate complete list of all employees with their details including position, department, and status.</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.reports.employees') }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generate Report
                        </a>
                        <button onclick="window.open('{{ route('admin.reports.employees') }}', '_blank').print()" class="btn btn-success">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Attendance Report Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Attendance Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.attendance') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Leave Report Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-envelope-open-text"></i> Leave Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.leaves') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <label>Filter by Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Payroll Report Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Payroll Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.payrolls') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <label>Month</label>
                                <select name="month" class="form-control">
                                    <option value="">All Months</option>
                                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label>Year</label>
                                <select name="year" class="form-control">
                                    <option value="">All Years</option>
                                    @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Report Preview Section -->
    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Quick Statistics</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <h3>{{ \App\Models\Employee::count() }}</h3>
                    <p>Total Employees</p>
                </div>
                <div class="col-md-3 text-center">
                    <h3>{{ \App\Models\LeaveRequest::where('status', 'Pending')->count() }}</h3>
                    <p>Pending Leaves</p>
                </div>
                <div class="col-md-3 text-center">
                    <h3>{{ \App\Models\Attendance::whereDate('date', today())->count() }}</h3>
                    <p>Present Today</p>
                </div>
                <div class="col-md-3 text-center">
                    <h3>₱{{ number_format(\App\Models\Payroll::where('payroll_month', date('F'))->where('year', date('Y'))->sum('total_salary'), 2) }}</h3>
                    <p>Monthly Payroll</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection