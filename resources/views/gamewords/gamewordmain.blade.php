@extends('layouts.main')

@section('content')

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-12 col-md-12 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Game Words</div>
            <div class="activity-stat-value">{{number_format($total_words)}}</div>
            <div class="activity-stat-subtext">All languages</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-gamepad"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  {{-- Bar Chart - Game Words by Language --}}
  <div class="col-xl-12 col-md-12 mb-3">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Game Words by Language</h5>
      </div>
      <div class="card-body">
        <canvas id="gameWordBarChart" height="100"></canvas>
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
            <a href="{{route('showGameWord','english')}}" class="quick-access-card quick-access-english">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyenglish.png')}}" alt="Easy English"/>
              </div>
              <div class="quick-access-title">Easy English</div>
              <div class="quick-access-count">{{number_format($english_words)}} words</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showGameWord','korea')}}" class="quick-access-card quick-access-korean">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean"/>
              </div>
              <div class="quick-access-title">Easy Korean</div>
              <div class="quick-access-count">{{number_format($korean_words)}} words</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showGameWord','chinese')}}" class="quick-access-card quick-access-chinese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easychinese.png')}}" alt="Easy Chinese"/>
              </div>
              <div class="quick-access-title">Easy Chinese</div>
              <div class="quick-access-count">{{number_format($chinese_words)}} words</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showGameWord','japanese')}}" class="quick-access-card quick-access-japanese">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese"/>
              </div>
              <div class="quick-access-title">Easy Japanese</div>
              <div class="quick-access-count">{{number_format($japanese_words)}} words</div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6">
            <a href="{{route('showGameWord','russian')}}" class="quick-access-card quick-access-russian">
              <div class="quick-access-icon">
                <img src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian"/>
              </div>
              <div class="quick-access-title">Easy Russian</div>
              <div class="quick-access-count">{{number_format($russian_words)}} words</div>
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

    // Bar Chart - Game Words by Language
    const gameWordBarCtx = document.getElementById('gameWordBarChart');
    if (gameWordBarCtx) {
        new Chart(gameWordBarCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Easy English', 'Easy Korean', 'Easy Chinese', 'Easy Japanese', 'Easy Russian'],
                datasets: [{
                    label: 'Game Words',
                    data: [
                        {{ $english_words }},
                        {{ $korean_words }},
                        {{ $chinese_words }},
                        {{ $japanese_words }},
                        {{ $russian_words }}
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
                                    text: 'Total Game Words: {{number_format($total_words)}}',
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
