@extends('layouts.main')

@section('content')

{{-- Course Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header" style="background: linear-gradient(135deg, rgba(156, 39, 176, 0.1) 0%, rgba(156, 39, 176, 0.05) 100%); border-bottom: 1px solid rgba(156, 39, 176, 0.2); padding: 20px 24px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <div class="d-flex align-items-center">
            <a href="{{route('courses.byLanguage', $course->major)}}" class="btn-back btn-sm me-3">
              <i class="fas fa-arrow-left"></i>
              <span>Back</span>
            </a>
            <div>
              <h4 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{$course->title}}</h4>
              <p class="mb-0 text-muted" style="font-size: 14px;">{{$languageName}} Course</p>
            </div>
          </div>
          <div class="d-flex gap-2">
            <a href="{{route('courses.edit', $course->course_id)}}" class="btn btn-primary btn-sm">
              <i class="fas fa-edit me-1"></i>Edit Course
            </a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="row g-0">
          <div class="col-md-4">
            @if($course->cover_url)
            <img src="{{$course->cover_url}}" alt="{{$course->title}}" style="width: 100%; height: 300px; object-fit: cover;">
            @else
            <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); display: flex; align-items: center; justify-content: center;">
              <i class="fas fa-book fa-4x text-white"></i>
            </div>
            @endif
          </div>
          <div class="col-md-8 p-4">
            <div class="mb-3">
              @if($course->is_vip)
              <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                <i class="fas fa-crown me-1"></i>VIP Course
              </span>
              @else
              <span class="badge" style="background: rgba(158, 158, 158, 0.2); color: #9e9e9e; padding: 6px 12px; border-radius: 6px; font-size: 12px;">
                Regular Course
              </span>
              @endif
            </div>
            <p class="text-muted mb-3" style="font-size: 15px; line-height: 1.6;">{{$course->description}}</p>
            @if($course->details)
            <div class="mb-3">
              <h6 style="font-weight: 600; margin-bottom: 8px;">Course Details:</h6>
              <div style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">
                {!! nl2br(e($course->details)) !!}
              </div>
            </div>
            @endif
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="fas fa-user-tie me-2" style="color: #9c27b0; width: 20px;"></i>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Teacher</small>
                    <strong style="font-size: 14px;">{{$teacher->name ?? 'N/A'}}</strong>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="fas fa-clock me-2" style="color: #9c27b0; width: 20px;"></i>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Duration</small>
                    <strong style="font-size: 14px;">{{$course->duration}} days</strong>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="fas fa-dollar-sign me-2" style="color: #9c27b0; width: 20px;"></i>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Fee</small>
                    <strong style="font-size: 14px;">${{number_format($course->fee)}}</strong>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="fas fa-certificate me-2" style="color: #9c27b0; width: 20px;"></i>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Certificate</small>
                    <strong style="font-size: 14px;">{{$course->certificate_title}}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Statistics Cards --}}
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #9c27b0;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Lessons</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($total_lessons)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(156, 39, 176, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-book fa-2x" style="color: #9c27b0;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #4caf50;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Video Lessons</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($video_lessons)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(76, 175, 80, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-video fa-2x" style="color: #4caf50;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #2196F3;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Enrollments</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($enrollment_count)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(33, 150, 243, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-users fa-2x" style="color: #2196F3;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #ff9800;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Rating</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($course->rating, 1)}} <small style="font-size: 14px; color: #ff9800;"><i class="fas fa-star"></i></small></h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(255, 152, 0, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-star fa-2x" style="color: #ff9800;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Daily Plan Section --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mb-0" style="font-weight: 600;">
            <i class="fas fa-calendar-alt me-2"></i>Daily Study Plan
          </h5>
          <a href="{{route('courses.studyplan.manage', $course->course_id)}}" class="btn btn-sm" style="background: #9c27b0; color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 12px;">
            <i class="fas fa-cog me-1"></i>Manage Plan
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(count($dailyPlan) > 0)
        <div class="daily-plan-container">
          @foreach($dailyPlan as $day => $dayLessons)
          <div class="daily-plan-day mb-3" style="border-left: 3px solid #9c27b0; padding-left: 16px; padding-bottom: 12px;">
            <div class="d-flex align-items-center mb-2">
              <div class="day-badge" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; margin-right: 12px; flex-shrink: 0;">
                {{$day}}
              </div>
              <div>
                <h6 class="mb-0" style="font-weight: 600; font-size: 14px;">Day {{$day}}</h6>
                <small class="text-muted" style="font-size: 11px;">{{count($dayLessons)}} {{count($dayLessons) == 1 ? 'lesson' : 'lessons'}}</small>
              </div>
            </div>
            <div class="lessons-list" style="margin-left: 48px;">
              @foreach($dayLessons as $item)
              @php
                $lesson = $item['lesson'];
                $category = $item['category'];
                if($lesson->isVideo == 1){
                  $viewLesson = route('viewVideoLesson', $lesson->id);
                } else {
                  $viewLesson = route('viewBlogLesson', $lesson->id);
                }
              @endphp
              <div class="lesson-item-card mb-2" style="background: var(--bg-secondary); border-radius: 6px; padding: 8px 12px; border: 1px solid rgba(0, 0, 0, 0.1); transition: all 0.2s ease;">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="flex-grow-1" style="min-width: 0;">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <h6 class="mb-0" style="font-weight: 500; color: var(--text-primary); font-size: 13px; line-height: 1.4;">{{$lesson->title}}</h6>
                      <div class="d-flex gap-1 align-items-center">
                        @if($lesson->isVip == 1)
                        <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; padding: 1px 4px; border-radius: 3px; font-size: 9px; line-height: 1.2;">
                          <i class="fas fa-crown"></i>
                        </span>
                        @endif
                        @if($lesson->isVideo == 1)
                        <span class="badge" style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 1px 4px; border-radius: 3px; font-size: 9px; line-height: 1.2;">
                          <i class="fas fa-video"></i>
                        </span>
                        @endif
                        @if($lesson->duration > 0)
                        <small class="text-muted" style="font-size: 10px;">
                          <i class="fas fa-clock"></i> {{\App\Services\VimeoService::formatDuration($lesson->duration)}}
                        </small>
                        @endif
                      </div>
                    </div>
                    @if($category)
                    <small class="text-muted" style="font-size: 10px; display: block; margin-top: 2px;">
                      <i class="fas fa-folder" style="font-size: 9px;"></i> {{$category->category_title}}
                    </small>
                    @endif
                  </div>
                  <div class="ms-2 flex-shrink-0">
                    <a href="{{$viewLesson}}" class="btn btn-sm" style="background: #9c27b0; color: white; border: none; border-radius: 4px; padding: 4px 8px; font-size: 11px; line-height: 1.2;" target="_blank">
                      <i class="fas fa-external-link-alt" style="font-size: 9px;"></i>
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-5">
          <div class="empty-state-icon mb-3" style="font-size: 64px; color: #9e9e9e; opacity: 0.5;">
            <i class="fas fa-calendar-times"></i>
          </div>
          <h5 class="text-muted mb-2">No Daily Plan Available</h5>
          <p class="text-muted">This course doesn't have a daily study plan configured yet.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
.stats-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.stats-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

body.dark-theme .stats-card {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-theme .stats-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
}

.lesson-item-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  background: var(--bg-secondary) !important;
}

body.dark-theme .lesson-item-card {
  border-color: rgba(255, 255, 255, 0.1) !important;
}

body.dark-theme .lesson-item-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
</style>

@endsection
