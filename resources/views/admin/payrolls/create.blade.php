@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Calculate Payroll</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.payrolls.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Select Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" data-salary="{{ $employee->salary }}">
                                    {{ $employee->full_name }} - {{ $employee->position }} (₱{{ number_format($employee->salary, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label>Payroll Month <span class="text-danger">*</span></label>
                        <select name="payroll_month" class="form-control" required>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label>Year <span class="text-danger">*</span></label>
                        <select name="year" class="form-control" required>
                            @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Basic Salary</label>
                        <input type="text" id="basic_salary_display" class="form-control" readonly>
                        <input type="hidden" name="basic_salary" id="basic_salary">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Overtime Hours <span class="text-danger">*</span></label>
                        <input type="number" step="0.5" name="overtime_hours" id="overtime_hours" class="form-control @error('overtime_hours') is-invalid @enderror" value="0" required>
                        <small class="text-muted">Overtime rate: 1.25x of regular hourly rate</small>
                        @error('overtime_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Overtime Pay (Auto-calculated)</label>
                        <input type="text" id="overtime_pay_display" class="form-control" readonly>
                        <input type="hidden" name="overtime_pay" id="overtime_pay">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Deductions (Late, Absences, etc.) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="deductions" id="deductions" class="form-control @error('deductions') is-invalid @enderror" value="0" required>
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Total Salary (Auto-calculated)</label>
                        <input type="text" id="total_salary_display" class="form-control bg-light" readonly style="font-weight: bold; font-size: 1.2rem;">
                        <input type="hidden" name="total_salary" id="total_salary">
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Formula:</strong> Basic Salary + Overtime Pay - Deductions = Total Salary
                </div>
                
                <button type="submit" class="btn btn-primary">Save Payroll</button>
                <a href="{{ route('admin.payrolls.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentSalary = 0;
    
    // When employee is selected
    document.getElementById('employee_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        currentSalary = parseFloat(selected.getAttribute('data-salary')) || 0;
        
        document.getElementById('basic_salary_display').value = '₱' + currentSalary.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('basic_salary').value = currentSalary;
        
        calculateTotal();
    });
    
    // Calculate overtime pay
    document.getElementById('overtime_hours').addEventListener('input', calculateTotal);
    document.getElementById('deductions').addEventListener('input', calculateTotal);
    
    function calculateTotal() {
        let overtimeHours = parseFloat(document.getElementById('overtime_hours').value) || 0;
        let deductions = parseFloat(document.getElementById('deductions').value) || 0;
        
        // Calculate hourly rate (assuming 8 hours per day, 30 days per month)
        let hourlyRate = currentSalary / 30 / 8;
        let overtimePay = overtimeHours * hourlyRate * 1.25;
        let totalSalary = currentSalary + overtimePay - deductions;
        
        document.getElementById('overtime_pay_display').value = '₱' + overtimePay.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('overtime_pay').value = overtimePay;
        document.getElementById('total_salary_display').value = '₱' + totalSalary.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('total_salary').value = totalSalary;
    }
</script>
@endpush
@endsection