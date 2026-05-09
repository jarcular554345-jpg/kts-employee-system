@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Attendance Management</h2>
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Manual Entry
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Today's Late</h6>
                    <h3>{{ isset($lateEmployees) ? $lateEmployees->count() : 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Today's Absent</h6>
                    <h3>{{ isset($absentEmployees) ? $absentEmployees->count() : 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Records</h6>
                    <h3>{{ $attendances->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Attendance Records</h5>
            <form method="GET" action="{{ route('admin.attendance.index') }}" class="mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ date('Y-m-d', strtotime($attendance->date)) }}</td>
                            <td>{{ $attendance->time_in ?? '-' }}</td>
                            <td>{{ $attendance->time_out ?? '-' }}</td>
                            <td>
                                @if($attendance->status == 'Present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($attendance->status == 'Late')
                                    <span class="badge bg-warning">Late</span>
                                @else
                                    <span class="badge bg-danger">Absent</span>
                                @endif
                            </td>
                            <td>{{ $attendance->remarks ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.attendance.edit', $attendance) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.attendance.destroy', $attendance) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection