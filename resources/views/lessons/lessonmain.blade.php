@extends('layouts.main')

@section('content')

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Lessons</div>
            <div class="activity-stat-value">{{number_format($total_lessons)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon learns">
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
            <div class="activity-stat-label">Video Lessons</div>
            <div class="activity-stat-value">{{number_format($video_lessons)}}</div>
            <div class="activity-stat-subtext">{{$total_lessons > 0 ? round(($video_lessons / $total_lessons) * 100, 1) : 0}}% of total</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-video"></i>
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
            <div class="activity-stat-label">VIP Lessons</div>
            <div class="activity-stat-value">{{number_format($vip_lessons)}}</div>
            <div class="activity-stat-subtext">{{$total_lessons > 0 ? round(($vip_lessons / $total_lessons) * 100, 1) : 0}}% of total</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-crown"></i>
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
            <div class="activity-stat-label">Total Categories</div>
            <div class="activity-stat-value">{{number_format($total_categories)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-folder"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  {{-- Bar Chart - Lessons by Language --}}
  <div class="col-xl-8 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Lessons by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="lessonBarChart" height="100"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - Video vs Non-Video --}}
  <div class="col-xl-4 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Lesson Types</h5>
      </div>
      <div class="card-body">
        <canvas id="lessonTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  {{-- Pie Chart - VIP vs Regular --}}
  <div class="col-xl-6 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">VIP vs Regular Lessons</h5>
      </div>
      <div class="card-body">
        <canvas id="lessonVipChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - Categories by Language --}}
  <div class="col-xl-6 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Categories by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="categoryChart"></canvas>
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
            <a href="{{route('lessons.byLanguage','english')}}" class="quick-access-card quick-access-english">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyenglish.png')}}" alt="Easy English"/>
              </div>
              <div class="quick-access-title">Easy English</div>
              <div class="quick-access-count">{{number_format($english_lessons)}} lessons</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('lessons.byLanguage','korea')}}" class="quick-access-card quick-access-korean">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean"/>
              </div>
              <div class="quick-access-title">Easy Korean</div>
              <div class="quick-access-count">{{number_format($korean_lessons)}} lessons</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('lessons.byLanguage','chinese')}}" class="quick-access-card quick-access-chinese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easychinese.png')}}" alt="Easy Chinese"/>
              </div>
              <div class="quick-access-title">Easy Chinese</div>
              <div class="quick-access-count">{{number_format($chinese_lessons)}} lessons</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('lessons.byLanguage','japanese')}}" class="quick-access-card quick-access-japanese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese"/>
              </div>
              <div class="quick-access-title">Easy Japanese</div>
              <div class="quick-access-count">{{number_format($japanese_lessons)}} lessons</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('lessons.byLanguage','russian')}}" class="quick-access-card quick-access-russian">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian"/>
              </div>
              <div class="quick-access-title">Easy Russian</div>
              <div class="quick-access-count">{{number_format($russian_lessons)}} lessons</div>
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
    const isDarkTheme = !document.body.classList.contains('light-theme');
    const textColor = isDarkTheme ? '#e0e0e0' : '#202124';
    const gridColor = isDarkTheme ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

    // Bar Chart - Lessons by Language
    const lessonBarCtx = document.getElementById('lessonBarChart');
    if (lessonBarCtx) {
        new Chart(lessonBarCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
                datasets: [{
                    label: 'Lessons',
                    data: [
                        {{$english_lessons}},
                        {{$korean_lessons}},
                        {{$chinese_lessons}},
                        {{$japanese_lessons}},
                        {{$russian_lessons}}
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
                                    text: 'Total Lessons: {{number_format($total_lessons)}}',
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
    }

    // Doughnut Chart - Video vs Non-Video
    const lessonTypeCtx = document.getElementById('lessonTypeChart');
    if (lessonTypeCtx) {
        new Chart(lessonTypeCtx.getContext('2d'), {
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
    }

    // Pie Chart - VIP vs Regular
    const lessonVipCtx = document.getElementById('lessonVipChart');
    if (lessonVipCtx) {
        new Chart(lessonVipCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['VIP Lessons', 'Regular Lessons'],
                datasets: [{
                    data: [{{$vip_lessons}}, {{$regular_lessons}}],
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
                            const total = {{$total_lessons}};
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }

    // Doughnut Chart - Categories by Language
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        new Chart(categoryCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
                datasets: [{
                    data: [
                        {{$english_categories}},
                        {{$korean_categories}},
                        {{$chinese_categories}},
                        {{$japanese_categories}},
                        {{$russian_categories}}
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
                            const total = {{$total_categories}};
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush

@endsection
