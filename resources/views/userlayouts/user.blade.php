@extends('layouts.navbar')

@section('searchbox')

<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user with name or phone' style="min-width: 225px" name="msg" />
</form>

@endsection


@section('content')

<div class="row">
  {{-- Bar Chart --}}
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Users by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="userBarChart" height="100"></canvas>
      </div>
    </div>
  </div>

  {{-- Doughnut Chart --}}
  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">User Distribution</h5>
      </div>
      <div class="card-body">
        <canvas id="userDoughnutChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Quick Links Cards --}}
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Quick Access</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('easyLanguageUserDatas', 'english')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded" style="background-color: rgba(33, 150, 243, 0.1); border: 2px solid rgba(33, 150, 243, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(33, 150, 243, 0.2)'; this.style.borderColor='rgba(33, 150, 243, 0.5)'" onmouseout="this.style.backgroundColor='rgba(33, 150, 243, 0.1)'; this.style.borderColor='rgba(33, 150, 243, 0.3)'">
                <img src="{{asset('public/img/easyenglish.png')}}" style="width: 40px;height:40px" class="mb-2"/>
                <div class="fw-bold">Easy English</div>
                <div class="text-muted">{{number_format($english_user_count)}}</div>
              </div>
            </a>
          </div>
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('easyLanguageUserDatas', 'korean')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded" style="background-color: rgba(255, 152, 0, 0.1); border: 2px solid rgba(255, 152, 0, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(255, 152, 0, 0.2)'; this.style.borderColor='rgba(255, 152, 0, 0.5)'" onmouseout="this.style.backgroundColor='rgba(255, 152, 0, 0.1)'; this.style.borderColor='rgba(255, 152, 0, 0.3)'">
                <img src="{{asset('public/img/easykorean.png')}}" style="width: 40px;height:40px" class="mb-2"/>
                <div class="fw-bold">Easy Korean</div>
                <div class="text-muted">{{number_format($koeran_user_count)}}</div>
              </div>
            </a>
          </div>
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('easyLanguageUserDatas', 'chinese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded" style="background-color: rgba(244, 67, 54, 0.1); border: 2px solid rgba(244, 67, 54, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(244, 67, 54, 0.2)'; this.style.borderColor='rgba(244, 67, 54, 0.5)'" onmouseout="this.style.backgroundColor='rgba(244, 67, 54, 0.1)'; this.style.borderColor='rgba(244, 67, 54, 0.3)'">
                <img src="{{asset('public/img/easychinese.png')}}" style="width: 40px;height:40px" class="mb-2"/>
                <div class="fw-bold">Easy Chinese</div>
                <div class="text-muted">{{number_format($chinese_user_count)}}</div>
              </div>
            </a>
          </div>
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('easyLanguageUserDatas', 'japanese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded" style="background-color: rgba(156, 39, 176, 0.1); border: 2px solid rgba(156, 39, 176, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(156, 39, 176, 0.2)'; this.style.borderColor='rgba(156, 39, 176, 0.5)'" onmouseout="this.style.backgroundColor='rgba(156, 39, 176, 0.1)'; this.style.borderColor='rgba(156, 39, 176, 0.3)'">
                <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 40px;height:40px" class="mb-2"/>
                <div class="fw-bold">Easy Japanese</div>
                <div class="text-muted">{{number_format($japanese_user_count)}}</div>
              </div>
            </a>
          </div>
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('easyLanguageUserDatas', 'russian')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded" style="background-color: rgba(76, 175, 80, 0.1); border: 2px solid rgba(76, 175, 80, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(76, 175, 80, 0.2)'; this.style.borderColor='rgba(76, 175, 80, 0.5)'" onmouseout="this.style.backgroundColor='rgba(76, 175, 80, 0.1)'; this.style.borderColor='rgba(76, 175, 80, 0.3)'">
                <img src="{{asset('public/img/easyrussian.png')}}" style="width: 40px;height:40px" class="mb-2"/>
                <div class="fw-bold">Easy Russian</div>
                <div class="text-muted">{{number_format($russian_user_count)}}</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- User Activity Statistics --}}
<div class="row mb-4">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Active Users (7 Days)</div>
            <div class="activity-stat-value">{{number_format($active_users_7d)}}</div>
            <div class="activity-stat-subtext">
              <span class="text-success">
                <i class="fas fa-arrow-up me-1"></i>{{$active_users_30d > 0 ? round(($active_users_7d / $active_users_30d) * 100, 1) : 0}}%
              </span>
              of 30-day active
            </div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-user-check"></i>
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
            <div class="activity-stat-label">Active Users (30 Days)</div>
            <div class="activity-stat-value">{{number_format($active_users_30d)}}</div>
            <div class="activity-stat-subtext">
              Monthly active users
            </div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-users"></i>
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
            <div class="activity-stat-label">New Users (7 Days)</div>
            <div class="activity-stat-value">{{number_format($new_users_7d)}}</div>
            <div class="activity-stat-subtext">
              <span class="text-success">
                <i class="fas fa-arrow-up me-1"></i>{{$new_users_30d > 0 ? round(($new_users_7d / $new_users_30d) * 100, 1) : 0}}%
              </span>
              of 30-day new
            </div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-user-plus"></i>
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
            <div class="activity-stat-label">New Users (30 Days)</div>
            <div class="activity-stat-value">{{number_format($new_users_30d)}}</div>
            <div class="activity-stat-subtext">
              Monthly new registrations
            </div>
          </div>
          <div class="activity-stat-icon new-users-30">
            <i class="fas fa-user-friends"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-users me-2"></i>All Users
      </h5>
      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('getUser') }}" method="GET" class="d-flex align-items-center search-form">
          <div class="search-input-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   name="search" 
                   class="form-control modern-search-input" 
                   placeholder="Search by name, phone, or email..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            @if(!empty($search))
              <a href="{{ route('getUser') }}" class="clear-search" title="Clear search">
                <i class="fas fa-times"></i>
              </a>
            @endif
          </div>
          <button type="submit" class="btn btn-search ms-2">
            <i class="fas fa-search me-1"></i>Search
          </button>
        </form>
        <span class="badge modern-badge">{{number_format($learner_count)}} Total</span>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    @if(!empty($search))
    <div class="search-results-info">
      <div class="alert alert-info mb-0 border-0 rounded-0" style="background: linear-gradient(90deg, rgba(50, 205, 50, 0.1) 0%, transparent 100%); border-left: 4px solid #32cd32 !important;">
        <i class="fas fa-info-circle me-2"></i>
        Showing search results for: <strong>"{{ $search }}"</strong>
        <a href="{{ route('getUser') }}" class="ms-2 text-decoration-none">
          <i class="fas fa-times me-1"></i>Clear
        </a>
      </div>
    </div>
    @endif
    <div class="table-responsive">
      <table class="table modern-table mb-0">
        <thead>
          <tr>
          
            <th colspan="2" scope="col" class="table-user">Name</th>
            <th scope="col" class="table-phone">Phone</th>
            <th scope="col" class="table-email">Email</th>
            <th scope="col" class="table-region">Region</th>
            <th scope="col" class="table-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($learners as $index => $learner)
          <tr class="">
            <td class="">
              <div class="user-avatar-wrapper">
                <img src="{{$learner->learner_image}}" 
                     class="user-avatar" 
                     alt="{{$learner->learner_name}}"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{substr($learner->learner_name, 0, 1)}}%3C/text%3E%3C/svg%3E'">
              </div>
            </td>
            <td class="table-user">
              <a href="{{route('detail')}}?phone={{$learner->learner_phone}}" class="user-name-link">
                <div class="user-name">{{$learner->learner_name}}</div>
              </a>
            </td>
            <td class="table-phone">
              <span class="table-text">{{$learner->learner_phone}}</span>
            </td>
            <td class="table-email">
              <span class="table-text">{{$learner->learner_email ?: 'N/A'}}</span>
            </td>
           
            <td class="table-region">
              <span class="table-text">{{$learner->region ?: 'N/A'}}</span>
            </td>
            <td class="table-actions">
              <a href="{{route('detail')}}?phone={{$learner->learner_phone}}" 
                 class="btn-action" 
                 title="View Details">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer modern-table-footer">
      {{$learners->links('pagination.default')}}
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Get theme
  const isLightTheme = document.body.classList.contains('light-theme');
  
  // Chart colors
  const barColors = isLightTheme ? [
    'rgba(33, 150, 243, 0.8)',   // Blue - English
    'rgba(255, 152, 0, 0.8)',     // Orange - Korean
    'rgba(244, 67, 54, 0.8)',     // Red - Chinese
    'rgba(156, 39, 176, 0.8)',   // Purple - Japanese
    'rgba(76, 175, 80, 0.8)'      // Green - Russian
  ] : [
    'rgba(50, 205, 50, 0.8)',    // Green - English
    'rgba(255, 193, 7, 0.8)',    // Yellow - Korean
    'rgba(255, 87, 34, 0.8)',    // Orange - Chinese
    'rgba(156, 39, 176, 0.8)',   // Purple - Japanese
    'rgba(33, 150, 243, 0.8)'    // Blue - Russian
  ];

  const borderColors = isLightTheme ? [
    'rgba(33, 150, 243, 1)',
    'rgba(255, 152, 0, 1)',
    'rgba(244, 67, 54, 1)',
    'rgba(156, 39, 176, 1)',
    'rgba(76, 175, 80, 1)'
  ] : [
    'rgba(50, 205, 50, 1)',
    'rgba(255, 193, 7, 1)',
    'rgba(255, 87, 34, 1)',
    'rgba(156, 39, 176, 1)',
    'rgba(33, 150, 243, 1)'
  ];

  const textColor = isLightTheme ? '#202124' : '#e0e0e0';
  const gridColor = isLightTheme ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.1)';

  // Bar Chart
  const barCtx = document.getElementById('userBarChart');
  if (barCtx) {
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
        datasets: [{
          label: 'Number of Users',
          data: [
            {{$english_user_count}},
            {{$koeran_user_count}},
            {{$chinese_user_count}},
            {{$japanese_user_count}},
            {{$russian_user_count}}
          ],
          backgroundColor: barColors,
          borderColor: borderColors,
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
            fontSize: 13,
            padding: 15,
            boxWidth: 12,
            generateLabels: function(chart) {
              const data = chart.data;
              const labels = data.labels || [];
              const dataset = data.datasets[0];
              const legend = [];
              
              // Add individual language labels
              if (labels.length > 0 && dataset.data) {
                labels.forEach(function(label, index) {
                  if (dataset.data[index] !== undefined) {
                    legend.push({
                      text: label + ': ' + dataset.data[index].toLocaleString(),
                      fillStyle: dataset.backgroundColor[index],
                      strokeStyle: dataset.borderColor[index],
                      lineWidth: dataset.borderWidth,
                      hidden: false,
                      index: index
                    });
                  }
                });
              }
              
              // Add total users at the end
              const total = {{$learner_count}};
              legend.push({
                text: 'Total Users: ' + total.toLocaleString(),
                fillStyle: isLightTheme ? 'rgba(25, 103, 210, 0.8)' : 'rgba(50, 205, 50, 0.8)',
                strokeStyle: isLightTheme ? 'rgba(25, 103, 210, 1)' : 'rgba(50, 205, 50, 1)',
                lineWidth: 2,
                hidden: false,
                index: -1
              });
              
              return legend;
            }
          }
        },
        tooltips: {
          backgroundColor: isLightTheme ? 'rgba(0, 0, 0, 0.8)' : 'rgba(0, 0, 0, 0.9)',
          titleFontColor: '#fff',
          bodyFontColor: '#fff',
          borderColor: isLightTheme ? '#dadce0' : '#3d3d3d',
          borderWidth: 1,
          padding: 12,
          callbacks: {
            label: function(tooltipItem, data) {
              return 'Users: ' + tooltipItem.yLabel.toLocaleString();
            }
          }
        },
        scales: {
          yAxes: [{
            beginAtZero: true,
            ticks: {
              fontColor: textColor,
              callback: function(value) {
                return value.toLocaleString();
              }
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
        onClick: function(event, elements) {
          if (elements.length > 0) {
            const index = elements[0].index;
            const routes = [
              '{{route('easyLanguageUserDatas', 'english')}}',
              '{{route('easyLanguageUserDatas', 'korean')}}',
              '{{route('easyLanguageUserDatas', 'chinese')}}',
              '{{route('easyLanguageUserDatas', 'japanese')}}',
              '{{route('easyLanguageUserDatas', 'russian')}}'
            ];
            window.location.href = routes[index];
          }
        },
        onHover: function(event, elements) {
          barCtx.style.cursor = elements.length > 0 ? 'pointer' : 'default';
        }
      }
    });
  }

  // Doughnut Chart
  const doughnutCtx = document.getElementById('userDoughnutChart');
  if (doughnutCtx) {
    new Chart(doughnutCtx, {
      type: 'doughnut',
      data: {
        labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
        datasets: [{
          data: [
            {{$english_user_count}},
            {{$koeran_user_count}},
            {{$chinese_user_count}},
            {{$japanese_user_count}},
            {{$russian_user_count}}
          ],
          backgroundColor: barColors,
          borderColor: isLightTheme ? '#ffffff' : '#2d2d2d',
          borderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: {
          position: 'bottom',
          labels: {
            fontColor: textColor,
            padding: 15,
            usePointStyle: true,
            fontSize: 12
          }
        },
        tooltips: {
          backgroundColor: isLightTheme ? 'rgba(0, 0, 0, 0.8)' : 'rgba(0, 0, 0, 0.9)',
          titleFontColor: '#fff',
          bodyFontColor: '#fff',
          borderColor: isLightTheme ? '#dadce0' : '#3d3d3d',
          borderWidth: 1,
          padding: 12,
          callbacks: {
            label: function(tooltipItem, data) {
              const label = data.labels[tooltipItem.index] || '';
              const value = data.datasets[0].data[tooltipItem.index];
              const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
              const percentage = ((value / total) * 100).toFixed(1);
              return label + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
            }
          }
        },
        onClick: function(event, elements) {
          if (elements.length > 0) {
            const index = elements[0].index;
            const routes = [
              '{{route('easyLanguageUserDatas', 'english')}}',
              '{{route('easyLanguageUserDatas', 'korean')}}',
              '{{route('easyLanguageUserDatas', 'chinese')}}',
              '{{route('easyLanguageUserDatas', 'japanese')}}',
              '{{route('easyLanguageUserDatas', 'russian')}}'
            ];
            window.location.href = routes[index];
          }
        },
        onHover: function(event, elements) {
          doughnutCtx.style.cursor = elements.length > 0 ? 'pointer' : 'default';
        }
      }
    });
  }
});
</script>
@endpush
@endsection