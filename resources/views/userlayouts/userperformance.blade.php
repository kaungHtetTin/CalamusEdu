@extends('layouts.main')

@section('content')
@php
  // Language color mapping
  $languageColors = [
    'english' => ['primary' => '#2196F3', 'secondary' => '#1976D2'],
    'korean' => ['primary' => '#FF9800', 'secondary' => '#F57C00'],
    'chinese' => ['primary' => '#F44336', 'secondary' => '#D32F2F'],
    'japanese' => ['primary' => '#9C27B0', 'secondary' => '#7B1FA2'],
    'russian' => ['primary' => '#4CAF50', 'secondary' => '#388E3C'],
  ];
  $colors = $languageColors[strtolower($languageCode)] ?? $languageColors['english'];
@endphp

<div class="row mb-4">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h2 class="mb-1" style="font-weight: 600; color: var(--text-primary);">
          <a href="{{ route('detail', ['phone' => $learner->learner_phone]) }}" class="text-decoration-none" style="color: inherit;">
            <i class="fas fa-arrow-left me-2"></i>
          </a>
          {{ $learner->learner_name }} - {{ $language }} Performance
        </h2>
        <p class="mb-0 text-muted">Study progress and course analytics for Easy {{ $language }}</p>
      </div>
    </div>
  </div>
</div>

@if(count($courseProgress) > 0)
  <div class="row">
    @foreach($courseProgress as $item)
      <div class="col-12 mb-4">
        <div class="card course-progress-card" style="border-radius: 12px; border-left: 4px solid {{ $colors['primary'] }};">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <h4 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                    {{ $item['course']->title }}
                  </h4>
                  @if($item['course']->is_vip == 1)
                    <span class="badge badge-vip">
                      <i class="fas fa-crown me-1"></i>VIP
                    </span>
                  @endif
                  @if($item['enrolled'])
                    <span class="badge" style="background: {{ $colors['primary'] }}; color: white;">
                      <i class="fas fa-check-circle me-1"></i>Enrolled
                    </span>
                  @else
                    <span class="badge badge-secondary">
                      <i class="fas fa-times-circle me-1"></i>Not Enrolled
                    </span>
                  @endif
                </div>
                @if($item['course']->description)
                  <p class="text-muted mb-2" style="font-size: 14px;">
                    {{ Str::limit($item['course']->description, 150) }}
                  </p>
                @endif
                <div class="d-flex align-items-center gap-4 flex-wrap">
                  <div class="course-stat-item">
                    <i class="fas fa-book me-2" style="color: {{ $colors['primary'] }};"></i>
                    <span class="text-muted">Total Lessons:</span>
                    <strong style="color: var(--text-primary);">{{ $item['totalLessons'] }}</strong>
                  </div>
                  <div class="course-stat-item">
                    <i class="fas fa-check-circle me-2" style="color: #4CAF50;"></i>
                    <span class="text-muted">Completed:</span>
                    <strong style="color: var(--text-primary);">{{ $item['completedLessons'] }}</strong>
                  </div>
                  @if($item['enrolled'] && $item['enrollment'])
                    <div class="course-stat-item">
                      <i class="fas fa-calendar me-2" style="color: {{ $colors['primary'] }};"></i>
                      <span class="text-muted">Enrolled:</span>
                      <strong style="color: var(--text-primary);">
                        {{ date('M d, Y', strtotime($item['enrollment']->start_date)) }}
                      </strong>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            
            <div class="progress-section">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="progress-label" style="color: var(--text-secondary); font-weight: 500;">
                  Progress
                </span>
                <span class="progress-percentage" style="color: {{ $colors['primary'] }}; font-weight: 600; font-size: 18px;">
                  {{ number_format($item['progress'], 1) }}%
                </span>
              </div>
              <div class="progress" style="height: 12px; border-radius: 6px; background: var(--input-bg); overflow: hidden;">
                <div class="progress-bar" 
                     role="progressbar" 
                     style="width: {{ $item['progress'] }}%; background: linear-gradient(90deg, {{ $colors['primary'] }} 0%, {{ $colors['secondary'] }} 100%); border-radius: 6px; transition: width 0.6s ease;"
                     aria-valuenow="{{ $item['progress'] }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <small class="text-muted">
                  {{ $item['completedLessons'] }} of {{ $item['totalLessons'] }} lessons completed
                </small>
                @if($item['totalLessons'] > 0)
                  <small class="text-muted">
                    {{ $item['totalLessons'] - $item['completedLessons'] }} lessons remaining
                  </small>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  <div class="row">
    <div class="col-12">
      <div class="card" style="border-radius: 12px;">
        <div class="card-body text-center py-5">
          <i class="fas fa-book-open fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
          <h4 class="text-muted mb-2">No Courses Available</h4>
          <p class="text-muted">There are no courses available for {{ $language }} at the moment.</p>
          <a href="{{ route('detail', ['phone' => $learner->learner_phone]) }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left me-2"></i>Back to User Details
          </a>
        </div>
      </div>
    </div>
  </div>
@endif

<style>
.course-progress-card {
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  box-shadow: var(--card-shadow);
  transition: all 0.3s ease;
}

.course-progress-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

body.dark-theme .course-progress-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.course-stat-item {
  display: flex;
  align-items: center;
  font-size: 14px;
}

.progress-section {
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
}

.progress-label {
  font-size: 14px;
}

.progress-percentage {
  font-size: 18px;
  font-weight: 600;
}

.badge-vip {
  background: linear-gradient(45deg, #FFD700 0%, #FFA500 100%);
  color: #333;
  font-weight: 600;
  padding: 5px 10px;
  border-radius: 50px;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

@media (max-width: 768px) {
  .course-stat-item {
    font-size: 12px;
  }
  
  .course-progress-card .card-body h4 {
    font-size: 18px;
  }
}
</style>
@endsection
