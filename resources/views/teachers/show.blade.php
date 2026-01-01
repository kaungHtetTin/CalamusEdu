@extends('layouts.navbar')

@section('content')

<div class="teacher-detail-page">
  <!-- Hero Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card teacher-hero-card">
        <div class="card-body teacher-hero-body">
          <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="teacher-profile-avatar">
              @if($teacher->profile)
                <img src="{{asset($teacher->profile)}}" 
                     alt="{{$teacher->name}}"
                     class="teacher-avatar-img"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'160\' height=\'160\'%3E%3Ccircle cx=\'80\' cy=\'80\' r=\'80\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'64\' font-weight=\'600\'%3E{{ substr($teacher->name, 0, 1) }}%3C/text%3E%3C/svg%3E'">
              @else
                <img src="{{asset('public/img/placeholder.png')}}" 
                     alt="{{$teacher->name}}"
                     class="teacher-avatar-img"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'160\' height=\'160\'%3E%3Ccircle cx=\'80\' cy=\'80\' r=\'80\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'64\' font-weight=\'600\'%3E{{ substr($teacher->name, 0, 1) }}%3C/text%3E%3C/svg%3E'">
              @endif
            </div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                <div>
                  <h1 class="teacher-name mb-2">{{$teacher->name}}</h1>
                  <div class="teacher-rank-badge">
                    <i class="fas fa-graduation-cap me-2"></i>
                    <span>{{$teacher->rank}}</span>
                  </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                  <a href="{{route('teachers.edit', $teacher->id)}}" class="btn-teacher-action btn-teacher-edit">
                    <i class="fas fa-edit me-2"></i>Edit
                  </a>
                  <a href="{{route('teachers.index')}}" class="btn-teacher-action btn-teacher-back">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                  </a>
                </div>
              </div>
              
              <!-- Quick Stats -->
              <div class="teacher-quick-stats">
                <div class="stat-item">
                  <div class="stat-icon courses-icon">
                    <i class="fas fa-book"></i>
                  </div>
                  <div class="stat-content">
                    <div class="stat-value">{{$teacher->total_course}}</div>
                    <div class="stat-label">Total Courses</div>
                  </div>
                </div>
                <div class="stat-item">
                  <div class="stat-icon id-icon">
                    <i class="fas fa-id-card"></i>
                  </div>
                  <div class="stat-content">
                    <div class="stat-value">#{{$teacher->id}}</div>
                    <div class="stat-label">Teacher ID</div>
                  </div>
                </div>
              </div>
              
              <!-- Social Media Links -->
              @if($teacher->facebook || $teacher->telegram || $teacher->youtube)
              <div class="teacher-social-links mt-3">
                @if($teacher->facebook)
                <a href="{{$teacher->facebook}}" target="_blank" class="social-link social-facebook" title="Facebook">
                  <i class="fab fa-facebook-f"></i>
                </a>
                @endif
                @if($teacher->telegram)
                <a href="{{$teacher->telegram}}" target="_blank" class="social-link social-telegram" title="Telegram">
                  <i class="fab fa-telegram-plane"></i>
                </a>
                @endif
                @if($teacher->youtube)
                <a href="{{$teacher->youtube}}" target="_blank" class="social-link social-youtube" title="YouTube">
                  <i class="fab fa-youtube"></i>
                </a>
                @endif
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Information Cards -->
  <div class="row">
    @if($teacher->description)
    <div class="col-xl-6 col-md-12 mb-4">
      <div class="card teacher-info-card">
        <div class="card-header teacher-info-header">
          <i class="fas fa-info-circle me-2"></i>
          <span>Description</span>
        </div>
        <div class="card-body">
          <p class="teacher-info-text">{{$teacher->description}}</p>
        </div>
      </div>
    </div>
    @endif

    @if($teacher->qualification)
    <div class="col-xl-6 col-md-12 mb-4">
      <div class="card teacher-info-card">
        <div class="card-header teacher-info-header">
          <i class="fas fa-certificate me-2"></i>
          <span>Qualification</span>
        </div>
        <div class="card-body">
          <p class="teacher-info-text">{{$teacher->qualification}}</p>
        </div>
      </div>
    </div>
    @endif

    @if($teacher->experience)
    <div class="col-xl-12 col-md-12 mb-4">
      <div class="card teacher-info-card">
        <div class="card-header teacher-info-header">
          <i class="fas fa-briefcase me-2"></i>
          <span>Experience</span>
        </div>
        <div class="card-body">
          <p class="teacher-info-text">{{$teacher->experience}}</p>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>

@endsection
