@extends('layouts.main')

@section('content')
@if ($learner != null)
{{-- User Profile Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-4 flex-wrap">
          <div class="user-profile-avatar">
            <img src="{{ $learner->learner_image ?? '' }}" 
                 alt="{{ $learner->learner_name }}"
                 class="profile-avatar-img"
                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'120\'%3E%3Ccircle cx=\'60\' cy=\'60\' r=\'60\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'48\' font-weight=\'600\'%3E{{ substr($learner->learner_name ?? 'U', 0, 1) }}%3C/text%3E%3C/svg%3E'">
          </div>
          <div class="flex-grow-1">
            <h2 class="mb-2" style="font-weight: 600; color: var(--text-primary);">
              {{ $learner->learner_name }}
            </h2>
            <div class="d-flex flex-column gap-2 mb-3">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-phone text-muted" style="width: 20px;"></i>
                <span class="text-muted">{{ $learner->learner_phone }}</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-envelope text-muted" style="width: 20px;"></i>
                <span class="text-muted">{{ $learner->learner_email ?: 'N/A' }}</span>
              </div>
              @if($learner->region)
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-map-marker-alt text-muted" style="width: 20px;"></i>
                <span class="text-muted">{{ $learner->region }}</span>
              </div>
              @endif
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <a href="{{ route('showPasswordReset', $learner->learner_phone) }}" class="btn btn-action-modern">
                <i class="fas fa-key me-2"></i>Password Reset
              </a>
              <a href="{{ route('showSendEmail', $learner->id) }}" class="btn btn-action-modern">
                <i class="fas fa-envelope me-2"></i>Send Email
              </a>
              <a href="{{ route('showPushNotification', $learner->id) }}" class="btn btn-action-modern">
                <i class="fas fa-bell me-2"></i>Send Notification
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Language Data Sections --}}
@php
  function hexToRgb($hex) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "$r, $g, $b";
  }
  
  $languages = [
    [
      'name' => 'English',
      'data' => $easyenglish,
      'color' => '#2196F3',
      'rgb' => hexToRgb('#2196F3'),
      'icon' => 'fa-language'
    ],
    [
      'name' => 'Korean',
      'data' => $easykorean,
      'color' => '#FF9800',
      'rgb' => hexToRgb('#FF9800'),
      'icon' => 'fa-language'
    ],
    [
      'name' => 'Chinese',
      'data' => $easychinese,
      'color' => '#F44336',
      'rgb' => hexToRgb('#F44336'),
      'icon' => 'fa-language'
    ],
    [
      'name' => 'Japanese',
      'data' => $easyjapanese,
      'color' => '#9C27B0',
      'rgb' => hexToRgb('#9C27B0'),
      'icon' => 'fa-language'
    ],
    [
      'name' => 'Russian',
      'data' => $easyrussian,
      'color' => '#4CAF50',
      'rgb' => hexToRgb('#4CAF50'),
      'icon' => 'fa-language'
    ]
  ];
@endphp

@foreach($languages as $lang)
  @if($lang['data'] != null)
  <div class="row mb-4">
    <div class="col-12">
      <div class="card language-data-card" style="border-radius: 12px; overflow: hidden; border-left: 4px solid {{ $lang['color'] }};">
        <div class="card-header" style="background: rgba({{ $lang['rgb'] }}, 0.1); border-bottom: 1px solid rgba({{ $lang['rgb'] }}, 0.2);">
          <h5 class="mb-0" style="color: {{ $lang['color'] }}; font-weight: 600;">
            <i class="fas {{ $lang['icon'] }} me-2"></i>Easy {{ $lang['name'] }} Data
          </h5>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-6 col-lg-3">
              <div class="info-card">
                <div class="info-label">VIP Status</div>
                <div class="info-value">
                  @if($lang['data']->is_vip == 0)
                    <span class="badge badge-non-vip">No</span>
                  @else
                    <span class="badge badge-vip">
                      <i class="fas fa-crown me-1"></i>Yes
                    </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="info-card">
                <div class="info-label">Login Time</div>
                <div class="info-value">{{ number_format($lang['data']->login_time ?? 0) }}</div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="info-card">
                <div class="info-label">Join Date</div>
                <div class="info-value">
                  {{ $lang['data']->first_join ? date('M d, Y', strtotime($lang['data']->first_join)) : 'N/A' }}
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="info-card">
                <div class="info-label">Last Active</div>
                <div class="info-value">
                  {{ $lang['data']->last_active ? date('M d, Y', strtotime($lang['data']->last_active)) : 'N/A' }}
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer" style="background: rgba({{ $lang['rgb'] }}, 0.05); border-top: 1px solid rgba({{ $lang['rgb'] }}, 0.1);">
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('userPerformance', ['phone' => $learner->learner_phone, 'language' => strtolower($lang['name'])]) }}" 
                 class="btn btn-performance" 
                 style="background: {{ $lang['color'] }}; color: white; border: none;">
                <i class="fas fa-chart-line me-2"></i>View Performance
              </a>
              <a href="{{ route('languageVipManagement', ['phone' => $learner->learner_phone, 'language' => strtolower($lang['name'])]) }}" 
                 class="btn btn-vip-activate" 
                 style="background: linear-gradient(45deg, #FFD700 0%, #FFA500 100%); color: #333; border: none;">
                <i class="fas fa-crown me-2"></i>Activate VIP Access
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
@endforeach

@else
{{-- No User Found --}}
<div class="row">
  <div class="col-12">
    <div class="card" style="border-radius: 12px;">
      <div class="card-body text-center py-5">
        <i class="fas fa-user-slash fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
        <h4 class="text-muted mb-0">No user found</h4>
        <p class="text-muted mt-2">The user you're looking for doesn't exist.</p>
      </div>
    </div>
  </div>
</div>
@endif

<style>
.user-profile-avatar {
  flex-shrink: 0;
}

.profile-avatar-img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid rgba(33, 150, 243, 0.2);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

body.dark-theme .profile-avatar-img {
  border-color: rgba(255, 255, 255, 0.2);
}

body.light-theme .profile-avatar-img {
  border-color: rgba(0, 0, 0, 0.1);
}

.btn-action-modern {
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 500;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  border: none;
  background: rgba(33, 150, 243, 0.1);
  color: #2196F3;
}

.btn-action-modern:hover {
  background: rgba(33, 150, 243, 0.2);
  color: #1976D2;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

.btn-vip {
  background: linear-gradient(135deg, rgba(255, 215, 0, 0.2) 0%, rgba(255, 165, 0, 0.2) 100%);
  color: #FF8C00;
}

.btn-vip:hover {
  background: linear-gradient(135deg, rgba(255, 215, 0, 0.3) 0%, rgba(255, 165, 0, 0.3) 100%);
  color: #FF7F00;
  box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
}

body.dark-theme .btn-action-modern {
  background: rgba(33, 150, 243, 0.15);
  color: #64B5F6;
}

body.dark-theme .btn-action-modern:hover {
  background: rgba(33, 150, 243, 0.25);
  color: #90CAF9;
}

body.light-theme .btn-action-modern {
  background: rgba(25, 103, 210, 0.1);
  color: #1967d2;
}

body.light-theme .btn-action-modern:hover {
  background: rgba(25, 103, 210, 0.2);
  color: #1557b0;
}

.language-data-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.language-data-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

body.dark-theme .language-data-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.info-card {
  padding: 16px;
  background: rgba(0, 0, 0, 0.02);
  border-radius: 8px;
  transition: background 0.3s ease;
}

body.dark-theme .info-card {
  background: rgba(255, 255, 255, 0.03);
}

body.light-theme .info-card {
  background: rgba(0, 0, 0, 0.02);
}

.info-card:hover {
  background: rgba(0, 0, 0, 0.05);
}

body.dark-theme .info-card:hover {
  background: rgba(255, 255, 255, 0.05);
}

body.light-theme .info-card:hover {
  background: rgba(0, 0, 0, 0.05);
}

.info-label {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #9e9e9e;
  margin-bottom: 8px;
  font-weight: 500;
}

body.light-theme .info-label {
  color: #5f6368;
}

.info-value {
  font-size: 18px;
  font-weight: 600;
  color: var(--text-primary);
}

.badge-vip {
  background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
  color: #000;
  padding: 6px 12px;
  border-radius: 12px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
}

.badge-non-vip {
  background: rgba(158, 158, 158, 0.2);
  color: #9e9e9e;
  padding: 6px 12px;
  border-radius: 12px;
  font-weight: 500;
}

body.light-theme .badge-non-vip {
  background: rgba(158, 158, 158, 0.15);
  color: #757575;
}

.btn-performance {
  padding: 10px 24px;
  border-radius: 8px;
  font-weight: 500;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.btn-performance:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
  color: white !important;
  filter: brightness(1.1);
}

body.dark-theme .btn-performance {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-theme .btn-performance:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

.btn-vip-activate {
  padding: 10px 24px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
}

.btn-vip-activate:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(255, 215, 0, 0.5);
  color: #333 !important;
  filter: brightness(1.05);
}

body.dark-theme .btn-vip-activate {
  box-shadow: 0 2px 8px rgba(255, 215, 0, 0.4);
}

body.dark-theme .btn-vip-activate:hover {
  box-shadow: 0 4px 16px rgba(255, 215, 0, 0.6);
}

@media (max-width: 768px) {
  .profile-avatar-img {
    width: 100px;
    height: 100px;
  }
  
  .btn-action-modern {
    padding: 8px 16px;
    font-size: 14px;
  }
  
  .btn-performance {
    padding: 8px 20px;
    font-size: 14px;
  }
}
</style>
@endsection
