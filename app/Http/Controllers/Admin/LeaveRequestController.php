<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with('employee')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $pendingRequests = LeaveRequest::where('status', 'Pending')->count();
        
        return view('admin.leave-requests.index', compact('leaveRequests', 'pendingRequests'));
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'Approved',
            'admin_remarks' => $request->remarks
        ]);

        return redirect()->route('admin.leave-requests.index')
            ->with('success', 'Leave request approved successfully');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'remarks' => 'required'
        ]);
        
        $leaveRequest->update([
            'status' => 'Rejected',
            'admin_remarks' => $request->remarks
        ]);

        return redirect()->route('admin.leave-requests.index')
            ->with('success', 'Leave request rejected');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        // Load the employee relationship
        $leaveRequest->load('employee');
        
        return view('admin.leave-requests.show', compact('leaveRequest'));
    }
}