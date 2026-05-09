@extends('layouts.employee')

@section('content')
<style>
    .stat-card-employee {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border-left: 4px solid;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .stat-card-employee:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stat-label-employee {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
    }
    
    .stat-value-employee {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .btn-attendance {
        padding: 15px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .btn-attendance:hover {
        transform: translateY(-2px);
    }
    
    .profile-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #1a1e2b 0%, #2d3748 100%);
        padding: 25px;
        text-align: center;
        color: white;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 2rem;
    }
    
    .profile-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .profile-position {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    .info-row {
        padding: 12px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
    }
    
    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-size: 0.85rem;
        font-weight: 500;
        color: #1e293b;
    }
    
    .section-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        margin-bottom: 25px;
    }
    
    .section-header {
        background: #f8fafc;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .section-body {
        padding: 20px;
    }
    
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-present { background: #10b98120; color: #10b981; }
    .badge-late { background: #f59e0b20; color: #f59e0b; }
    .badge-absent { background: #ef444420; color: #ef4444; }
    
    .status-card {
        text-align: center;
        padding: 20px;
    }
    
    .status-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    
    .status-present { color: #10b981; }
    .status-late { color: #f59e0b; }
    .status-absent { color: #ef4444; }
    
    .table-employee {
        width: 100%;
    }
    
    .table-employee thead th {
        background: #f8fafc;
        padding: 12px 16px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 2px solid #e9ecef;
    }
    
    .table-employee tbody td {
        padding: 12px 16px;
        font-size: 0.85rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-control-employee {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.85rem;
        width: 100%;
        transition: all 0.2s;
    }
    
    .form-control-employee:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        outline: none;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        width: 100%;
        transition: all 0.3s;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.3);
    }
</style>

<div class="row g-4">
    <!-- Stats Cards - Removed Attendance Rate -->
    <div class="col-md-4">
        <div class="stat-card-employee" style="border-left-color: #667eea;">
            <div class="stat-label-employee">TOTAL LEAVES</div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="stat-value-employee">{{ $leaveRequests->count() }}</div>
                <i class="fas fa-calendar-alt fa-2x text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card-employee" style="border-left-color: #f59e0b;">
            <div class="stat-label-employee">PENDING REQUESTS</div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="stat-value-employee">{{ $leaveRequests->where('status', 'Pending')->count() }}</div>
                <i class="fas fa-clock fa-2x text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card-employee" style="border-left-color: #10b981;">
            <div class="stat-label-employee">APPROVED LEAVES</div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="stat-value-employee">{{ $leaveRequests->where('status', 'Approved')->count() }}</div>
                <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Attendance Section -->
    <div class="col-md-6">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-fingerprint me-2 text-primary"></i> Time Attendance
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-6">
                        <form action="{{ route('employee.timein') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-attendance w-100">
                                <i class="fas fa-sign-in-alt fa-lg d-block mb-2"></i>
                                TIME IN
                                <small class="d-block mt-1 opacity-75">Start Workday</small>
                            </button>
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="{{ route('employee.timeout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-attendance w-100">
                                <i class="fas fa-sign-out-alt fa-lg d-block mb-2"></i>
                                TIME OUT
                                <small class="d-block mt-1 opacity-75">End Workday</small>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-3 pt-2 text-center">
                    <small class="text-muted">
                        <i class="far fa-clock me-1"></i> Regular Schedule: 8:00 AM - 5:00 PM
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profile Card -->
    <div class="col-md-6">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle fa-3x"></i>
                </div>
                <h5 class="profile-name">{{ $employee->full_name }}</h5>
                <p class="profile-position">{{ $employee->position }}</p>
            </div>
            <div class="info-row">
                <span class="info-label">Employee ID</span>
                <span class="info-value">{{ $employee->employee_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Department</span>
                <span class="info-value">{{ $employee->department }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email Address</span>
                <span class="info-value">{{ $employee->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Contact Number</span>
                <span class="info-value">{{ $employee->contact_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date Hired</span>
                <span class="info-value">{{ date('F d, Y', strtotime($employee->date_hired)) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Leave Request Form -->
    <div class="col-md-6">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-paper-plane me-2 text-primary"></i> Request Leave
            </div>
            <div class="section-body">
                <form action="{{ route('employee.leave.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">LEAVE TYPE</label>
                        <select name="leave_type" class="form-control-employee" required>
                            <option value="">Select leave type</option>
                            <option value="Vacation Leave">🏖️ Vacation Leave</option>
                            <option value="Sick Leave">🤒 Sick Leave</option>
                            <option value="Emergency Leave">🚨 Emergency Leave</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">START DATE</label>
                            <input type="date" name="start_date" class="form-control-employee" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">END DATE</label>
                            <input type="date" name="end_date" class="form-control-employee" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">REASON</label>
                        <textarea name="reason" class="form-control-employee" rows="3" placeholder="Please provide detailed reason..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-paper-plane me-2"></i> Submit Leave Request
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Today's Status -->
    <div class="col-md-6">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-calendar-day me-2 text-primary"></i> Today's Status
            </div>
            <div class="section-body">
                @php
                    $todayAttendance = $attendances->first();
                    $today = date('Y-m-d');
                @endphp
                @if($todayAttendance && $todayAttendance->date == $today)
                    <div class="status-card">
                        @if($todayAttendance->status == 'Present')
                            <div class="status-icon status-present">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                            <h5 class="text-success mb-2">Present Today</h5>
                        @elseif($todayAttendance->status == 'Late')
                            <div class="status-icon status-late">
                                <i class="fas fa-clock fa-3x"></i>
                            </div>
                            <h5 class="text-warning mb-2">Arrived Late</h5>
                        @endif
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Time In</small>
                                    <strong>{{ $todayAttendance->time_in ? date('h:i A', strtotime($todayAttendance->time_in)) : '--' }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Time Out</small>
                                    <strong>{{ $todayAttendance->time_out ? date('h:i A', strtotime($todayAttendance->time_out)) : 'Not yet' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="status-card">
                        <div class="status-icon status-absent">
                            <i class="fas fa-info-circle fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">No Attendance Recorded</h5>
                        <p class="small text-muted mb-0">Please click TIME IN to start your workday</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Leave History Table -->
<div class="section-card mt-4">
    <div class="section-header">
        <i class="fas fa-history me-2 text-primary"></i> Leave History
    </div>
    <div class="section-body p-0">
        <div class="table-responsive">
            <table class="table-employee">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Date Range</th>
                        <th>Duration</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $leave)
                    <tr>
                        <td>
                            @if($leave->leave_type == 'Vacation Leave') 🏖️
                            @elseif($leave->leave_type == 'Sick Leave') 🤒
                            @else 🚨
                            @endif
                            {{ $leave->leave_type }}
                        </td>
                        <td>{{ date('M d, Y', strtotime($leave->start_date)) }} - {{ date('M d, Y', strtotime($leave->end_date)) }}</td>
                        <td>
                            @php
                                $start = \Carbon\Carbon::parse($leave->start_date);
                                $end = \Carbon\Carbon::parse($leave->end_date);
                                $days = $start->diffInDays($end) + 1;
                            @endphp
                            <span class="badge bg-secondary">{{ $days }} day(s)</span>
                        </td>
                        <td>{{ Str::limit($leave->reason, 40) }}</td>
                        <td>
                            @if($leave->status == 'Pending')
                                <span class="badge-status badge-pending">⏳ Pending</span>
                            @elseif($leave->status == 'Approved')
                                <span class="badge-status badge-present">✅ Approved</span>
                            @else
                                <span class="badge-status badge-absent">❌ Rejected</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $leave->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No leave requests found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Attendance History -->
<div class="section-card mt-4">
    <div class="section-header">
        <i class="fas fa-calendar-alt me-2 text-primary"></i> Recent Attendance History
    </div>
    <div class="section-body p-0">
        <div class="table-responsive">
            <table class="table-employee">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                        <th>Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ date('M d, Y', strtotime($attendance->date)) }}</td>
                        <td>{{ date('l', strtotime($attendance->date)) }}</td>
                        <td>{{ $attendance->time_in ? date('h:i A', strtotime($attendance->time_in)) : '--:--' }}</td>
                        <td>{{ $attendance->time_out ? date('h:i A', strtotime($attendance->time_out)) : '--:--' }}</td>
                        <td>
                            @if($attendance->status == 'Present')
                                <span class="badge-status badge-present">✓ Present</span>
                            @elseif($attendance->status == 'Late')
                                <span class="badge-status badge-late">⚠ Late</span>
                            @else
                                <span class="badge-status badge-absent">✗ Absent</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->time_in && $attendance->time_out)
                                @php
                                    $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                                    $timeOut = \Carbon\Carbon::parse($attendance->time_out);
                                    $hours = $timeOut->diffInHours($timeIn);
                                @endphp
                                {{ $hours }} hrs
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No attendance records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </tr>
        </div>
    </div>
</div>
@endsection