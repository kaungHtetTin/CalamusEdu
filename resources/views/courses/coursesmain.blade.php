@extends('layouts.main')

@section('content')

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Courses</div>
            <div class="activity-stat-value">{{number_format($total_courses)}}</div>
            <div class="activity-stat-subtext">All courses</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-book"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Enrollments</div>
            <div class="activity-stat-value">{{number_format($total_enrollments)}}</div>
            <div class="activity-stat-subtext">All enrollments</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Lessons</div>
            <div class="activity-stat-value">{{number_format($total_lessons_in_courses)}}</div>
            <div class="activity-stat-subtext">In all courses</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-graduation-cap"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Average Rating</div>
            <div class="activity-stat-value">{{$avg_rating}} <small style="font-size: 14px; color: #ff9800;"><i class="fas fa-star"></i></small></div>
            <div class="activity-stat-subtext">Overall rating</div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-star"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  {{-- Bar Chart - Courses by Language --}}
  <div class="col-xl-8 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Courses by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="courseBarChart" height="100"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - VIP vs Regular --}}
  <div class="col-xl-4 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Course Types</h5>
      </div>
      <div class="card-body">
        <canvas id="courseTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  {{-- Pie Chart - Enrollments by Language --}}
  <div class="col-xl-6 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Enrollments by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="enrollmentChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - Average Rating by Language --}}
  <div class="col-xl-6 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Average Rating by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="ratingChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  {{-- Language Cards - Vimeo Style --}}
  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Quick Access</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('courses.byLanguage', 'english')}}" class="quick-access-card quick-access-english">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyenglish.png')}}" alt="Easy English"/>
              </div>
              <div class="quick-access-title">Easy English</div>
              <div class="quick-access-count">{{$english_courses}} courses</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('courses.byLanguage', 'korea')}}" class="quick-access-card quick-access-korean">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean"/>
              </div>
              <div class="quick-access-title">Easy Korean</div>
              <div class="quick-access-count">{{$korean_courses}} courses</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('courses.byLanguage', 'chinese')}}" class="quick-access-card quick-access-chinese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easychinese.png')}}" alt="Easy Chinese"/>
              </div>
              <div class="quick-access-title">Easy Chinese</div>
              <div class="quick-access-count">{{$chinese_courses}} courses</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('courses.byLanguage', 'japanese')}}" class="quick-access-card quick-access-japanese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese"/>
              </div>
              <div class="quick-access-title">Easy Japanese</div>
              <div class="quick-access-count">{{$japanese_courses}} courses</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('courses.byLanguage', 'russian')}}" class="quick-access-card quick-access-russian">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian"/>
              </div>
              <div class="quick-access-title">Easy Russian</div>
              <div class="quick-access-count">{{$russian_courses}} courses</div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js 2.9.4 compatibility
    const isDarkTheme = !document.body.classList.contains('light-theme');
    const textColor = isDarkTheme ? '#e0e0e0' : '#202124';
    const gridColor = isDarkTheme ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

    // Bar Chart - Courses by Language
    const courseBarCtx = document.getElementById('courseBarChart').getContext('2d');
    new Chart(courseBarCtx, {
        type: 'bar',
        data: {
            labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
            datasets: [{
                label: 'Courses',
                data: [
                    {{$english_courses}},
                    {{$korean_courses}},
                    {{$chinese_courses}},
                    {{$japanese_courses}},
                    {{$russian_courses}}
                ],
                backgroundColor: [
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 152, 0, 0.8)',
                    'rgba(244, 67, 54, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(76, 175, 80, 0.8)'
                ],
                borderColor: [
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)',
                    'rgba(244, 67, 54, 1)',
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
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: textColor,
                    padding: 15,
                    generateLabels: function(chart) {
                        const data = chart.data;
                        if (data.labels.length && data.datasets.length) {
                            return [{
                                text: 'Total Courses: {{number_format($total_courses)}}',
                                fillStyle: 'transparent',
                                strokeStyle: 'transparent',
                                fontColor: textColor,
                                fontStyle: 'bold'
                            }];
                        }
                        return [];
                    }
                }
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

    // Doughnut Chart - VIP vs Regular
    const courseTypeCtx = document.getElementById('courseTypeChart').getContext('2d');
    new Chart(courseTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['VIP Courses', 'Regular Courses'],
            datasets: [{
                data: [{{$vip_courses}}, {{$regular_courses}}],
                backgroundColor: [
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(76, 175, 80, 0.8)'
                ],
                borderColor: [
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
                        const total = {{$total_courses}};
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    });

    // Pie Chart - Enrollments by Language
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(enrollmentCtx, {
        type: 'pie',
        data: {
            labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
            datasets: [{
                data: [
                    {{$english_enrollments}},
                    {{$korean_enrollments}},
                    {{$chinese_enrollments}},
                    {{$japanese_enrollments}},
                    {{$russian_enrollments}}
                ],
                backgroundColor: [
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 152, 0, 0.8)',
                    'rgba(244, 67, 54, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(76, 175, 80, 0.8)'
                ],
                borderColor: [
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)',
                    'rgba(244, 67, 54, 1)',
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
                        const total = {{$total_enrollments}};
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                    }
                }
            }
        }
    });

    // Bar Chart - Average Rating by Language
    const ratingCtx = document.getElementById('ratingChart').getContext('2d');
    new Chart(ratingCtx, {
        type: 'bar',
        data: {
            labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
            datasets: [{
                label: 'Average Rating',
                data: [
                    {{$english_avg_rating}},
                    {{$korean_avg_rating}},
                    {{$chinese_avg_rating}},
                    {{$japanese_avg_rating}},
                    {{$russian_avg_rating}}
                ],
                backgroundColor: [
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(255, 152, 0, 0.8)',
                    'rgba(244, 67, 54, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(76, 175, 80, 0.8)'
                ],
                borderColor: [
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)',
                    'rgba(244, 67, 54, 1)',
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
                        max: 5,
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
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Rating: ' + tooltipItem.yLabel + ' / 5.0';
                    }
                }
            }
        }
    });
});
</script>
@endpush

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

.course-card {
  cursor: pointer;
}

.course-card:hover {
  transform: translateY(-2px);
}
</style>

@endsection
