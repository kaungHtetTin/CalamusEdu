@extends('layouts.main')

@section('content')
@if ($learner != null)
{{-- User Profile Header - Vimeo Style --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card user-profile-card">
      <div class="user-profile-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
          <div class="d-flex align-items-center gap-3">
            <div class="user-profile-avatar">
              <img src="{{ $learner->learner_image ?? '' }}" 
                   alt="{{ $learner->learner_name }}"
                   class="profile-avatar-img"
                   onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\'%3E%3Ccircle cx=\'40\' cy=\'40\' r=\'40\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'32\' font-weight=\'600\'%3E{{ substr($learner->learner_name ?? 'U', 0, 1) }}%3C/text%3E%3C/svg%3E'">
            </div>
            <div>
              <h2 class="user-profile-name mb-2">
                {{ $learner->learner_name }}
              </h2>
              <div class="d-flex flex-column gap-1">
                <div class="d-flex align-items-center gap-2 user-info-item">
                  <i class="fas fa-phone user-info-icon"></i>
                  <span class="user-info-text">{{ $learner->learner_phone }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 user-info-item">
                  <i class="fas fa-envelope user-info-icon"></i>
                  <span class="user-info-text">{{ $learner->learner_email ?: 'N/A' }}</span>
                </div>
                @if($learner->region)
                <div class="d-flex align-items-center gap-2 user-info-item">
                  <i class="fas fa-map-marker-alt user-info-icon"></i>
                  <span class="user-info-text">{{ $learner->region }}</span>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('showPasswordReset', $learner->learner_phone) }}" class="btn-secondary btn-sm">
              <i class="fas fa-key"></i>
              <span>Password Reset</span>
            </a>
            <a href="{{ route('showSendEmail', $learner->id) }}" class="btn-secondary btn-sm">
              <i class="fas fa-envelope"></i>
              <span>Send Email</span>
            </a>
            <a href="{{ route('showPushNotification', $learner->id) }}" class="btn-secondary btn-sm">
              <i class="fas fa-bell"></i>
              <span>Send Notification</span>
            </a>
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
  <div class="row mb-3">
    <div class="col-12">
      <div class="card language-data-card">
        <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid {{ $lang['color'] }};">
          <h5 class="language-data-title mb-0" style="color: {{ $lang['color'] }};">
            <i class="fas {{ $lang['icon'] }} me-2"></i>Easy {{ $lang['name'] }} Data
          </h5>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('userPerformance', ['phone' => $learner->learner_phone, 'language' => strtolower($lang['name'])]) }}" 
               class="btn-secondary btn-sm" title="View Performance">
              <i class="fas fa-chart-line"></i>
              <span>View Performance</span>
            </a>
            <a href="{{ route('languageVipManagement', ['phone' => $learner->learner_phone, 'language' => strtolower($lang['name'])]) }}" 
               class="btn-warning btn-sm" title="Manage VIP">
              <i class="fas fa-crown"></i>
              <span>Manage VIP</span>
            </a>
          </div>
        </div>
        <div class="language-data-body">
          <div class="row g-3">
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
        </div>
      </div>
    </div>
  </div>
  @endif
@endforeach

@else
{{-- No User Found - Vimeo Style --}}
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body text-center py-5">
        <i class="fas fa-user-slash fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
        <h4 class="text-muted mb-0">No user found</h4>
        <p class="text-muted mt-2">The user you're looking for doesn't exist.</p>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
