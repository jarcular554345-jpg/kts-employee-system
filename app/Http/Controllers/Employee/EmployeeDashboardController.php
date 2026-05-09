<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            Log::error('Employee not found for user: ' . Auth::user()->id);
            return redirect()->route('dashboard')->with('error', 'Employee profile not found. Please contact admin.');
        }
        
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('h:i:s A');
        $currentDateTime = Carbon::now()->format('F d, Y h:i:s A');
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
        
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('employee.dashboard', compact('employee', 'attendances', 'leaveRequests', 'currentDate', 'currentTime', 'currentDateTime'));
    }

    public function storeLeaveRequest(Request $request)
    {
        // Log the request for debugging
        Log::info('Leave request submitted', $request->all());
        
        // Get the authenticated user's employee record
        $user = Auth::user();
        $employee = $user->employee;
        
        // Check if employee exists
        if (!$employee) {
            Log::error('No employee record found for user: ' . $user->id);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Employee record not found. Please contact administrator.');
        }
        
        // Validate the request with better error messages
        $validator = validator($request->all(), [
            'leave_type' => 'required|in:Vacation Leave,Sick Leave,Emergency Leave',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|min:5|max:500',
        ], [
            'leave_type.required' => 'Please select a leave type.',
            'leave_type.in' => 'Invalid leave type selected.',
            'start_date.required' => 'Please select a start date.',
            'start_date.date' => 'Invalid start date format.',
            'end_date.required' => 'Please select an end date.',
            'end_date.after_or_equal' => 'End date must be equal to or after start date.',
            'reason.required' => 'Please provide a reason for your leave request.',
            'reason.min' => 'Reason must be at least 5 characters.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }
        
        // Check if start date is not in the past
        $today = Carbon::now()->startOfDay();
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        
        if ($startDate->lt($today)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Leave start date cannot be in the past.');
        }
        
        try {
            // Create the leave request
            $leaveRequest = new LeaveRequest();
            $leaveRequest->employee_id = $employee->id;
            $leaveRequest->leave_type = $request->leave_type;
            $leaveRequest->start_date = $request->start_date;
            $leaveRequest->end_date = $request->end_date;
            $leaveRequest->reason = $request->reason;
            $leaveRequest->status = 'Pending';
            $leaveRequest->save();
            
            Log::info('Leave request created successfully', ['id' => $leaveRequest->id]);
            
            return redirect()->route('employee.dashboard')
                ->with('success', 'Your leave request has been submitted successfully! Waiting for admin approval.');
                
        } catch (\Exception $e) {
            Log::error('Error creating leave request: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit leave request. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function timeIn(Request $request)
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }
        
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $today = $now->format('Y-m-d');
        $formattedTime = $now->format('h:i:s A');
        
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();
        
        if ($existingAttendance && $existingAttendance->time_in) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'You have already timed in today at ' . Carbon::parse($existingAttendance->time_in)->format('h:i:s A'));
        }
        
        $status = 'Present';
        $lateTime = Carbon::createFromTimeString('08:00:00');
        $timeInTime = Carbon::createFromTimeString($currentTime);
        
        if ($timeInTime->gt($lateTime)) {
            $status = 'Late';
        }
        
        Attendance::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => $today,
            ],
            [
                'time_in' => $currentTime,
                'status' => $status,
                'remarks' => $status == 'Late' ? 'Arrived late at ' . $formattedTime : 'Arrived on time at ' . $formattedTime
            ]
        );
        
        $message = $status == 'Late' ? 'You timed in late at ' . $formattedTime . '. Please be punctual tomorrow!' : 'Time in recorded successfully at ' . $formattedTime . '!';
        
        return redirect()->route('employee.dashboard')
            ->with('success', $message);
    }
    
    public function timeOut(Request $request)
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }
        
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $today = $now->format('Y-m-d');
        $formattedTime = $now->format('h:i:s A');
        
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();
        
        if (!$attendance) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'You must time in first before timing out!');
        }
        
        if ($attendance->time_out) {
            $timeOut = Carbon::parse($attendance->time_out)->format('h:i:s A');
            return redirect()->route('employee.dashboard')
                ->with('error', 'You have already timed out today at ' . $timeOut . '!');
        }
        
        $attendance->update([
            'time_out' => $currentTime
        ]);
        
        $timeIn = Carbon::parse($attendance->time_in);
        $timeOut = Carbon::parse($currentTime);
        $hoursWorked = $timeOut->diffInHours($timeIn);
        
        return redirect()->route('employee.dashboard')
            ->with('success', 'Time out recorded successfully at ' . $formattedTime . '! You worked approximately ' . $hoursWorked . ' hours today.');
    }
}