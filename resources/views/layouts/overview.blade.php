@extends('layouts.main')

@section('content')
@php
  $totalByMajor = $korean_user_count + $english_user_count + $chinese_user_count + $japanese_user_count + $russian_user_count;
  $share = function ($count) use ($learner_count) {
      return $learner_count > 0 ? round(($count / $learner_count) * 100) : 0;
  };
@endphp

<style>
  .dashboard-overview {
    padding: 0;
  }
  
  .dashboard-header {
    margin-bottom: 24px;
  }
  
  .dashboard-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 4px 0;
  }
  
  .dashboard-header p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
  }
  
  .stat-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 16px;
    transition: all 0.2s ease;
    height: 100%;
    cursor: default;
  }
  
  .stat-card:hover {
    border-color: var(--primary-color);
    background: var(--bg-tertiary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }
  
  .stat-card-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 8px;
  }
  
  .stat-card-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px 0;
    line-height: 1.2;
  }
  
  .stat-card-desc {
    font-size: 12px;
    color: var(--text-muted);
    margin: 0;
  }
  
  .dashboard-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
  }
  
  .dashboard-section-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-tertiary);
  }
  
  .dashboard-section-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .dashboard-section-body {
    padding: 16px 20px;
  }
  
  .language-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--border-color);
    transition: background 0.2s ease;
  }
  
  .language-item:last-child {
    border-bottom: none;
  }
  
  .language-item:hover {
    background: var(--bg-tertiary);
    margin: 0 -20px;
    padding-left: 20px;
    padding-right: 20px;
  }
  
  .language-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  .language-item-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    object-fit: cover;
  }
  
  .language-item-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
  }
  
  .language-item-stats {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
  }
  
  .quick-action-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    color: var(--text-secondary);
    text-decoration: none;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s ease;
    font-size: 14px;
  }
  
  .quick-action-item:last-child {
    border-bottom: none;
  }
  
  .quick-action-item:hover {
    color: var(--primary-color);
    padding-left: 8px;
    background: var(--bg-tertiary);
    margin: 0 -20px;
    padding-left: 28px;
    padding-right: 20px;
  }
  
  .quick-action-item i {
    margin-right: 12px;
    width: 18px;
    text-align: center;
    font-size: 13px;
  }
  
  .compact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }
  
  @media (min-width: 768px) {
    .compact-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  
  @media (max-width: 767px) {
    .compact-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  
  .two-column-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-bottom: 24px;
  }
  
  @media (min-width: 992px) {
    .two-column-grid {
      grid-template-columns: 1.4fr 1fr;
    }
  }
  
  .charts-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-bottom: 24px;
  }
  
  @media (min-width: 992px) {
    .charts-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  
  .chart-container {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
    padding: 20px;
  }
  
  .chart-container canvas {
    max-height: 300px;
  }
</style>

<div class="dashboard-overview">
  <div class="dashboard-header">
    <h1>Dashboard</h1>
    <p>Overview of your platform statistics</p>
  </div>

  <div class="compact-grid">
    <div class="stat-card">
      <div class="stat-card-label">Users</div>
      <div class="stat-card-value">{{ number_format($learner_count) }}</div>
      <p class="stat-card-desc">Total learners</p>
    </div>
    <div class="stat-card">
      <div class="stat-card-label">Courses</div>
      <div class="stat-card-value">{{ number_format($course_count) }}</div>
      <p class="stat-card-desc">Available courses</p>
    </div>
    <div class="stat-card">
      <div class="stat-card-label">Lessons</div>
      <div class="stat-card-value">{{ number_format($lesson_count) }}</div>
      <p class="stat-card-desc">Total lessons</p>
    </div>
    <div class="stat-card">
      <div class="stat-card-label">Posts</div>
      <div class="stat-card-value">{{ number_format($post_count) }}</div>
      <p class="stat-card-desc">User posts</p>
    </div>
  </div>

  <div class="charts-grid">
    <div class="chart-container">
      <div class="dashboard-section-header" style="margin: -20px -20px 20px -20px; padding: 16px 20px;">
        <h3>New Users (Last 30 Days)</h3>
      </div>
      <canvas id="newUsersChart"></canvas>
    </div>
    <div class="chart-container">
      <div class="dashboard-section-header" style="margin: -20px -20px 20px -20px; padding: 16px 20px;">
        <h3>Active Users (Last 30 Days)</h3>
      </div>
      <canvas id="activeUsersChart"></canvas>
    </div>
  </div>

  <div class="two-column-grid">
    <div class="dashboard-section">
      <div class="dashboard-section-header">
        <h3>Users by Language</h3>
      </div>
      <div class="dashboard-section-body">
        <div class="language-item">
          <div class="language-item-left">
            <img src="{{ asset('public/img/easyenglish.png') }}" class="language-item-icon" alt="English"/>
            <span class="language-item-name">Easy English</span>
          </div>
          <span class="language-item-stats">{{ number_format($english_user_count) }} <span style="color: var(--text-muted);">({{ $share($english_user_count) }}%)</span></span>
        </div>
        <div class="language-item">
          <div class="language-item-left">
            <img src="{{ asset('public/img/easykorean.png') }}" class="language-item-icon" alt="Korean"/>
            <span class="language-item-name">Easy Korean</span>
          </div>
          <span class="language-item-stats">{{ number_format($korean_user_count) }} <span style="color: var(--text-muted);">({{ $share($korean_user_count) }}%)</span></span>
        </div>
        <div class="language-item">
          <div class="language-item-left">
            <img src="{{ asset('public/img/easychinese.png') }}" class="language-item-icon" alt="Chinese"/>
            <span class="language-item-name">Easy Chinese</span>
          </div>
          <span class="language-item-stats">{{ number_format($chinese_user_count) }} <span style="color: var(--text-muted);">({{ $share($chinese_user_count) }}%)</span></span>
        </div>
        <div class="language-item">
          <div class="language-item-left">
            <img src="{{ asset('public/img/easyjapanese.png') }}" class="language-item-icon" alt="Japanese"/>
            <span class="language-item-name">Easy Japanese</span>
          </div>
          <span class="language-item-stats">{{ number_format($japanese_user_count) }} <span style="color: var(--text-muted);">({{ $share($japanese_user_count) }}%)</span></span>
        </div>
        <div class="language-item">
          <div class="language-item-left">
            <img src="{{ asset('public/img/easyrussian.png') }}" class="language-item-icon" alt="Russian"/>
            <span class="language-item-name">Easy Russian</span>
          </div>
          <span class="language-item-stats">{{ number_format($russian_user_count) }} <span style="color: var(--text-muted);">({{ $share($russian_user_count) }}%)</span></span>
        </div>
      </div>
    </div>

    <div class="dashboard-section">
      <div class="dashboard-section-header">
        <h3>Quick Actions</h3>
      </div>
      <div class="dashboard-section-body">
        <a href="{{ route('getUser') }}" class="quick-action-item">
          <i class="fas fa-users"></i>
          <span>Manage Users</span>
        </a>
        <a href="{{ route('lessons.main') }}" class="quick-action-item">
          <i class="fas fa-graduation-cap"></i>
          <span>Manage Lessons</span>
        </a>
        <a href="{{ route('showSongMain') }}" class="quick-action-item">
          <i class="fas fa-music"></i>
          <span>Manage Songs</span>
        </a>
        <a href="{{ route('showMainPostControllerView') }}" class="quick-action-item">
          <i class="fas fa-newspaper"></i>
          <span>Review Posts</span>
        </a>
        <a href="{{ route('showCloudMessage') }}" class="quick-action-item">
          <i class="fas fa-bell"></i>
          <span>Push Notifications</span>
        </a>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Chart.js 2.x configuration for dark theme
  Chart.defaults.global.defaultFontColor = '#c9d1d9';
  Chart.defaults.global.defaultFontFamily = 'Roboto, sans-serif';
  Chart.defaults.global.defaultFontSize = 11;
  
  const primaryColor = '#1ab7ea';
  const primaryColorLight = 'rgba(26, 183, 234, 0.1)';
  const successColor = '#3fb950';
  const successColorLight = 'rgba(63, 185, 80, 0.1)';
  
  const chartLabels = @json($chart_labels);
  const newUsersData = @json($new_users_data);
  const activeUsersData = @json($active_users_data);
  
  // New Users Chart
  const newUsersCtx = document.getElementById('newUsersChart').getContext('2d');
  new Chart(newUsersCtx, {
    type: 'line',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'New Users',
        data: newUsersData,
        borderColor: primaryColor,
        backgroundColor: primaryColorLight,
        borderWidth: 2,
        fill: true,
        lineTension: 0.4,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointBackgroundColor: primaryColor,
        pointBorderColor: '#0d1117',
        pointBorderWidth: 2,
        pointHoverBackgroundColor: primaryColor,
        pointHoverBorderColor: '#fff',
        pointHoverBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: 'rgba(13, 17, 23, 0.9)',
        titleFontColor: '#f0f6fc',
        bodyFontColor: '#c9d1d9',
        borderColor: '#30363d',
        borderWidth: 1,
        padding: 12,
        displayColors: false,
        callbacks: {
          label: function(tooltipItem) {
            return 'New Users: ' + tooltipItem.yLabel;
          }
        }
      },
      scales: {
        xAxes: [{
          gridLines: {
            color: 'rgba(240, 246, 252, 0.05)',
            drawBorder: false
          },
          ticks: {
            fontColor: '#8b949e',
            maxRotation: 45,
            minRotation: 45
          }
        }],
        yAxes: [{
          beginAtZero: true,
          gridLines: {
            color: 'rgba(240, 246, 252, 0.05)',
            drawBorder: false
          },
          ticks: {
            fontColor: '#8b949e',
            stepSize: 1
          }
        }]
      }
    }
  });
  
  // Active Users Chart
  const activeUsersCtx = document.getElementById('activeUsersChart').getContext('2d');
  new Chart(activeUsersCtx, {
    type: 'line',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Active Users',
        data: activeUsersData,
        borderColor: successColor,
        backgroundColor: successColorLight,
        borderWidth: 2,
        fill: true,
        lineTension: 0.4,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointBackgroundColor: successColor,
        pointBorderColor: '#0d1117',
        pointBorderWidth: 2,
        pointHoverBackgroundColor: successColor,
        pointHoverBorderColor: '#fff',
        pointHoverBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: 'rgba(13, 17, 23, 0.9)',
        titleFontColor: '#f0f6fc',
        bodyFontColor: '#c9d1d9',
        borderColor: '#30363d',
        borderWidth: 1,
        padding: 12,
        displayColors: false,
        callbacks: {
          label: function(tooltipItem) {
            return 'Active Users: ' + tooltipItem.yLabel;
          }
        }
      },
      scales: {
        xAxes: [{
          gridLines: {
            color: 'rgba(240, 246, 252, 0.05)',
            drawBorder: false
          },
          ticks: {
            fontColor: '#8b949e',
            maxRotation: 45,
            minRotation: 45
          }
        }],
        yAxes: [{
          beginAtZero: true,
          gridLines: {
            color: 'rgba(240, 246, 252, 0.05)',
            drawBorder: false
          },
          ticks: {
            fontColor: '#8b949e',
            stepSize: 1
          }
        }]
      }
    }
  });
});
</script>
@endpush

@endsection