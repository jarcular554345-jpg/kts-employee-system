@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Leave Requests Management</h2>
    
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Pending Requests</h6>
                    <h3>{{ $pendingRequests }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Approved</h6>
                    <h3>{{ $leaveRequests->where('status', 'Approved')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Rejected</h6>
                    <h3>{{ $leaveRequests->where('status', 'Rejected')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total</h6>
                    <h3>{{ $leaveRequests->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="card">
        <div class="card-header">
            <h5>All Leave Requests</h5>
        </div>
        <div class="card-body">
            @if($leaveRequests->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                    <strong>No leave requests found!</strong>
                    <p>Employees can submit leave requests from their employee dashboard.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaveRequests as $leave)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leave->employee->full_name ?? 'N/A' }}</td>
                                <td>{{ $leave->leave_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $days = \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
                                    @endphp
                                    {{ $days }} day(s)
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($leave->reason, 50) }}</td>
                                <td>
                                    @if($leave->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($leave->status == 'Approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $leave->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.leave-requests.show', $leave) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($leave->status == 'Pending')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $leave->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $leave->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.leave-requests.approve', $leave) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Approve Leave Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Approve leave request for <strong>{{ $leave->employee->full_name ?? 'N/A' }}</strong>?</p>
                                                <label>Remarks (Optional):</label>
                                                <textarea name="remarks" class="form-control" rows="2" placeholder="Add any remarks..."></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.leave-requests.reject', $leave) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject Leave Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Reject leave request for <strong>{{ $leave->employee->full_name ?? 'N/A' }}</strong>?</p>
                                                <label>Reason for Rejection <span class="text-danger">*</span>:</label>
                                                <textarea name="remarks" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection