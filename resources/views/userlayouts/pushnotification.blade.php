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

{{-- Send Notification Card --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card notification-send-card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header notification-send-header">
        <div class="d-flex align-items-center">
          <div class="header-icon-wrapper notification-icon">
            <i class="fas fa-bell"></i>
          </div>
          <div>
            <h5 class="mb-0" style="font-weight: 600;">Send Notification</h5>
            <p class="mb-0 text-muted" style="font-size: 14px;">Send push notification to user's device</p>
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
              <div class="user-info-item mb-3">
                <i class="fas fa-envelope text-muted me-2"></i>
                <span class="text-muted">{{$learner->learner_email}}</span>
              </div>
              @endif

              {{-- Available Apps Section --}}
              <div class="available-apps-section mt-3">
                <h6 class="mb-2" style="font-weight: 600; font-size: 14px; color: var(--text-primary);">
                  <i class="fas fa-mobile-alt me-2"></i>Available Apps
                </h6>
                <div class="app-list">
                  @if($englishData!=null)
                  <div class="app-item available">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Easy English</span>
                  </div>
                  @else
                  <div class="app-item unavailable">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    <span>Easy English</span>
                  </div>
                  @endif

                  @if($koreaData!=null)
                  <div class="app-item available">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Easy Korean</span>
                  </div>
                  @else
                  <div class="app-item unavailable">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    <span>Easy Korean</span>
                  </div>
                  @endif

                  @if($chineseData!=null)
                  <div class="app-item available">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Easy Chinese</span>
                  </div>
                  @else
                  <div class="app-item unavailable">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    <span>Easy Chinese</span>
                  </div>
                  @endif

                  @if($japaneseData!=null)
                  <div class="app-item available">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Easy Japanese</span>
                  </div>
                  @else
                  <div class="app-item unavailable">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    <span>Easy Japanese</span>
                  </div>
                  @endif

                  @if($russianData!=null)
                  <div class="app-item available">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Easy Russian</span>
                  </div>
                  @else
                  <div class="app-item unavailable">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    <span>Easy Russian</span>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- Notification Form Section --}}
          <div class="col-lg-8 col-md-7">
            <form action="{{route('pushNotification')}}" method="POST" class="notification-send-form">
              @csrf
              
              <div class="form-group-modern mb-3">
                <label for="title" class="form-label-modern">
                  <i class="fas fa-heading me-2"></i>Title
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       class="form-control-modern" 
                       placeholder="Notification title"
                       required/>
                @if($errors->first('title'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('title')}}
                </div>
                @endif
              </div>

              <div class="form-group-modern mb-3">
                <label for="msg" class="form-label-modern">
                  <i class="fas fa-comment-alt me-2"></i>Message
                </label>
                <textarea id="msg" 
                          name="msg" 
                          class="form-control-modern textarea-modern" 
                          placeholder="Enter notification message..."
                          rows="6"
                          required></textarea>
                @if($errors->first('msg'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('msg')}}
                </div>
                @endif
              </div>

              <div class="form-group-modern mb-4">
                <label for="app" class="form-label-modern">
                  <i class="fas fa-mobile-alt me-2"></i>Select App
                </label>
                <select id="app" 
                        name="app" 
                        class="form-control-modern select-modern"
                        required>
                  <option value="">-- Select an app --</option>
                  @if($englishData!=null)
                  <option value="{{$englishData->token}}">Easy English</option>
                  @endif
                  @if($koreaData!=null)
                  <option value="{{$koreaData->token}}">Easy Korean</option>
                  @endif
                  @if($chineseData!=null)
                  <option value="{{$chineseData->token}}">Easy Chinese</option>
                  @endif
                  @if($japaneseData!=null)
                  <option value="{{$japaneseData->token}}">Easy Japanese</option>
                  @endif
                  @if($russianData!=null)
                  <option value="{{$russianData->token}}">Easy Russian</option>
                  @endif
                </select>
                @if($errors->first('app'))
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{$errors->first('app')}}
                </div>
                @endif
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-send-notification">
                  <i class="fas fa-paper-plane me-2"></i>Send Notification
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
.notification-send-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.notification-send-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

body.dark-theme .notification-send-card {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-theme .notification-send-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
}

.notification-send-header {
  background: linear-gradient(135deg, rgba(255, 152, 0, 0.1) 0%, rgba(255, 152, 0, 0.05) 100%);
  border-bottom: 1px solid rgba(255, 152, 0, 0.2);
  padding: 20px 24px;
}

body.dark-theme .notification-send-header {
  background: linear-gradient(135deg, rgba(255, 152, 0, 0.15) 0%, rgba(255, 152, 0, 0.08) 100%);
  border-bottom-color: rgba(255, 152, 0, 0.3);
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

.header-icon-wrapper.notification-icon {
  background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
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
  border: 4px solid rgba(255, 152, 0, 0.2);
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

.available-apps-section {
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}

body.dark-theme .available-apps-section {
  border-top-color: rgba(255, 255, 255, 0.1);
}

.app-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.app-item {
  display: flex;
  align-items: center;
  padding: 8px 12px;
  border-radius: 6px;
  font-size: 14px;
  transition: all 0.2s ease;
}

.app-item.available {
  background: rgba(76, 175, 80, 0.1);
  color: var(--text-primary);
}

.app-item.unavailable {
  background: rgba(244, 67, 54, 0.1);
  color: var(--text-primary);
  opacity: 0.7;
}

body.dark-theme .app-item.available {
  background: rgba(76, 175, 80, 0.15);
}

body.dark-theme .app-item.unavailable {
  background: rgba(244, 67, 54, 0.15);
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
  border-color: #ff9800;
  box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
}

body.dark-theme .form-control-modern {
  border-color: rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.05);
}

body.dark-theme .form-control-modern:focus {
  border-color: #ffb74d;
  box-shadow: 0 0 0 3px rgba(255, 183, 77, 0.2);
}

body.light-theme .form-control-modern {
  border-color: rgba(0, 0, 0, 0.1);
  background: white;
}

body.light-theme .form-control-modern:focus {
  border-color: #f57c00;
  box-shadow: 0 0 0 3px rgba(245, 124, 0, 0.1);
}

.textarea-modern {
  resize: vertical;
  min-height: 120px;
  font-family: inherit;
}

.select-modern {
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 16px center;
  padding-right: 40px;
}

body.dark-theme .select-modern {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23fff' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
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

.btn-send-notification {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  border: none;
  background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
  color: white;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
}

.btn-send-notification:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 152, 0, 0.4);
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
  
  .btn-send-notification,
  .btn-cancel {
    width: 100%;
    justify-content: center;
  }
}
</style>

@endsection
