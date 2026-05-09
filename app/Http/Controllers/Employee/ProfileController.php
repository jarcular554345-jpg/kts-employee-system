<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $employee = Auth::user()->employee;
        return view('employee.profile.edit', compact('employee'));
    }
    
    public function update(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Update basic info
        $employee->full_name = $request->full_name;
        $employee->contact_number = $request->contact_number;
        $employee->address = $request->address;
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            
            // Upload new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $employee->profile_picture = $path;
        }
        
        $employee->save();
        
        // Update user name if changed
        if ($employee->user && $employee->user->name !== $employee->full_name) {
            $employee->user->name = $employee->full_name;
            $employee->user->save();
        }
        
        return redirect()->route('employee.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('employee.profile.edit')
            ->with('success', 'Password changed successfully!');
    }
}