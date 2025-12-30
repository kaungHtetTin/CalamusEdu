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
  
  // Convert hex to RGB for rgba backgrounds
  function hexToRgb($hex) {
      list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
      return "$r, $g, $b";
  }
  $primaryRgb = hexToRgb($colors['primary']);
@endphp

<div class="row mb-4">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h2 class="mb-1" style="font-weight: 600; color: var(--text-primary);">
          <a href="{{ route('detail', ['phone' => $learner->learner_phone]) }}" class="text-decoration-none" style="color: inherit;">
            <i class="fas fa-arrow-left me-2"></i>
          </a>
          VIP Access Management - {{ $language }}
        </h2>
        <p class="mb-0 text-muted">Manage VIP access and course permissions for {{ $learner->learner_name }}</p>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

{{-- User Info (Compact) --}}
<div class="row mb-3">
  <div class="col-12">
    <div class="d-flex align-items-center justify-content-between p-3" style="background: var(--card-bg); border-radius: 12px; border: 1px solid var(--border-color);">
      <div class="d-flex align-items-center gap-3">
        <img src="{{ $learner->learner_image ?? '' }}" 
             alt="{{ $learner->learner_name }}"
             style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $colors['primary'] }};"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{ substr($learner->learner_name ?? 'U', 0, 1) }}%3C/text%3E%3C/svg%3E'">
        <div>
          <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">{{ $learner->learner_name }}</h5>
          <small class="text-muted">{{ $learner->learner_phone }}</small>
        </div>
      </div>
      <span class="badge" style="background: {{ $userData->is_vip == 1 ? 'linear-gradient(45deg, #FFD700 0%, #FFA500 100%)' : 'var(--badge-bg-secondary)' }}; color: {{ $userData->is_vip == 1 ? '#333' : 'var(--text-muted)' }}; padding: 6px 14px; border-radius: 8px; font-weight: 600;">
        <i class="fas fa-crown me-1"></i>{{ $userData->is_vip == 1 ? 'VIP Active' : 'Not VIP' }}
      </span>
    </div>
  </div>
</div>

{{-- VIP Management Form (Clean Layout) --}}
<div class="row">
  <div class="col-12">
    <div class="card" style="border-radius: 12px; border: 1px solid var(--border-color);">
      <div class="card-body p-4">
        <form action="{{ route('updateLanguageVip', ['phone' => $learner->learner_phone, 'language' => $languageCode]) }}" method="POST">
          @csrf
          
          {{-- General Settings --}}
          <div class="mb-4">
            <h6 class="mb-3" style="color: var(--text-primary); font-weight: 600; font-size: 16px;">
              <i class="fas fa-cog me-2" style="color: {{ $colors['primary'] }};"></i>General Settings
            </h6>
            
            {{-- VIP Access --}}
            <div class="d-flex align-items-center justify-content-between p-3 mb-2" style="background: var(--input-bg); border-radius: 8px; border: 1px solid var(--border-color);">
              <div class="d-flex align-items-center gap-3">
                <i class="fas fa-crown" style="color: #FFD700; font-size: 20px;"></i>
                <div>
                  <label for="vipToggle" class="mb-0" style="font-weight: 600; color: var(--text-primary); cursor: pointer;">VIP Access</label>
                  <div class="text-muted" style="font-size: 12px;">Grant full VIP access to premium content</div>
                </div>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" 
                       type="checkbox" 
                       name="{{ $vipField }}" 
                       id="vipToggle"
                       {{ $userData->is_vip == 1 ? 'checked' : '' }}>
              </div>
            </div>
            
            {{-- Gold Plan --}}
            @if(isset($userData->gold_plan))
            <div class="d-flex align-items-center justify-content-between p-3" style="background: var(--input-bg); border-radius: 8px; border: 1px solid var(--border-color);">
              <div class="d-flex align-items-center gap-3">
                <i class="fas fa-star" style="color: #FFD700; font-size: 20px;"></i>
                <div>
                  <label for="goldPlanToggle" class="mb-0" style="font-weight: 600; color: var(--text-primary); cursor: pointer;">Gold Plan</label>
                  <div class="text-muted" style="font-size: 12px;">Enhanced learning features</div>
                </div>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" 
                       type="checkbox" 
                       name="gold_plan" 
                       id="goldPlanToggle"
                       {{ $userData->gold_plan == 1 ? 'checked' : '' }}>
              </div>
            </div>
            @endif
          </div>
          
          <hr class="my-4">
          
          {{-- Course Selection --}}
          <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h6 class="mb-0" style="color: var(--text-primary); font-weight: 600; font-size: 16px;">
                <i class="fas fa-book me-2" style="color: {{ $colors['primary'] }};"></i>Course Selection
              </h6>
              <span class="badge" style="background: rgba({{ $primaryRgb }}, 0.1); color: {{ $colors['primary'] }}; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                {{ $courses->count() }} courses
              </span>
            </div>
            
            @if($courses->count() > 0)
              <div class="row g-2">
                @foreach($courses as $course)
                  <div class="col-md-6 col-lg-4">
                    <div class="course-item" style="background: {{ in_array($course->course_id, $vipCourses) ? 'rgba(' . $primaryRgb . ', 0.08)' : 'var(--input-bg)' }}; border: 1px solid {{ in_array($course->course_id, $vipCourses) ? $colors['primary'] : 'var(--border-color)' }}; border-radius: 8px; padding: 12px; transition: all 0.2s ease;">
                      <div class="form-check d-flex align-items-center">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="{{ $course->course_id }}" 
                               id="course_{{ $course->course_id }}"
                               {{ in_array($course->course_id, $vipCourses) ? 'checked' : '' }}
                               style="width: 20px; height: 20px; cursor: pointer; margin-top: 0;">
                        <label class="form-check-label ms-2 flex-grow-1" for="course_{{ $course->course_id }}" style="cursor: pointer; font-weight: 500; color: var(--text-primary); margin: 0;">
                          {{ $course->title }}
                          @if($course->is_vip == 1)
                            <span class="badge ms-2" style="background: linear-gradient(45deg, #FFD700 0%, #FFA500 100%); color: #333; padding: 2px 6px; border-radius: 4px; font-size: 9px; font-weight: 700;">
                              <i class="fas fa-crown"></i> VIP
                            </span>
                          @endif
                        </label>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="text-center p-4" style="background: var(--input-bg); border-radius: 8px; border: 1px dashed var(--border-color);">
                <i class="fas fa-book-open text-muted mb-2" style="font-size: 32px; opacity: 0.5;"></i>
                <p class="text-muted mb-0" style="font-size: 14px;">No courses available for {{ $language }}</p>
              </div>
            @endif
          </div>
          
          <hr class="my-4">
          
          {{-- Payment --}}
          <div class="mb-4">
            <h6 class="mb-3" style="color: var(--text-primary); font-weight: 600; font-size: 16px;">
              <i class="fas fa-dollar-sign me-2" style="color: {{ $colors['primary'] }};"></i>Payment (Optional)
            </h6>
            <div style="max-width: 250px;">
              <input type="number" 
                     class="form-control" 
                     id="amount" 
                     name="amount" 
                     placeholder="0.00"
                     min="0"
                     step="0.01"
                     style="border-radius: 8px; border: 1px solid var(--border-color);">
            </div>
          </div>
          
          {{-- Actions --}}
          <div class="d-flex justify-content-end gap-2 pt-3" style="border-top: 1px solid var(--border-color);">
            <a href="{{ route('detail', ['phone' => $learner->learner_phone]) }}" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 24px; font-weight: 500;">
              Cancel
            </a>
            <button type="submit" class="btn btn-primary" style="background: {{ $colors['primary'] }}; border: none; border-radius: 8px; padding: 10px 24px; font-weight: 600;">
              <i class="fas fa-save me-2"></i>Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.course-item:hover {
  background: rgba({{ $primaryRgb }}, 0.05) !important;
  border-color: {{ $colors['primary'] }} !important;
}

.course-item input[type="checkbox"]:checked {
  background-color: {{ $colors['primary'] }};
  border-color: {{ $colors['primary'] }};
}

.form-check-input:checked {
  background-color: {{ $colors['primary'] }};
  border-color: {{ $colors['primary'] }};
}

.form-check-input:focus {
  box-shadow: 0 0 0 3px rgba({{ $primaryRgb }}, 0.25);
  border-color: {{ $colors['primary'] }};
}

@media (max-width: 768px) {
  .course-item {
    margin-bottom: 8px;
  }
}
</style>
@endsection

