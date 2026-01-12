@extends('layouts.main')

@section('content')

<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small">Total Posts</div>
            <div class="h4 mb-0">{{ number_format($total_posts) }}</div>
          </div>
          <div class="text-primary">
            <i class="fas fa-newspaper fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small">Total Likes</div>
            <div class="h4 mb-0">{{ number_format($total_likes) }}</div>
          </div>
          <div class="text-danger">
            <i class="fas fa-heart fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small">Total Comments</div>
            <div class="h4 mb-0">{{ number_format($total_comments) }}</div>
          </div>
          <div class="text-info">
            <i class="fas fa-comments fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small">Total Views</div>
            <div class="h4 mb-0">{{ number_format($total_views) }}</div>
          </div>
          <div class="text-success">
            <i class="fas fa-eye fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  {{-- Bar Chart - Posts by Language --}}
  <div class="col-xl-8 col-md-12 mb-4">
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
  <div class="col-xl-4 col-md-12 mb-4">
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

<div class="row">
  {{-- Top Liked Posts --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Top Liked Posts</h5>
      </div>
      <div class="card-body">
        @if($top_liked_posts->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($top_liked_posts as $index => $post)
              <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1">
                    <div class="fw-bold">#{{ $index + 1 }}</div>
                    <div class="small text-truncate" style="max-width: 200px;" title="{{ $post->body }}">
                      {{ strlen($post->body) > 50 ? substr($post->body, 0, 50) . '...' : $post->body }}
                    </div>
                    <div class="text-muted small">{{ $post->learner_name }} • {{ ucfirst($post->major) }}</div>
                  </div>
                  <div class="text-danger ms-2">
                    <i class="fas fa-heart"></i> {{ number_format($post->post_like) }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-muted mb-0">No posts found</p>
        @endif
      </div>
    </div>
  </div>

  {{-- Top Commented Posts --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Top Commented Posts</h5>
      </div>
      <div class="card-body">
        @if($top_commented_posts->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($top_commented_posts as $index => $post)
              <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1">
                    <div class="fw-bold">#{{ $index + 1 }}</div>
                    <div class="small text-truncate" style="max-width: 200px;" title="{{ $post->body }}">
                      {{ strlen($post->body) > 50 ? substr($post->body, 0, 50) . '...' : $post->body }}
                    </div>
                    <div class="text-muted small">{{ $post->learner_name }} • {{ ucfirst($post->major) }}</div>
                  </div>
                  <div class="text-info ms-2">
                    <i class="fas fa-comments"></i> {{ number_format($post->comments) }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-muted mb-0">No posts found</p>
        @endif
      </div>
    </div>
  </div>

  {{-- Top Viewed Posts --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Top Viewed Posts</h5>
      </div>
      <div class="card-body">
        @if($top_viewed_posts->count() > 0)
          <div class="list-group list-group-flush">
            @foreach($top_viewed_posts as $index => $post)
              <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1">
                    <div class="fw-bold">#{{ $index + 1 }}</div>
                    <div class="small text-truncate" style="max-width: 200px;" title="{{ $post->body }}">
                      {{ strlen($post->body) > 50 ? substr($post->body, 0, 50) . '...' : $post->body }}
                    </div>
                    <div class="text-muted small">{{ $post->learner_name }} • {{ ucfirst($post->major) }}</div>
                  </div>
                  <div class="text-success ms-2">
                    <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-muted mb-0">No video posts found</p>
        @endif
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
    const postBarCtx = document.getElementById('postBarChart').getContext('2d');
    new Chart(postBarCtx, {
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

    // Doughnut Chart - Post Types
    const postTypeCtx = document.getElementById('postTypeChart').getContext('2d');
    new Chart(postTypeCtx, {
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

    // Line Chart - Posts Over Time
    const postsOverTimeCtx = document.getElementById('postsOverTimeChart').getContext('2d');
    const dates = @json(array_column($posts_over_time, 'date'));
    const counts = @json(array_column($posts_over_time, 'count'));
    
    new Chart(postsOverTimeCtx, {
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
});
</script>
@endpush

@endsection
