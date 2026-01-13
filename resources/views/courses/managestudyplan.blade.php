@extends('layouts.main')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header" style="background: linear-gradient(135deg, rgba(156, 39, 176, 0.1) 0%, rgba(156, 39, 176, 0.05) 100%); border-bottom: 1px solid rgba(156, 39, 176, 0.2); padding: 20px 24px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <div class="d-flex align-items-center">
            <a href="{{route('courses.show', $course->course_id)}}" class="btn-back btn-sm me-3">
              <i class="fas fa-arrow-left"></i>
              <span>Back</span>
            </a>
            <div>
              <h4 class="mb-0" style="font-weight: 600; color: var(--text-primary);">Manage Daily Study Plan</h4>
              <p class="mb-0 text-muted" style="font-size: 14px;">{{$course->title}} - {{$languageName}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  {{-- Current Study Plan --}}
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">
          <i class="fas fa-calendar-alt me-2"></i>Current Study Plan
        </h5>
      </div>
      <div class="card-body">
        @if(count($dailyPlan) > 0)
        <div class="study-plan-list">
          @foreach($dailyPlan as $day => $dayLessons)
          <div class="study-plan-day mb-3" style="border-left: 3px solid #9c27b0; padding-left: 16px; padding-bottom: 12px;">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center">
                <div class="day-badge" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; margin-right: 12px; flex-shrink: 0;">
                  {{$day}}
                </div>
                <div>
                  <h6 class="mb-0" style="font-weight: 600; font-size: 14px;">Day {{$day}}</h6>
                  <small class="text-muted" style="font-size: 11px;">{{count($dayLessons)}} {{count($dayLessons) == 1 ? 'lesson' : 'lessons'}}</small>
                </div>
              </div>
            </div>
            <div class="lessons-list" style="margin-left: 48px;">
              @foreach($dayLessons as $plan)
              <div class="lesson-item-manage mb-2" style="background: var(--bg-secondary); border-radius: 6px; padding: 8px 12px; border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="flex-grow-1" style="min-width: 0;">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <span style="font-weight: 500; color: var(--text-primary); font-size: 13px; line-height: 1.4;">{{$plan->title}}</span>
                      <div class="d-flex gap-1 align-items-center">
                        @if($plan->isVip == 1)
                        <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; padding: 1px 4px; border-radius: 3px; font-size: 9px;">
                          <i class="fas fa-crown"></i>
                        </span>
                        @endif
                        @if($plan->isVideo == 1)
                        <span class="badge" style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 1px 4px; border-radius: 3px; font-size: 9px;">
                          <i class="fas fa-video"></i>
                        </span>
                        @endif
                        @if($plan->duration > 0)
                        <small class="text-muted" style="font-size: 10px;">
                          <i class="fas fa-clock"></i> {{$plan->duration}}m
                        </small>
                        @endif
                      </div>
                    </div>
                    <small class="text-muted" style="font-size: 10px; display: block; margin-top: 2px;">
                      <i class="fas fa-folder" style="font-size: 9px;"></i> {{$plan->category_title}}
                    </small>
                  </div>
                  <div class="ms-2 d-flex gap-2 align-items-center">
                    <form action="{{route('courses.studyplan.updateDay', $course->course_id)}}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="plan_id" value="{{$plan->plan_id}}">
                      <select name="day" class="form-select form-select-sm" style="width: auto; font-size: 11px; padding: 2px 6px; border-radius: 6px;" onchange="this.form.submit()">
                        @for($d = 1; $d <= 100; $d++)
                        <option value="{{$d}}" {{$d == $day ? 'selected' : ''}}>Day {{$d}}</option>
                        @endfor
                      </select>
                    </form>
                    <form action="{{route('courses.studyplan.remove', $course->course_id)}}" method="POST" class="d-inline" onsubmit="return confirm('Remove this lesson from study plan?');">
                      @csrf
                      <input type="hidden" name="plan_id" value="{{$plan->plan_id}}">
                      <button type="submit" class="btn-action-danger" title="Remove from study plan">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-4">
          <div class="empty-state-icon mb-3" style="font-size: 48px; color: #9e9e9e; opacity: 0.5;">
            <i class="fas fa-calendar-times"></i>
          </div>
          <h6 class="text-muted mb-2">No Study Plan Configured</h6>
          <p class="text-muted" style="font-size: 13px;">Add lessons from the available lessons list to create a study plan.</p>
        </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Available Lessons --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(76, 175, 80, 0.05); border-bottom: 1px solid rgba(76, 175, 80, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">
          <i class="fas fa-plus-circle me-2"></i>Add Lessons
        </h5>
      </div>
      <div class="card-body" style="max-height: 600px; overflow-y: auto;">
        @if($availableLessons->count() > 0)
        <div class="available-lessons-list">
          @foreach($categories as $category)
            @php
              $categoryLessons = $availableLessons->where('category_id', $category->id);
            @endphp
            @if($categoryLessons->count() > 0)
            <div class="category-group mb-3">
              <h6 class="mb-2" style="font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fas fa-folder me-1"></i>{{$category->category_title}}
              </h6>
              @foreach($categoryLessons as $lesson)
              <div class="available-lesson-item mb-2" style="background: var(--bg-secondary); border-radius: 6px; padding: 8px 12px; border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="flex-grow-1" style="min-width: 0;">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <span style="font-weight: 500; color: var(--text-primary); font-size: 12px; line-height: 1.4;">{{$lesson->title}}</span>
                      <div class="d-flex gap-1 align-items-center">
                        @if($lesson->isVip == 1)
                        <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; padding: 1px 4px; border-radius: 3px; font-size: 9px;">
                          <i class="fas fa-crown"></i>
                        </span>
                        @endif
                        @if($lesson->isVideo == 1)
                        <span class="badge" style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 1px 4px; border-radius: 3px; font-size: 9px;">
                          <i class="fas fa-video"></i>
                        </span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="ms-2">
                    <form action="{{route('courses.studyplan.add', $course->course_id)}}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                      <div class="d-flex align-items-center gap-2">
                        <input type="number" name="day" class="form-control form-control-sm" placeholder="Day" min="1" max="100" required style="width: 70px; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                        <button type="submit" class="btn-action-primary" title="Add to study plan">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif
          @endforeach
        </div>
        @else
        <div class="text-center py-4">
          <div class="empty-state-icon mb-3" style="font-size: 48px; color: #9e9e9e; opacity: 0.5;">
            <i class="fas fa-check-circle"></i>
          </div>
          <h6 class="text-muted mb-2">All Lessons Added</h6>
          <p class="text-muted" style="font-size: 13px;">All available lessons have been added to the study plan.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
.lesson-item-manage:hover {
  background: var(--bg-secondary) !important;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.available-lesson-item:hover {
  background: var(--bg-secondary) !important;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

body.dark-theme .lesson-item-manage,
body.dark-theme .available-lesson-item {
  border-color: rgba(255, 255, 255, 0.1) !important;
}
</style>

@endsection
