@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Management</h2>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Employee
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 10%">Employee ID</th>
                            <th style="width: 15%">Full Name</th>
                            <th style="width: 12%">Position</th>
                            <th style="width: 12%">Department</th>
                            <th style="width: 15%">Email</th>
                            <th style="width: 8%">Contact</th>
                            <th style="width: 8%">Date Hired</th>
                            <th style="width: 8%">Salary</th>
                            <th style="width: 7%">Status</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $index => $employee)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->department }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_number }}</td>
                            <td>{{ date('Y-m-d', strtotime($employee->date_hired)) }}</td>
                            <td class="text-end">₱{{ number_format($employee->salary, 2) }}</td>
                            <td class="text-center">
                                @if($employee->employment_status == 'Active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    No employees found. Click "Add Employee" to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection