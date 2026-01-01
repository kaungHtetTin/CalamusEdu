@extends('layouts.main')

@section('content')

{{-- Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="card" style="border-radius: 12px; overflow: hidden;">
      <div class="card-header" style="background: linear-gradient(135deg, rgba(156, 39, 176, 0.1) 0%, rgba(156, 39, 176, 0.05) 100%); border-bottom: 1px solid rgba(156, 39, 176, 0.2); padding: 20px 24px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
          <div class="d-flex align-items-center">
            <div class="header-icon-wrapper" style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); display: flex; align-items: center; justify-content: center; margin-right: 16px; color: white; font-size: 20px;">
              <i class="fas fa-book"></i>
            </div>
            <div>
              <h5 class="mb-0" style="font-weight: 600;">{{$languageName}} Courses</h5>
              <p class="mb-0 text-muted" style="font-size: 14px;">Manage and view courses for {{$languageName}}</p>
            </div>
          </div>
          <div class="d-flex gap-2">
            <a href="{{route('lessons.addCourse', $language)}}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus me-2"></i>Create New Course
            </a>
            <a href="{{route('showCoursesMain')}}" class="btn btn-sm btn-neutral">
              <i class="fas fa-arrow-left me-2"></i>Back to Courses
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Statistics Cards --}}
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #9c27b0;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Courses</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($total_courses)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(156, 39, 176, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-book fa-2x" style="color: #9c27b0;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #4caf50;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Enrollments</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($total_enrollments)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(76, 175, 80, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-users fa-2x" style="color: #4caf50;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #ff9800;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">VIP Courses</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($vip_courses)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(255, 152, 0, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-crown fa-2x" style="color: #ff9800;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card stats-card" style="border-radius: 12px; border-left: 4px solid #2196F3;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Average Rating</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{$avg_rating}} <small style="font-size: 14px; color: #ff9800;"><i class="fas fa-star"></i></small></h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(33, 150, 243, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-star fa-2x" style="color: #2196F3;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Courses List --}}
<div class="row">
  <div class="col-12">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Courses List</h5>
      </div>
      <div class="card-body">
        @if($courses->count() > 0)
        <div class="row">
          @foreach($courses as $course)
          <div class="col-xl-4 col-md-6 mb-4">
            <div class="course-item-card" style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid rgba(0, 0, 0, 0.1); transition: all 0.3s ease; height: 100%;">
              {{-- Circular Edit Button --}}
              <a href="{{route('courses.edit', $course->course_id)}}" class="course-edit-btn" title="Edit Course">
                <i class="fas fa-edit"></i>
              </a>
              
              <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                  @if($course->cover_url)
                  <img src="{{$course->cover_url}}" alt="{{$course->title}}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 16px;">
                  @else
                  <div style="width: 80px; height: 80px; border-radius: 8px; background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%); display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-book fa-2x text-white"></i>
                  </div>
                  @endif
                  <div class="flex-grow-1">
                    <h6 class="mb-2" style="font-weight: 600; color: var(--text-primary);">{{$course->title}}</h6>
                    @if($course->is_vip)
                    <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                      <i class="fas fa-crown me-1"></i>VIP
                    </span>
                    @else
                    <span class="badge" style="background: rgba(158, 158, 158, 0.2); color: #9e9e9e; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                      Regular
                    </span>
                    @endif
                  </div>
                </div>
                
                <p class="text-muted mb-3" style="font-size: 14px; line-height: 1.5;">
                  {{Str::limit($course->description, 100)}}
                </p>
                
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <small class="text-muted d-block" style="font-size: 12px;">
                      <i class="fas fa-graduation-cap me-1"></i>{{$course->lessons_count}} Lessons
                    </small>
                    <small class="text-muted d-block mt-1" style="font-size: 12px;">
                      <i class="fas fa-users me-1"></i>{{number_format($course->enrollment_count)}} Enrollments
                    </small>
                  </div>
                  <div class="text-end">
                    <div style="font-weight: 600; color: #ff9800;">
                      <i class="fas fa-star"></i> {{number_format($course->rating, 1)}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-5">
          <div class="empty-state-icon mb-3" style="font-size: 64px; color: #9e9e9e; opacity: 0.5;">
            <i class="fas fa-book-open"></i>
          </div>
          <h5 class="text-muted mb-2">No courses found</h5>
          <p class="text-muted">There are no courses available for {{$languageName}} yet.</p>
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

.course-item-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: var(--bg-secondary);
}

.course-item-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

body.dark-theme .course-item-card {
  border-color: rgba(255, 255, 255, 0.1) !important;
}

body.dark-theme .course-item-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
}

body.light-theme .course-item-card {
  border-color: rgba(0, 0, 0, 0.1) !important;
}

.course-edit-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
  transition: all 0.3s ease;
  z-index: 10;
}

.course-edit-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(255, 152, 0, 0.5);
  background: linear-gradient(135deg, #fb8c00 0%, #e65100 100%);
  color: white;
}

.course-edit-btn:active {
  transform: scale(0.95);
}
</style>

@endsection

