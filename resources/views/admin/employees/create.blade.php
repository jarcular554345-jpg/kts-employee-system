@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Add New Employee</h2>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Employee Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Employee ID <span class="text-danger">*</span></label>
                        <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ old('employee_id') }}" required>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label>Position <span class="text-danger">*</span></label>
                        <select name="position" id="position" class="form-control @error('position') is-invalid @enderror" required>
                            <option value="">Select Position</option>
                            <option value="Driver" {{ old('position') == 'Driver' ? 'selected' : '' }}>Driver</option>
                            <option value="Mechanic" {{ old('position') == 'Mechanic' ? 'selected' : '' }}>Mechanic</option>
                            <option value="Staff" {{ old('position') == 'Staff' ? 'selected' : '' }}>Staff</option>
                            <option value="Office Personnel" {{ old('position') == 'Office Personnel' ? 'selected' : '' }}>Office Personnel</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label>Department <span class="text-danger">*</span></label>
                        <select name="department" id="department" class="form-control @error('department') is-invalid @enderror" required>
                            <option value="">Select Department</option>
                        </select>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label>Contact Number <span class="text-danger">*</span></label>
                        <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" required>
                        @error('contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Date Hired <span class="text-danger">*</span></label>
                        <input type="date" name="date_hired" class="form-control @error('date_hired') is-invalid @enderror" value="{{ old('date_hired') }}" required>
                        @error('date_hired')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Salary <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}" required>
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Employment Status <span class="text-danger">*</span></label>
                        <select name="employment_status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label>Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- PASSWORD INFORMATION -->
                <div class="alert alert-success mt-3">
                    <i class="fas fa-key"></i> 
                    <strong>Login Account Information:</strong><br>
                    A login account will be automatically created for this employee with:
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="fw-bold">Email/Username:</label>
                            <code>Employee's email address</code>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Default Password:</label>
                            <code>password123</code>
                        </div>
                    </div>
                    <hr>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Employee can change their password after first login.
                        Please inform the employee of these credentials.
                    </small>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Employee
                </button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Department mapping based on position
    const departmentMapping = {
        'Driver': [
            'Transportation Department',
            'Logistics Department',
            'Fleet Operations'
        ],
        'Mechanic': [
            'Maintenance Department',
            'Service Department',
            'Technical Operations'
        ],
        'Staff': [
            'Administrative Department',
            'Customer Service Department',
            'Operations Department'
        ],
        'Office Personnel': [
            'Human Resources Department',
            'Finance Department',
            'Administrative Department'
        ]
    };
    
    // Function to update department dropdown based on selected position
    function updateDepartments() {
        const position = document.getElementById('position').value;
        const departmentSelect = document.getElementById('department');
        
        // Clear current options
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        
        // If a position is selected, populate departments
        if (position && departmentMapping[position]) {
            departmentMapping[position].forEach(dept => {
                const option = document.createElement('option');
                option.value = dept;
                option.textContent = dept;
                departmentSelect.appendChild(option);
            });
            departmentSelect.disabled = false;
        } else {
            departmentSelect.disabled = true;
        }
    }
    
    // Add event listener to position dropdown
    document.getElementById('position').addEventListener('change', updateDepartments);
    
    // Initialize on page load
    updateDepartments();
</script>
@endpush
@endsection