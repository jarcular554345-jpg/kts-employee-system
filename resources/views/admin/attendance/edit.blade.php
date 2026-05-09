@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Attendance Record</h2>
    
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Modify Attendance Entry</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.update', $attendance) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Employee</label>
                        <input type="text" class="form-control" value="{{ $attendance->employee->full_name ?? 'N/A' }}" disabled>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Date</label>
                        <input type="text" class="form-control" value="{{ date('Y-m-d', strtotime($attendance->date)) }}" disabled>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="time_in">Time In</label>
                        <input type="time" name="time_in" id="time_in" class="form-control" value="{{ $attendance->time_in }}">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="time_out">Time Out</label>
                        <input type="time" name="time_out" id="time_out" class="form-control" value="{{ $attendance->time_out }}">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                            <option value="Late" {{ $attendance->status == 'Late' ? 'selected' : '' }}>Late</option>
                            <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ $attendance->remarks }}</textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Attendance
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection