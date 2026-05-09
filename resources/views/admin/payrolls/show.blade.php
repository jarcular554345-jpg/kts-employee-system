@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payroll Details</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Payroll
            </button>
            <a href="{{ route('admin.payrolls.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>KTS Car Rental</h4>
                    <h5>Payroll Slip</h5>
                    <p>{{ $payroll->payroll_month }} {{ $payroll->year }}</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Employee Information:</h6>
                            <p>
                                <strong>Name:</strong> {{ $payroll->employee->full_name }}<br>
                                <strong>Position:</strong> {{ $payroll->employee->position }}<br>
                                <strong>Department:</strong> {{ $payroll->employee->department }}<br>
                                <strong>Employee ID:</strong> {{ $payroll->employee->employee_id }}
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6>Payroll Period:</h6>
                            <p>
                                <strong>Month:</strong> {{ $payroll->payroll_month }}<br>
                                <strong>Year:</strong> {{ $payroll->year }}<br>
                                <strong>Date Generated:</strong> {{ $payroll->created_at->format('F d, Y') }}
                            </p>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td width="50%"><strong>Basic Salary</strong></td>
                            <td class="text-end">₱{{ number_format($payroll->basic_salary, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Overtime Hours</strong></td>
                            <td class="text-end">{{ $payroll->overtime_hours }} hours</td>
                        </tr>
                        <tr>
                            <td><strong>Overtime Pay</strong></td>
                            <td class="text-end">₱{{ number_format($payroll->overtime_pay, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Deductions</strong></td>
                            <td class="text-end">(₱{{ number_format($payroll->deductions, 2) }})</td>
                        </tr>
                        <tr class="table-success">
                            <td><strong>TOTAL SALARY</strong></td>
                            <td class="text-end"><strong>₱{{ number_format($payroll->total_salary, 2) }}</strong></td>
                        </tr>
                    </table>

                    <div class="alert alert-secondary mt-3">
                        <p class="text-muted mb-0">Salary breakdown includes regular pay, overtime compensation, and applicable deductions.</p>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>This is a computer-generated document. No signature required.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .sidebar, .navbar, .card-footer a {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
    }
</style>
@endsection