@extends('layouts.main')

@section('content')

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Posts</div>
            <div class="activity-stat-value">{{number_format($total_posts)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-newspaper"></i>
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
            <div class="activity-stat-label">Total Likes</div>
            <div class="activity-stat-value">{{number_format($total_likes)}}</div>
            <div class="activity-stat-subtext">All posts</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-heart"></i>
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
            <div class="activity-stat-label">Total Comments</div>
            <div class="activity-stat-value">{{number_format($total_comments)}}</div>
            <div class="activity-stat-subtext">All posts</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-comments"></i>
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
            <div class="activity-stat-label">Total Views</div>
            <div class="activity-stat-value">{{number_format($total_views)}}</div>
            <div class="activity-stat-subtext">Video posts</div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-eye"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  <div class="col-xl-3 col-md-6 mb-3">
    <a href="{{ route('showReportedPostsTimeline') }}" style="text-decoration: none; color: inherit; display: block;">
      <div class="card activity-stat-card" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="activity-stat-label">Reported Posts</div>
              <div class="activity-stat-value">{{number_format($total_reported_posts ?? 0)}}</div>
              <div class="activity-stat-subtext">Needs review</div>
            </div>
            <div class="activity-stat-icon" style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);">
              <i class="fas fa-flag"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-3 col-md-6 mb-3">
    <a href="{{ route('showAdminNotifications') }}" style="text-decoration: none; color: inherit; display: block;">
      <div class="card activity-stat-card" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="activity-stat-label">Comments & Replies</div>
              <div class="activity-stat-value">{{number_format($unreadNotificationsCount ?? 0)}}</div>
              <div class="activity-stat-subtext">Unread notifications</div>
            </div>
            <div class="activity-stat-icon" style="background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); position: relative;">
              <i class="fas fa-bell"></i>
              @if(($unreadNotificationsCount ?? 0) > 0)
                <span class="badge badge-danger" style="position: absolute; top: -5px; right: -5px; background: #f44336; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<div class="row mb-3">
  {{-- Bar Chart - Posts by Language --}}
  <div class="col-xl-8 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Posts by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="postBarChart" height="100"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart - Post Types --}}
  <div class="col-xl-4 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Post Types</h5>
      </div>
      <div class="card-body">
        <canvas id="postTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  {{-- Line Chart - Posts Over Time --}}
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Posts Over Time (Last 30 Days)</h5>
      </div>
      <div class="card-body">
        <canvas id="postsOverTimeChart" height="60"></canvas>
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
            <a href="{{route('showTimeline','english')}}?mCode=ee&page=1" class="quick-access-card quick-access-english">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyenglish.png')}}" alt="Easy English"/>
              </div>
              <div class="quick-access-title">Easy English</div>
              <div class="quick-access-count">{{number_format($english_posts)}} posts</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showTimeline','korea')}}?mCode=ko&page=1" class="quick-access-card quick-access-korean">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean"/>
              </div>
              <div class="quick-access-title">Easy Korean</div>
              <div class="quick-access-count">{{number_format($korean_posts)}} posts</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showTimeline','chinese')}}?mCode=cn&page=1" class="quick-access-card quick-access-chinese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easychinese.png')}}" alt="Easy Chinese"/>
              </div>
              <div class="quick-access-title">Easy Chinese</div>
              <div class="quick-access-count">{{number_format($chinese_posts)}} posts</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showTimeline','japanese')}}?mCode=jp&page=1" class="quick-access-card quick-access-japanese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese"/>
              </div>
              <div class="quick-access-title">Easy Japanese</div>
              <div class="quick-access-count">{{number_format($japanese_posts)}} posts</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showTimeline','russian')}}?mCode=ru&page=1" class="quick-access-card quick-access-russian">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian"/>
              </div>
              <div class="quick-access-title">Easy Russian</div>
              <div class="quick-access-count">{{number_format($russian_posts)}} posts</div>
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

    // Bar Chart - Posts by Language
    const postBarCtx = document.getElementById('postBarChart');
    if (postBarCtx) {
        new Chart(postBarCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
                datasets: [{
                    label: 'Posts',
                    data: [
                        {{ $english_posts }},
                        {{ $korean_posts }},
                        {{ $chinese_posts }},
                        {{ $japanese_posts }},
                        {{ $russian_posts }}
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
                                    text: 'Total Posts: {{number_format($total_posts)}}',
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

    // Doughnut Chart - Post Types
    const postTypeCtx = document.getElementById('postTypeChart');
    if (postTypeCtx) {
        new Chart(postTypeCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['With Images', 'With Videos', 'Text Only'],
                datasets: [{
                    data: [
                        {{ $posts_with_images }},
                        {{ $posts_with_videos }},
                        {{ $posts_text_only }}
                    ],
                    backgroundColor: [
                        'rgba(33, 150, 243, 0.8)',
                        'rgba(255, 152, 0, 0.8)',
                        'rgba(156, 39, 176, 0.8)'
                    ],
                    borderColor: [
                        'rgba(33, 150, 243, 1)',
                        'rgba(255, 152, 0, 1)',
                        'rgba(156, 39, 176, 1)'
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
                            const total = {{ $total_posts }};
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }

    // Line Chart - Posts Over Time
    const postsOverTimeCtx = document.getElementById('postsOverTimeChart');
    if (postsOverTimeCtx) {
        const dates = @json(array_column($posts_over_time, 'date'));
        const counts = @json(array_column($posts_over_time, 'count'));
        
        new Chart(postsOverTimeCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Posts',
                    data: counts,
                    borderColor: 'rgba(26, 183, 234, 1)',
                    backgroundColor: 'rgba(26, 183, 234, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
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
                            fontColor: textColor,
                            stepSize: 1
                        },
                        gridLines: {
                            color: gridColor
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontColor: textColor,
                            maxRotation: 45,
                            minRotation: 45
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
});
</script>
@endpush

@endsection
