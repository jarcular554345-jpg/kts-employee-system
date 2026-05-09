@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #4a90e2;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">TOTAL EMPLOYEES</div>
                    <div class="stat-value">{{ $totalEmployees }}</div>
                    <small class="text-muted">Active: {{ $activeEmployees }}</small>
                </div>
                <div class="stat-icon text-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #28a745;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">ACTIVE EMPLOYEES</div>
                    <div class="stat-value">{{ $activeEmployees }}</div>
                    <small class="text-muted">Employment Status</small>
                </div>
                <div class="stat-icon text-success">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #17a2b8;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">TODAY'S ATTENDANCE</div>
                    <div class="stat-value">{{ $todayAttendance }}</div>
                    <small class="text-muted">Out of {{ $activeEmployees }} active</small>
                </div>
                <div class="stat-icon text-info">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #ffc107;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">PENDING LEAVES</div>
                    <div class="stat-value">{{ $pendingLeaves }}</div>
                    <small class="text-muted">Awaiting Approval</small>
                </div>
                <div class="stat-icon text-warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card-professional">
            <div class="card-header-professional">
                <i class="fas fa-chart-line me-2 text-primary"></i> Attendance Analytics
            </div>
            <div class="card-body-professional">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small text-muted">Attendance Rate</label>
                            <div class="d-flex align-items-baseline">
                                <h2 class="fw-bold mb-0">
                                    {{ $activeEmployees > 0 ? round(($todayAttendance / $activeEmployees) * 100, 1) : 0 }}%
                                </h2>
                                <span class="text-muted ms-2">of workforce present</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small text-muted">Monthly Payroll</label>
                            <div class="d-flex align-items-baseline">
                                <h2 class="fw-bold mb-0">₱{{ number_format($monthlyPayroll, 2) }}</h2>
                                <span class="text-muted ms-2">total</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: {{ $activeEmployees > 0 ? round(($todayAttendance / $activeEmployees) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card-professional">
            <div class="card-header-professional">
                <i class="fas fa-users me-2 text-primary"></i> Employee Status
            </div>
            <div class="card-body-professional">
                <div class="d-flex justify-content-between mb-2">
                    <span>Active Employees</span>
                    <span class="fw-bold">{{ $activeEmployees }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Inactive Employees</span>
                    <span class="fw-bold">{{ $inactiveEmployees }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total Workforce</span>
                    <span class="fw-bold">{{ $totalEmployees }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-professional mt-4">
    <div class="card-header-professional">
        <i class="fas fa-envelope-open-text me-2 text-primary"></i> Recent Leave Requests
        <span class="badge-professional badge-pending ms-2">{{ $pendingLeaves }} Pending</span>
    </div>
    <div class="card-body-professional p-0">
        <table class="table-professional">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Request Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentActivities as $activity)
                <tr>
                    <td>{{ $activity->employee->full_name ?? 'N/A' }}</td>
                    <td>{{ $activity->leave_type }}</td>
                    <td>{{ $activity->created_at->format('M d, Y') }}</td>
                    <td>
                        <span class="badge-professional 
                            @if($activity->status == 'Pending') badge-pending
                            @elseif($activity->status == 'Approved') badge-approved
                            @else badge-rejected @endif">
                            {{ $activity->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">No leave requests found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection