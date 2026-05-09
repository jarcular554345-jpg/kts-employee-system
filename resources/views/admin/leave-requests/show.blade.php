@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Leave Request Details</h2>
        <div>
            <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Request Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Employee Name:</label>
                        <p>{{ $leaveRequest->employee->full_name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Employee ID:</label>
                        <p>{{ $leaveRequest->employee->employee_id ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Position:</label>
                        <p>{{ $leaveRequest->employee->position ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Department:</label>
                        <p>{{ $leaveRequest->employee->department ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Leave Type:</label>
                        <p>{{ $leaveRequest->leave_type }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Start Date:</label>
                        <p>{{ date('F d, Y', strtotime($leaveRequest->start_date)) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">End Date:</label>
                        <p>{{ date('F d, Y', strtotime($leaveRequest->end_date)) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Number of Days:</label>
                        <p>
                            @php
                                $start = \Carbon\Carbon::parse($leaveRequest->start_date);
                                $end = \Carbon\Carbon::parse($leaveRequest->end_date);
                                $days = $start->diffInDays($end) + 1;
                            @endphp
                            {{ $days }} day(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Reason & Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Reason for Leave:</label>
                        <div class="border p-2 rounded bg-light">
                            {{ $leaveRequest->reason }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Status:</label>
                        <p>
                            @if($leaveRequest->status == 'Pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($leaveRequest->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                    </div>
                    @if($leaveRequest->admin_remarks)
                    <div class="mb-3">
                        <label class="fw-bold">Admin Remarks:</label>
                        <div class="border p-2 rounded bg-light">
                            {{ $leaveRequest->admin_remarks }}
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="fw-bold">Submitted Date:</label>
                        <p>{{ $leaveRequest->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Last Updated:</label>
                        <p>{{ $leaveRequest->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            @if($leaveRequest->status == 'Pending')
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="fas fa-check"></i> Approve Request
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.leave-requests.approve', $leaveRequest) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Approve Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Approve leave request for <strong>{{ $leaveRequest->employee->full_name ?? 'N/A' }}</strong>?</p>
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
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.leave-requests.reject', $leaveRequest) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Reject Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Reject leave request for <strong>{{ $leaveRequest->employee->full_name ?? 'N/A' }}</strong>?</p>
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
@endsection