@extends('layouts.main')

@section('content')

<div class="row">
  {{-- Bar Chart - Lessons by Language --}}
  <div class="col-xl-8 col-md-12 mb-4">
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
  <div class="col-xl-4 col-md-12 mb-4">
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

<div class="row">
  {{-- Language Cards --}}
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Quick Access</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('lessons.byLanguage','english')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded lesson-card" style="background-color: rgba(33, 150, 243, 0.1); border: 2px solid rgba(33, 150, 243, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(33, 150, 243, 0.2)'; this.style.borderColor='rgba(33, 150, 243, 0.5)'" onmouseout="this.style.backgroundColor='rgba(33, 150, 243, 0.1)'; this.style.borderColor='rgba(33, 150, 243, 0.3)'">
                <img src="{{asset('public/img/easyenglish.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy English</div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('lessons.byLanguage','korea')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded lesson-card" style="background-color: rgba(255, 152, 0, 0.1); border: 2px solid rgba(255, 152, 0, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(255, 152, 0, 0.2)'; this.style.borderColor='rgba(255, 152, 0, 0.5)'" onmouseout="this.style.backgroundColor='rgba(255, 152, 0, 0.1)'; this.style.borderColor='rgba(255, 152, 0, 0.3)'">
                <img src="{{asset('public/img/easykorean.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Korean</div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('lessons.byLanguage','chinese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded lesson-card" style="background-color: rgba(244, 67, 54, 0.1); border: 2px solid rgba(244, 67, 54, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(244, 67, 54, 0.2)'; this.style.borderColor='rgba(244, 67, 54, 0.5)'" onmouseout="this.style.backgroundColor='rgba(244, 67, 54, 0.1)'; this.style.borderColor='rgba(244, 67, 54, 0.3)'">
                <img src="{{asset('public/img/easychinese.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Chinese</div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('lessons.byLanguage','japanese')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded lesson-card" style="background-color: rgba(156, 39, 176, 0.1); border: 2px solid rgba(156, 39, 176, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(156, 39, 176, 0.2)'; this.style.borderColor='rgba(156, 39, 176, 0.5)'" onmouseout="this.style.backgroundColor='rgba(156, 39, 176, 0.1)'; this.style.borderColor='rgba(156, 39, 176, 0.3)'">
                <img src="{{asset('public/img/easyjapanese.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Japanese</div>
              </div>
            </a>
          </div>

          <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <a href="{{route('lessons.byLanguage','russian')}}" class="text-decoration-none quick-access-link">
              <div class="text-center p-3 rounded lesson-card" style="background-color: rgba(76, 175, 80, 0.1); border: 2px solid rgba(76, 175, 80, 0.3); transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(76, 175, 80, 0.2)'; this.style.borderColor='rgba(76, 175, 80, 0.5)'" onmouseout="this.style.backgroundColor='rgba(76, 175, 80, 0.1)'; this.style.borderColor='rgba(76, 175, 80, 0.3)'">
                <img src="{{asset('public/img/easyrussian.png')}}" style="width: 50px;height:50px" class="mb-2"/>
                <div class="fw-bold">Easy Russian</div>
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

    // Bar Chart - Lessons by Language
    const lessonBarCtx = document.getElementById('lessonBarChart').getContext('2d');
    new Chart(lessonBarCtx, {
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

    // Doughnut Chart - Video vs Non-Video
    const lessonTypeCtx = document.getElementById('lessonTypeChart').getContext('2d');
    new Chart(lessonTypeCtx, {
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

    // Pie Chart - VIP vs Regular
    const lessonVipCtx = document.getElementById('lessonVipChart').getContext('2d');
    new Chart(lessonVipCtx, {
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

    // Doughnut Chart - Categories by Language
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
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
                    padding: 15,
                    generateLabels: function(chart) {
                        const data = chart.data;
                        if (data.labels.length && data.datasets.length) {
                            const labels = data.labels;
                            const dataset = data.datasets[0];
                            const total = {{$total_categories}};
                            return labels.map(function(label, i) {
                                const value = dataset.data[i];
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return {
                                    text: label + ': ' + value + ' (' + percentage + '%)',
                                    fillStyle: dataset.backgroundColor[i],
                                    strokeStyle: dataset.borderColor[i],
                                    fontColor: textColor
                                };
                            }).concat([{
                                text: 'Total Categories: {{number_format($total_categories)}}',
                                fillStyle: 'transparent',
                                strokeStyle: 'transparent',
                                fontColor: textColor,
                                fontStyle: 'bold'
                            }]);
                        }
                        return [];
                    }
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
});
</script>
@endpush

@endsection