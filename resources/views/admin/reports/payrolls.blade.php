@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payroll Report</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">KTS Car Rental - Payroll Report</h4>
            <small>
                Period: {{ request('month') ?: 'All Months' }} {{ request('year') ?: '' }} | 
                Generated: {{ date('F d, Y h:i A') }}
            </small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Month/Year</th>
                            <th>Basic Salary</th>
                            <th>Overtime Hrs</th>
                            <th>Overtime Pay</th>
                            <th>Deductions</th>
                            <th>Total Salary</th>
                         </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($payrolls as $index => $payroll)
                        @php $grandTotal += $payroll->total_salary; @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payroll->employee->full_name ?? 'N/A' }}</td>
                            <td>{{ $payroll->payroll_month }} {{ $payroll->year }}</td>
                            <td>₱{{ number_format($payroll->basic_salary, 2) }}</td>
                            <td>{{ $payroll->overtime_hours }}</td>
                            <td>₱{{ number_format($payroll->overtime_pay, 2) }}</td>
                            <td>₱{{ number_format($payroll->deductions, 2) }}</td>
                            <td><strong>₱{{ number_format($payroll->total_salary, 2) }}</strong></td>
                         </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <td colspan="7" class="text-end"><strong>GRAND TOTAL:</strong></td>
                            <td><strong>₱{{ number_format($grandTotal, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                 </table>
            </div>
            
            @if(request('month') && request('year'))
            <div class="alert alert-success mt-3">
                <strong>Period Summary:</strong> Total payroll for {{ request('month') }} {{ request('year') }} is ₱{{ number_format($grandTotal, 2) }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .sidebar, .navbar {
            display: none !important;
        }
        table {
            font-size: 12px;
        }
    }
</style>
@endsection