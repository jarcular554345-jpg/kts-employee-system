@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Leave Report</h2>
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
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">KTS Car Rental - Leave Requests Report</h4>
            <small>Status Filter: {{ request('status') ?: 'All' }} | Generated: {{ date('F d, Y h:i A') }}</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                         </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $index => $leave)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $leave->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ $leave->leave_type }}</td>
                            <td>{{ date('M d, Y', strtotime($leave->start_date)) }}</td>
                            <td>{{ date('M d, Y', strtotime($leave->end_date)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} days</td>
                            <td>{{ Str::limit($leave->reason, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $leave->status == 'Pending' ? 'warning' : ($leave->status == 'Approved' ? 'success' : 'danger') }}">
                                    {{ $leave->status }}
                                </span>
                             </td>
                         </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .sidebar, .navbar {
            display: none !important;
        }
    }
</style>
@endsection