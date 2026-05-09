@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Attendance Details</h2>
        <div>
            <a href="{{ route('admin.attendance.edit', $attendance) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Attendance Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Employee:</label>
                    <p>{{ $attendance->employee->full_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Date:</label>
                    <p>{{ date('F d, Y', strtotime($attendance->date)) }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Time In:</label>
                    <p>{{ $attendance->time_in ?? 'Not recorded' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Time Out:</label>
                    <p>{{ $attendance->time_out ?? 'Not recorded' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Status:</label>
                    <p>
                        @if($attendance->status == 'Present')
                            <span class="badge bg-success">Present</span>
                        @elseif($attendance->status == 'Late')
                            <span class="badge bg-warning">Late</span>
                        @else
                            <span class="badge bg-danger">Absent</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Remarks:</label>
                    <p>{{ $attendance->remarks ?? 'No remarks' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection