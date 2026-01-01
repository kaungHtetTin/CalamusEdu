@extends('layouts.main')

@section('content')

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
            <h6 class="text-muted mb-2" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Lessons</h6>
            <h3 class="mb-0" style="font-weight: 600; color: var(--text-primary);">{{number_format($total_lessons_in_courses)}}</h3>
          </div>
          <div class="stats-icon" style="width: 56px; height: 56px; border-radius: 12px; background: rgba(255, 152, 0, 0.1); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-graduation-cap fa-2x" style="color: #ff9800;"></i>
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

<div class="row">
  {{-- Bar Chart - Courses by Language --}}
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Courses by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="courseBarChart" height="100"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - VIP vs Regular --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Course Types</h5>
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

<div class="row">
  {{-- Language Cards --}}
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card" style="border-radius: 12px;">
      <div class="card-header" style="background: rgba(156, 39, 176, 0.05); border-bottom: 1px solid rgba(156, 39, 176, 0.1);">
        <h5 class="mb-0" style="font-weight: 600;">Quick Access</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('courses.byLanguage', 'english')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded course-card" style="background-color: rgba(33, 150, 243, 0.1); border: 2px solid rgba(33, 150, 243, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(33, 150, 243, 0.2)'; this.style.borderColor='rgba(33, 150, 243, 0.5)'" onmouseout="this.style.backgroundColor='rgba(33, 150, 243, 0.1)'; this.style.borderColor='rgba(33, 150, 243, 0.3)'">
                <img src="{{asset('public/img/easyenglish.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy English</div>
                <small class="text-muted">{{$english_courses}} courses</small>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('courses.byLanguage', 'korea')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded course-card" style="background-color: rgba(255, 152, 0, 0.1); border: 2px solid rgba(255, 152, 0, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(255, 152, 0, 0.2)'; this.style.borderColor='rgba(255, 152, 0, 0.5)'" onmouseout="this.style.backgroundColor='rgba(255, 152, 0, 0.1)'; this.style.borderColor='rgba(255, 152, 0, 0.3)'">
                <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Korean</div>
                <small class="text-muted">{{$korean_courses}} courses</small>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('courses.byLanguage', 'chinese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded course-card" style="background-color: rgba(244, 67, 54, 0.1); border: 2px solid rgba(244, 67, 54, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(244, 67, 54, 0.2)'; this.style.borderColor='rgba(244, 67, 54, 0.5)'" onmouseout="this.style.backgroundColor='rgba(244, 67, 54, 0.1)'; this.style.borderColor='rgba(244, 67, 54, 0.3)'">
                <img src="{{asset('public/img/easychinese.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Chinese</div>
                <small class="text-muted">{{$chinese_courses}} courses</small>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('courses.byLanguage', 'japanese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded course-card" style="background-color: rgba(156, 39, 176, 0.1); border: 2px solid rgba(156, 39, 176, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(156, 39, 176, 0.2)'; this.style.borderColor='rgba(156, 39, 176, 0.5)'" onmouseout="this.style.backgroundColor='rgba(156, 39, 176, 0.1)'; this.style.borderColor='rgba(156, 39, 176, 0.3)'">
                <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Japanese</div>
                <small class="text-muted">{{$japanese_courses}} courses</small>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('courses.byLanguage', 'russian')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded course-card" style="background-color: rgba(76, 175, 80, 0.1); border: 2px solid rgba(76, 175, 80, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(76, 175, 80, 0.2)'; this.style.borderColor='rgba(76, 175, 80, 0.5)'" onmouseout="this.style.backgroundColor='rgba(76, 175, 80, 0.1)'; this.style.borderColor='rgba(76, 175, 80, 0.3)'">
                <img src="{{asset('public/img/easyrussian.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Russian</div>
                <small class="text-muted">{{$russian_courses}} courses</small>
              </div>
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
