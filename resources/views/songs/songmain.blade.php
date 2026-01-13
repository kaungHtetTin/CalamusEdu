@extends('layouts.main')

@section('content')

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Songs</div>
            <div class="activity-stat-value">{{number_format($total_songs)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-music"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Artists</div>
            <div class="activity-stat-value">{{number_format($total_artists)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-user-friends"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Requested Songs</div>
            <div class="activity-stat-value">{{number_format($total_requested)}}</div>
            <div class="activity-stat-subtext">Pending requests</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-hand-paper"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  {{-- Bar Chart - Songs by Language --}}
  <div class="col-xl-12 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Songs by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="songBarChart" height="100"></canvas>
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
            <a href="{{route('showSongs','english')}}" class="quick-access-card quick-access-english">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyenglish.png')}}" alt="Easy English"/>
              </div>
              <div class="quick-access-title">Easy English</div>
              <div class="quick-access-count">{{number_format($english_songs)}} songs</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showSongs','korea')}}" class="quick-access-card quick-access-korean">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean"/>
              </div>
              <div class="quick-access-title">Easy Korean</div>
              <div class="quick-access-count">{{number_format($korean_songs)}} songs</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showSongs','chinese')}}" class="quick-access-card quick-access-chinese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easychinese.png')}}" alt="Easy Chinese"/>
              </div>
              <div class="quick-access-title">Easy Chinese</div>
              <div class="quick-access-count">{{number_format($chinese_songs)}} songs</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showSongs','japanese')}}" class="quick-access-card quick-access-japanese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese"/>
              </div>
              <div class="quick-access-title">Easy Japanese</div>
              <div class="quick-access-count">{{number_format($japanese_songs)}} songs</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showSongs','russian')}}" class="quick-access-card quick-access-russian">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian"/>
              </div>
              <div class="quick-access-title">Easy Russian</div>
              <div class="quick-access-count">{{number_format($russian_songs)}} songs</div>
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

    // Bar Chart - Songs by Language
    const songBarCtx = document.getElementById('songBarChart');
    if (songBarCtx) {
        new Chart(songBarCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
                datasets: [{
                    label: 'Songs',
                    data: [
                        {{ $english_songs }},
                        {{ $korean_songs }},
                        {{ $chinese_songs }},
                        {{ $japanese_songs }},
                        {{ $russian_songs }}
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
                                    text: 'Total Songs: {{number_format($total_songs)}}',
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
});
</script>
@endpush

@endsection
