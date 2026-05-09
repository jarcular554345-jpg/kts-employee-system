@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Attendance Report</h2>
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
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">KTS Car Rental - Attendance Report</h4>
            <small>Period: {{ request('start_date') }} to {{ request('end_date') }} | Generated: {{ date('F d, Y h:i A') }}</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $index => $attendance)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $attendance->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ date('M d, Y', strtotime($attendance->date)) }}</td>
                            <td>{{ $attendance->time_in ?? '--:--' }}</td>
                            <td>{{ $attendance->time_out ?? '--:--' }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->status == 'Present' ? 'success' : ($attendance->status == 'Late' ? 'warning' : 'danger') }}">
                                    {{ $attendance->status }}
                                </span>
                             </td>
                            <td>{{ $attendance->remarks ?? '-' }}</td>
                         </tr>
                        @endforeach
                    </tbody>
                 </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <strong>Summary:</strong> 
                Total Records: {{ $attendances->count() }} | 
                Present: {{ $attendances->where('status', 'Present')->count() }} | 
                Late: {{ $attendances->where('status', 'Late')->count() }} | 
                Absent: {{ $attendances->where('status', 'Absent')->count() }}
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