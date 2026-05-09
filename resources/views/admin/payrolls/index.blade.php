@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payroll Management</h2>
        <a href="{{ route('admin.payrolls.create') }}" class="btn btn-primary">
            <i class="fas fa-calculator"></i> Calculate Payroll
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Payroll Records</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee Name</th>
                            <th>Month/Year</th>
                            <th>Basic Salary</th>
                            <th>Overtime Pay</th>
                            <th>Deductions</th>
                            <th>Total Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ $payroll->payroll_month }} {{ $payroll->year }}</td>
                            <td>₱{{ number_format($payroll->basic_salary, 2) }}</td>
                            <td>₱{{ number_format($payroll->overtime_pay, 2) }}</td>
                            <td>₱{{ number_format($payroll->deductions, 2) }}</td>
                            <td><strong>₱{{ number_format($payroll->total_salary, 2) }}</strong></td>
                            <td>
                                <a href="{{ route('admin.payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this payroll record?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                             </td>
                         </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No payroll records found.</td>
                             </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payrolls->links() }}
        </div>
    </div>
</div>
@endsection