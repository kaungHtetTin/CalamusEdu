@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user' style="min-width: 225px" name="phone" />
</form>
@endsection

@section('content')

{{-- Success/Error Messages --}}
@if (session('resetSuccess'))
<div class="alert alert-success alert-modern" role="alert">
  <i class="fas fa-check-circle me-2"></i>{{session('resetSuccess')}}
</div>
@endif

@if (session('resetErr'))
<div class="alert alert-danger alert-modern" role="alert">
  <i class="fas fa-exclamation-circle me-2"></i>{{session('resetErr')}}
</div>
@endif

{{-- Password Reset Card --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card password-reset-card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header password-reset-header">
        <div class="d-flex align-items-center">
          <div class="header-icon-wrapper">
            <i class="fas fa-key"></i>
          </div>
          <div>
            <h5 class="mb-0" style="font-weight: 600;">Password Reset</h5>
            <p class="mb-0 text-muted" style="font-size: 14px;">Reset password for user account</p>
          </div>
        </div>
      </div>
      <div class="card-body p-4">
        @if ($learner!=null)
        <div class="row">
          {{-- User Profile Section --}}
          <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
            <div class="user-profile-section text-center text-md-start">
              <div class="user-avatar-wrapper mb-3">
                <img src="{{$learner->learner_image}}" 
                     alt="{{$learner->learner_name}}"
                     class="user-avatar-img"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'120\'%3E%3Ccircle cx=\'60\' cy=\'60\' r=\'60\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'48\' font-weight=\'600\'%3E{{ substr($learner->learner_name ?? 'U', 0, 1) }}%3C/text%3E%3C/svg%3E'">
              </div>
              <h4 class="mb-2" style="font-weight: 600; color: var(--text-primary);">
                {{$learner->learner_name}}
              </h4>
              <div class="user-info-item mb-2">
                <i class="fas fa-phone text-muted me-2"></i>
                <span class="text-muted">{{$learner->learner_phone}}</span>
              </div>
              @if($learner->learner_email)
              <div class="user-info-item">
                <i class="fas fa-envelope text-muted me-2"></i>
                <span class="text-muted">{{$learner->learner_email}}</span>
              </div>
              @endif
            </div>
          </div>

          {{-- Password Reset Form --}}
          <div class="col-lg-8 col-md-7">
            <form action="{{route('resetPassword')}}" method="POST" class="password-reset-form">
              @csrf
              <input type="hidden" name="phone" value="{{$learner->learner_phone}}"/>
              
              <div class="form-group-modern mb-4">
                <label for="password" class="form-label-modern">
                  <i class="fas fa-lock me-2"></i>New Password
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control-modern" 
                       placeholder="Enter the new password"
                       required
                       autocomplete="new-password"/>
                @if($errors->first('password'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('password')}}
                </div>
                @endif
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-reset-password">
                  <i class="fas fa-key me-2"></i>Reset Password
                </button>
                <a href="{{route('detail', ['phone' => $learner->learner_phone])}}" class="btn btn-cancel">
                  <i class="fas fa-times me-2"></i>Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
        @else
        {{-- No User Found --}}
        <div class="text-center py-5">
          <div class="empty-state-icon mb-3">
            <i class="fas fa-user-slash"></i>
          </div>
          <h5 class="text-muted mb-2">No user found</h5>
          <p class="text-muted">The user you're looking for doesn't exist.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
.password-reset-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.password-reset-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

body.dark-theme .password-reset-card {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-theme .password-reset-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
}

.password-reset-header {
  background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(33, 150, 243, 0.05) 100%);
  border-bottom: 1px solid rgba(33, 150, 243, 0.2);
  padding: 20px 24px;
}

body.dark-theme .password-reset-header {
  background: linear-gradient(135deg, rgba(33, 150, 243, 0.15) 0%, rgba(33, 150, 243, 0.08) 100%);
  border-bottom-color: rgba(33, 150, 243, 0.3);
}

.header-icon-wrapper {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  color: white;
  font-size: 20px;
}

.user-profile-section {
  padding: 20px;
  background: rgba(0, 0, 0, 0.02);
  border-radius: 12px;
  height: 100%;
}

body.dark-theme .user-profile-section {
  background: rgba(255, 255, 255, 0.03);
}

body.light-theme .user-profile-section {
  background: rgba(0, 0, 0, 0.02);
}

.user-avatar-wrapper {
  display: inline-block;
}

.user-avatar-img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid rgba(33, 150, 243, 0.2);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.user-avatar-img:hover {
  transform: scale(1.05);
}

body.dark-theme .user-avatar-img {
  border-color: rgba(255, 255, 255, 0.2);
}

body.light-theme .user-avatar-img {
  border-color: rgba(0, 0, 0, 0.1);
}

.user-info-item {
  display: flex;
  align-items: center;
  justify-content: center;
  justify-content: flex-start;
}

@media (max-width: 767px) {
  .user-info-item {
    justify-content: center;
  }
}

.form-group-modern {
  margin-bottom: 24px;
}

.form-label-modern {
  display: block;
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--text-primary);
  font-size: 14px;
}

.form-control-modern {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  font-size: 15px;
  transition: all 0.3s ease;
  background: var(--bg-secondary);
  color: var(--text-primary);
}

.form-control-modern:focus {
  outline: none;
  border-color: #2196F3;
  box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

body.dark-theme .form-control-modern {
  border-color: rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.05);
}

body.dark-theme .form-control-modern:focus {
  border-color: #64B5F6;
  box-shadow: 0 0 0 3px rgba(100, 181, 246, 0.2);
}

body.light-theme .form-control-modern {
  border-color: rgba(0, 0, 0, 0.1);
  background: white;
}

body.light-theme .form-control-modern:focus {
  border-color: #1976D2;
  box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.error-message {
  color: #f44336;
  font-size: 13px;
  margin-top: 6px;
  display: flex;
  align-items: center;
}

body.dark-theme .error-message {
  color: #ef5350;
}

.form-actions {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.btn-reset-password {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  border: none;
  background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
  color: white;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
}

.btn-reset-password:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(244, 67, 54, 0.4);
  filter: brightness(1.05);
}

.btn-cancel {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 500;
  border: 2px solid rgba(0, 0, 0, 0.1);
  background: transparent;
  color: var(--text-primary);
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  text-decoration: none;
}

.btn-cancel:hover {
  background: rgba(0, 0, 0, 0.05);
  border-color: rgba(0, 0, 0, 0.2);
  transform: translateY(-2px);
}

body.dark-theme .btn-cancel {
  border-color: rgba(255, 255, 255, 0.1);
  color: var(--text-primary);
}

body.dark-theme .btn-cancel:hover {
  background: rgba(255, 255, 255, 0.05);
  border-color: rgba(255, 255, 255, 0.2);
}

body.light-theme .btn-cancel {
  border-color: rgba(0, 0, 0, 0.1);
}

body.light-theme .btn-cancel:hover {
  background: rgba(0, 0, 0, 0.05);
  border-color: rgba(0, 0, 0, 0.2);
}

.alert-modern {
  border-radius: 8px;
  padding: 16px 20px;
  margin-bottom: 24px;
  border: none;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.alert-success {
  background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(76, 175, 80, 0.05) 100%);
  color: #2e7d32;
  border-left: 4px solid #4caf50;
}

body.dark-theme .alert-success {
  background: linear-gradient(135deg, rgba(76, 175, 80, 0.15) 0%, rgba(76, 175, 80, 0.08) 100%);
  color: #81c784;
  border-left-color: #66bb6a;
}

.alert-danger {
  background: linear-gradient(135deg, rgba(244, 67, 54, 0.1) 0%, rgba(244, 67, 54, 0.05) 100%);
  color: #c62828;
  border-left: 4px solid #f44336;
}

body.dark-theme .alert-danger {
  background: linear-gradient(135deg, rgba(244, 67, 54, 0.15) 0%, rgba(244, 67, 54, 0.08) 100%);
  color: #e57373;
  border-left-color: #ef5350;
}

.empty-state-icon {
  font-size: 64px;
  color: #9e9e9e;
  opacity: 0.5;
}

body.dark-theme .empty-state-icon {
  color: #757575;
}

@media (max-width: 768px) {
  .user-avatar-img {
    width: 100px;
    height: 100px;
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .btn-reset-password,
  .btn-cancel {
    width: 100%;
    justify-content: center;
  }
}
</style>

@endsection
