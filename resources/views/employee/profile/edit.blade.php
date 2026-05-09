@extends('layouts.employee')

@section('content')
<style>
    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .profile-sidebar {
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        overflow: hidden;
    }
    
    .profile-avatar-large {
        text-align: center;
        padding: 30px;
        background: linear-gradient(135deg, #1a1e2b 0%, #2d3748 100%);
    }
    
    .avatar-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        background: white;
    }
    
    .avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid white;
    }
    
    .avatar-placeholder i {
        font-size: 5rem;
        color: white;
    }
    
    .profile-name-large {
        color: white;
        margin-top: 15px;
        font-size: 1.3rem;
        font-weight: 600;
    }
    
    .profile-email {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
    }
    
    .profile-info-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        margin-bottom: 25px;
    }
    
    .card-header-custom {
        background: #f8fafc;
        padding: 18px 22px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .form-group-custom {
        margin-bottom: 20px;
    }
    
    .form-label-custom {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .form-control-custom:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74,144,226,0.1);
        outline: none;
    }
    
    .btn-save {
        background: #4a90e2;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        background: #357abd;
        transform: translateY(-1px);
    }
    
    .btn-cancel {
        background: #e9ecef;
        color: #495057;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        background: #dee2e6;
    }
    
    .alert-custom {
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }
    
    .password-requirements {
        font-size: 0.7rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 0.7rem;
        margin-top: 5px;
    }
    
    @media (max-width: 768px) {
        .profile-avatar-large {
            padding: 20px;
        }
        .avatar-image, .avatar-placeholder {
            width: 100px;
            height: 100px;
        }
    }
</style>

<div class="profile-container">
    <div class="row g-4">
        <!-- Left Sidebar - Profile Picture -->
        <div class="col-md-4">
            <div class="profile-sidebar">
                <div class="profile-avatar-large">
                    @if($employee->profile_picture && file_exists(public_path('storage/' . $employee->profile_picture)))
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" class="avatar-image">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    @endif
                    <h4 class="profile-name-large">{{ $employee->full_name }}</h4>
                    <p class="profile-email">{{ $employee->email }}</p>
                </div>
                <div class="p-3 text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Employee since {{ date('M Y', strtotime($employee->date_hired)) }}
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Edit Forms -->
        <div class="col-md-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-custom">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-custom">
                    <i class="fas fa-exclamation-circle me-2"></i> Please correct the errors below.
                </div>
            @endif
            
            <!-- Edit Profile Form -->
            <div class="profile-info-card">
                <div class="card-header-custom">
                    <i class="fas fa-user-edit me-2 text-primary"></i> Edit Profile Information
                </div>
                <div class="p-4">
                    <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" name="full_name" class="form-control-custom" 
                                   value="{{ old('full_name', $employee->full_name) }}" required>
                            @error('full_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Email Address</label>
                            <input type="email" class="form-control-custom" value="{{ $employee->email }}" disabled>
                            <small class="text-muted">Email cannot be changed. Contact admin for email updates.</small>
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control-custom" 
                                   value="{{ old('contact_number', $employee->contact_number) }}" required>
                            @error('contact_number')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Address</label>
                            <textarea name="address" class="form-control-custom" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control-custom" accept="image/*">
                            <small class="text-muted">Allowed formats: JPG, PNG, GIF (Max: 2MB)</small>
                            @error('profile_picture')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                            <a href="{{ route('employee.dashboard') }}" class="btn-cancel ms-2">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password Form -->
            <div class="profile-info-card">
                <div class="card-header-custom">
                    <i class="fas fa-key me-2 text-primary"></i> Change Password
                </div>
                <div class="p-4">
                    <form action="{{ route('employee.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Current Password</label>
                            <input type="password" name="current_password" class="form-control-custom" required>
                            @error('current_password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">New Password</label>
                            <input type="password" name="new_password" class="form-control-custom" required>
                            @error('new_password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control-custom" required>
                        </div>
                        
                        <div class="password-requirements">
                            <i class="fas fa-shield-alt me-1"></i> Password must be at least 8 characters.
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-key me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection