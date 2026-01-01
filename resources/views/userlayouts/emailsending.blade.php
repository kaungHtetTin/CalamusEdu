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
@if (session('msg'))
<div class="alert alert-success alert-modern" role="alert">
  <i class="fas fa-check-circle me-2"></i>{{session('msg')}}
</div>
@endif

@if (session('err'))
<div class="alert alert-danger alert-modern" role="alert">
  <i class="fas fa-exclamation-circle me-2"></i>{{session('err')}}
</div>
@endif

{{-- Send Email Card --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card email-send-card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header email-send-header">
        <div class="d-flex align-items-center">
          <div class="header-icon-wrapper email-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div>
            <h5 class="mb-0" style="font-weight: 600;">Send Email</h5>
            <p class="mb-0 text-muted" style="font-size: 14px;">Send email notification to user</p>
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
              <div class="user-info-item mb-2">
                <i class="fas fa-envelope text-muted me-2"></i>
                <span class="text-muted">{{$learner->learner_email}}</span>
              </div>
              @endif
              @if($learner->learner_email=="")
              <div class="alert alert-warning email-warning" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                  <strong>No Email Address</strong>
                  <p class="mb-0" style="font-size: 13px;">This user has not provided an email address. We cannot send email to this user.</p>
                </div>
              </div>
              @endif
            </div>
          </div>

          {{-- Email Form Section --}}
          <div class="col-lg-8 col-md-7">
            <form action="{{route('sendEmail')}}" method="POST" class="email-send-form">
              @csrf
              <input type="hidden" name="id" value="{{$learner->id}}"/>
              
              <div class="form-group-modern mb-3">
                <label for="email" class="form-label-modern">
                  <i class="fas fa-at me-2"></i>To
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control-modern" 
                       placeholder="User Email"
                       value="{{$learner->learner_email}}"
                       required
                       {{$learner->learner_email=="" ? 'disabled' : ''}}/>
                @if($errors->first('email'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('email')}}
                </div>
                @endif
              </div>

              <div class="form-group-modern mb-3">
                <label for="header" class="form-label-modern">
                  <i class="fas fa-heading me-2"></i>From
                </label>
                <input type="text" 
                       id="header" 
                       name="header" 
                       class="form-control-modern" 
                       placeholder="Sender Email"
                       value="calamuseducation@calamuseducation.com"
                       required/>
                @if($errors->first('header'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('header')}}
                </div>
                @endif
              </div>

              <div class="form-group-modern mb-3">
                <label for="subject" class="form-label-modern">
                  <i class="fas fa-tag me-2"></i>Subject
                </label>
                <input type="text" 
                       id="subject" 
                       name="subject" 
                       class="form-control-modern" 
                       placeholder="Email Subject"
                       required/>
                @if($errors->first('subject'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('subject')}}
                </div>
                @endif
              </div>

              <div class="form-group-modern mb-4">
                <label for="msg" class="form-label-modern">
                  <i class="fas fa-comment-alt me-2"></i>Message
                </label>
                <textarea id="msg" 
                          name="msg" 
                          class="form-control-modern textarea-modern" 
                          placeholder="Type your email message here..."
                          rows="8"
                          required></textarea>
                @if($errors->first('msg'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('msg')}}
                </div>
                @endif
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-send-email" {{$learner->learner_email=="" ? 'disabled' : ''}}>
                  <i class="fas fa-paper-plane me-2"></i>Send Email
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
.email-send-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.email-send-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

body.dark-theme .email-send-card {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-theme .email-send-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
}

.email-send-header {
  background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(76, 175, 80, 0.05) 100%);
  border-bottom: 1px solid rgba(76, 175, 80, 0.2);
  padding: 20px 24px;
}

body.dark-theme .email-send-header {
  background: linear-gradient(135deg, rgba(76, 175, 80, 0.15) 0%, rgba(76, 175, 80, 0.08) 100%);
  border-bottom-color: rgba(76, 175, 80, 0.3);
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

.header-icon-wrapper.email-icon {
  background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
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
  border: 4px solid rgba(76, 175, 80, 0.2);
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

.email-warning {
  margin-top: 16px;
  padding: 12px 16px;
  border-radius: 8px;
  background: linear-gradient(135deg, rgba(255, 152, 0, 0.1) 0%, rgba(255, 152, 0, 0.05) 100%);
  border-left: 4px solid #ff9800;
  color: #e65100;
  text-align: left;
}

body.dark-theme .email-warning {
  background: linear-gradient(135deg, rgba(255, 152, 0, 0.15) 0%, rgba(255, 152, 0, 0.08) 100%);
  color: #ffb74d;
  border-left-color: #ffa726;
}

.email-warning i {
  font-size: 20px;
  margin-right: 12px;
}

.email-warning strong {
  display: block;
  margin-bottom: 4px;
}

.form-group-modern {
  margin-bottom: 20px;
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
  border-color: #4caf50;
  box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.form-control-modern:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

body.dark-theme .form-control-modern {
  border-color: rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.05);
}

body.dark-theme .form-control-modern:focus {
  border-color: #66bb6a;
  box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.2);
}

body.light-theme .form-control-modern {
  border-color: rgba(0, 0, 0, 0.1);
  background: white;
}

body.light-theme .form-control-modern:focus {
  border-color: #388e3c;
  box-shadow: 0 0 0 3px rgba(56, 142, 60, 0.1);
}

.textarea-modern {
  resize: vertical;
  min-height: 150px;
  font-family: inherit;
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

.btn-send-email {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  border: none;
  background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
  color: white;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
}

.btn-send-email:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
  filter: brightness(1.05);
}

.btn-send-email:disabled {
  opacity: 0.6;
  cursor: not-allowed;
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
  
  .btn-send-email,
  .btn-cancel {
    width: 100%;
    justify-content: center;
  }
}
</style>

@endsection
