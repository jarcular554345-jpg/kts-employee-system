<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee');
        
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }
        
        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        $employees = Employee::all();
        
        // Get late employees for today
        $lateEmployees = Attendance::whereDate('date', today())
            ->where('time_in', '>', '08:00:00')
            ->whereNotNull('time_in')
            ->with('employee')
            ->get();
        
        // Get absent employees for today
        $presentEmployees = Attendance::whereDate('date', today())
            ->whereNotNull('time_in')
            ->pluck('employee_id')
            ->toArray();
        
        $absentEmployees = Employee::whereNotIn('id', $presentEmployees)
            ->where('employment_status', 'Active')
            ->get();
        
        return view('admin.attendance.index', compact('attendances', 'employees', 'lateEmployees', 'absentEmployees'));
    }

    /**
     * Show the form for creating a new attendance record (MANUAL ENTRY).
     */
    public function create()
    {
        $employees = Employee::where('employment_status', 'Active')->get();
        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status' => 'required|in:Present,Late,Absent',
        ]);

        // Check if record already exists for this employee on this date
        $existing = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Attendance record already exists for this employee on this date. Please edit instead.');
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance recorded successfully');
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance)
    {
        return view('admin.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status' => 'required|in:Present,Late,Absent',
        ]);

        $attendance->update([
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance updated successfully');
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance record deleted');
    }
}
