@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Details</h2>
        <div>
            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Employee
            </a>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h4>{{ $employee->full_name }}</h4>
                    <p class="text-muted">{{ $employee->position }}</p>
                    <hr>
                    <div class="text-start">
                        <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
                        <p><strong>Department:</strong> {{ $employee->department }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $employee->employment_status == 'Active' ? 'success' : 'danger' }}">
                                {{ $employee->employment_status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Complete Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Full Name:</label>
                            <p class="border-bottom pb-1">{{ $employee->full_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Email Address:</label>
                            <p class="border-bottom pb-1">{{ $employee->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Contact Number:</label>
                            <p class="border-bottom pb-1">{{ $employee->contact_number }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Date Hired:</label>
                            <p class="border-bottom pb-1">{{ date('F d, Y', strtotime($employee->date_hired)) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Salary:</label>
                            <p class="border-bottom pb-1">₱{{ number_format($employee->salary, 2) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted">Position:</label>
                            <p class="border-bottom pb-1">{{ $employee->position }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="fw-bold text-muted">Address:</label>
                            <p class="border-bottom pb-1">{{ $employee->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACCOUNT INFORMATION WITH PASSWORD -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-key"></i> Login Account Information</h5>
                </div>
                <div class="card-body">
                    @if($employee->user)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Login credentials for this employee:</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-muted">Username/Email:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $employee->email }}" readonly id="emailCopy">
                                    <button class="btn btn-outline-primary" onclick="copyToClipboard('emailCopy')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-muted">Default Password:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="password123" readonly id="passwordCopy">
                                    <button class="btn btn-outline-primary" onclick="copyToClipboard('passwordCopy')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Employee can change password after first login</small>
                            </div>
                        </div>
                        <div class="alert alert-warning mt-2">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Note:</strong> Default password is <strong>password123</strong>. Employee should change this after first login.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            No login account created for this employee yet.
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-warning mt-2">
                                Create Account
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(elementId) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    // Show notification
    var btn = event.target;
    var originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
    setTimeout(function() {
        btn.innerHTML = originalText;
    }, 2000);
}
</script>
@endpush
@endsection