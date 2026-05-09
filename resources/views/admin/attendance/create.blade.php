@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manual Attendance Entry</h2>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Record Attendance Manually</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="employee_id">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="employee_id" class="form-control" required>
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->full_name }} - {{ $employee->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="time_in">Time In <span class="text-danger">*</span></label>
                        <input type="time" name="time_in" id="time_in" class="form-control" value="08:00:00" required>
                        <small class="text-muted">Regular time: 08:00:00 (8:00 AM)</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="time_out">Time Out</label>
                        <input type="time" name="time_out" id="time_out" class="form-control" value="17:00:00">
                        <small class="text-muted">Regular time: 17:00:00 (5:00 PM)</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Present">Present</option>
                            <option value="Late">Late</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Optional: Add reason for manual entry or any notes..."></textarea>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Note:</strong> Manual entry is for recording attendance when employees forget to time in/out or for corrections.
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Attendance
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('time_in').addEventListener('change', function() {
        var timeIn = this.value;
        var statusSelect = document.getElementById('status');
        
        if (timeIn > '08:00:00') {
            statusSelect.value = 'Late';
        } else if (timeIn <= '08:00:00' && timeIn !== '') {
            statusSelect.value = 'Present';
        }
    });
</script>
@endpush
@endsection