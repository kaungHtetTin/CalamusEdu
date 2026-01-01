@extends('layouts.main')

@section('content')

{{-- Language Statistics --}}
<div class="row mb-4">
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">{{$languageName}} - Lesson Statistics</h5>
      </div>
      <div class="card-body">
        <canvas id="languageLessonChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Lesson Types</h5>
      </div>
      <div class="card-body">
        <canvas id="languageTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

{{-- Statistics Cards --}}
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Lessons</div>
            <div class="activity-stat-value">{{number_format($total_lessons)}}</div>
            <div class="activity-stat-subtext">{{$languageName}}</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-book"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Courses</div>
            <div class="activity-stat-value">{{number_format($total_courses)}}</div>
            <div class="activity-stat-subtext">Course categories</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-graduation-cap"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Video Lessons</div>
            <div class="activity-stat-value">{{number_format($video_lessons)}}</div>
            <div class="activity-stat-subtext">{{$total_lessons > 0 ? round(($video_lessons / $total_lessons) * 100, 1) : 0}}% of total</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-video"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">VIP Lessons</div>
            <div class="activity-stat-value">{{number_format($vip_lessons)}}</div>
            <div class="activity-stat-subtext">{{$total_lessons > 0 ? round(($vip_lessons / $total_lessons) * 100, 1) : 0}}% of total</div>
          </div>
          <div class="activity-stat-icon new-users-30">
            <i class="fas fa-crown"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Courses and Categories --}}
<div class="row mb-4">
  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{$languageName}} - Courses</h5>
          <div class="new-category-container no-border">
            <a href="{{route('lessons.addCourse', $language)}}" class="new-category-btn" title="New Course">
              <i class="fas fa-plus"></i>
              <span>New Course</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach ($myCourses as $myCourse)
@php
    session()->put($myCourse['title'], $myCourse['data']);
    session()->put('major', $major);
@endphp
     
<div class="row mb-4">
  <div class="col-xl-12 col-md-12">
    <div class="card course-section-card">
      {{-- Course Title --}}
      <div class="card-header course-title-header">
        <h4 class="mb-0">{{$myCourse['title']}}</h4>
      </div>
      
      <div class="card-body">
        {{-- Category Tabs --}}
        <div class="category-tabs-container mb-4">
          <div class="category-tabs">
            @foreach ($myCourse['data'] as $sub)
            <div class="category-tab-wrapper position-relative">
              <a href="{{route('lessons.list', $sub->id)}}?cate={{$sub->category}}&major={{$major}}" class="category-tab-item">
                <div class="category-tab-box">
                  @if ($sub->course_id == 9)
                    <img src="https://www.calamuseducation.com/uploads/icons/videoplaylist.png" class="category-icon" alt="Video Playlist"/>
                  @else
                    <img src="{{$sub->image_url}}" class="category-icon" alt="{{$sub->category_title}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\'%3E%3Crect width=\'40\' height=\'40\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'16\'%3E📚%3C/text%3E%3C/svg%3E'"/>
                  @endif
                  <span class="category-title">{{$sub->category_title}}</span>
                </div>
              </a>
              <a href="{{route('lessons.editCategory', $sub->id)}}" class="category-edit-btn" title="Edit Category" onclick="event.stopPropagation();">
                <i class="fas fa-edit"></i>
              </a>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Statistics Section --}}
        <div class="course-statistics">
          <ul class="statistics-list">
            <li>
              <i class="fas fa-book me-2"></i>
              <span class="stat-label">Total Lesson:</span>
              <span class="stat-value">{{number_format($myCourse['total_lessons'])}}</span>
            </li>
            <li>
              <i class="fas fa-video me-2"></i>
              <span class="stat-label">Total Video Lesson:</span>
              <span class="stat-value">{{number_format($myCourse['video_lessons'])}}</span>
            </li>
            <li>
              <i class="fas fa-file-alt me-2"></i>
              <span class="stat-label">Total Document Lesson:</span>
              <span class="stat-value">{{number_format($myCourse['document_lessons'])}}</span>
            </li>
          </ul>
        </div>

        {{-- Action Buttons --}}
        <div class="new-category-container">
          <a href="{{route('lessons.sortCategories', ['course' => $myCourse['course_id'], 'language' => $language])}}" class="btn-back btn-sm me-2" title="Sort Categories">
            <i class="fas fa-sort"></i>
            <span>Sort Categories</span>
          </a>
          <a href="{{route('lessons.addCategory', ['course' => $myCourse['course_id'], 'language' => $language])}}" class="new-category-btn" title="New Category">
            <i class="fas fa-plus"></i>
            <span>New Category</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@endforeach

@push('scripts')
<style>
.category-tab-wrapper {
    position: relative;
    display: inline-block;
}

.category-edit-btn {
    position: absolute;
    top: 4px;
    right: 4px;
    background: rgba(33, 150, 243, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    text-decoration: none;
    font-size: 12px;
    opacity: 0;
    transform: scale(0.8);
}

.category-tab-wrapper:hover .category-edit-btn {
    opacity: 1;
    transform: scale(1);
}

.category-edit-btn:hover {
    background: rgba(33, 150, 243, 1);
    transform: scale(1.1);
    color: white;
}

body.dark-theme .category-edit-btn {
    background: rgba(33, 150, 243, 0.9);
}

body.dark-theme .category-edit-btn:hover {
    background: rgba(33, 150, 243, 1);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDarkTheme = !document.body.classList.contains('light-theme');
    const textColor = isDarkTheme ? '#e0e0e0' : '#202124';
    const gridColor = isDarkTheme ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

    // Bar Chart - Lesson Statistics
    const languageLessonCtx = document.getElementById('languageLessonChart').getContext('2d');
    new Chart(languageLessonCtx, {
        type: 'bar',
        data: {
            labels: ['Total Lessons', 'Video Lessons', 'Non-Video', 'VIP Lessons', 'Regular'],
            datasets: [{
                label: 'Lessons',
                data: [
                    {{$total_lessons}},
                    {{$video_lessons}},
                    {{$non_video_lessons}},
                    {{$vip_lessons}},
                    {{$regular_lessons}}
                ],
                backgroundColor: [
                    'rgba(50, 205, 50, 0.8)',
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 152, 0, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(76, 175, 80, 0.8)'
                ],
                borderColor: [
                    'rgba(50, 205, 50, 1)',
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)',
                    'rgba(156, 39, 176, 1)',
                    'rgba(76, 175, 80, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: textColor
                    },
                    gridLines: {
                        color: gridColor
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: textColor
                    },
                    gridLines: {
                        color: gridColor
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false
            }
        }
    });

    // Doughnut Chart - Video vs Non-Video
    const languageTypeCtx = document.getElementById('languageTypeChart').getContext('2d');
    new Chart(languageTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Video Lessons', 'Non-Video Lessons'],
            datasets: [{
                data: [{{$video_lessons}}, {{$non_video_lessons}}],
                backgroundColor: [
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 152, 0, 0.8)'
                ],
                borderColor: [
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: textColor,
                    padding: 15
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        const label = data.labels[tooltipItem.index] || '';
                        const value = data.datasets[0].data[tooltipItem.index];
                        const total = {{$total_lessons}};
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    });
});
</script>
@endpush

@endsection