@extends('layouts.main')

@section('content')

@if (session('msgSongReq'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msgSongReq')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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

@if(count($already_uploaded) > 0)
<div class="row mb-3">
  <div class="col-xl-12 col-md-12">
    <div class="card modern-table-card" style="border-left: 4px solid #32cd32;">
      <div class="card-header modern-table-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          <h5 class="mb-0">
            <i class="fas fa-check-circle me-2" style="color: #32cd32;"></i>Already Uploaded Requested Songs
          </h5>
          <span class="badge modern-badge" style="color: #fff; background: #32cd32;">{{count($already_uploaded)}} Songs</span>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table modern-table mb-0">
            <thead>
              <tr>
                <th scope="col" class="table-title">Requested Title</th>
                <th scope="col" class="table-artist">Artist</th>
                <th scope="col" class="table-language">Language</th>
                <th scope="col" class="table-vote" style="text-align: center;">Votes</th>
                <th scope="col" class="table-actions" style="text-align: center; width: 150px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($already_uploaded as $uploaded)
              <tr>
                <td class="table-title">
                  <div class="song-title">{{$uploaded->requested_title}}</div>
                  <small class="text-muted" style="font-size: 11px;">
                    <i class="fas fa-check-circle me-1" style="color: #32cd32;"></i>Uploaded as: {{$uploaded->song_title}}
                  </small>
                </td>
                <td class="table-artist">
                  <div>
                    <span class="table-text"><strong>Requested:</strong> {{$uploaded->requested_artist}}</span>
                  </div>
                  <div>
                    <small class="text-muted" style="font-size: 11px;">
                      <strong>Uploaded:</strong> {{$uploaded->song_artist}}
                    </small>
                  </div>
                </td>
                <td class="table-language">
                  <span class="badge" style="background: rgba(50, 205, 50, 0.2); color: #32cd32;">
                    {{ucwords($uploaded->song_type)}}
                  </span>
                </td>
                <td class="table-vote">
                  <div class="d-flex align-items-center justify-content-center gap-2" style="font-size: 14px;">
                    <span class="table-text">
                      <i class="fas fa-thumbs-up me-1" style="color: #4caf50;"></i>{{number_format($uploaded->vote)}}
                    </span>
                  </div>
                </td>
                <td class="table-actions">
                  <form method="POST" action="{{route('deleteRequestedSong')}}" style="display: inline;" onsubmit="return true;">
                    @csrf
                    <input type="hidden" name="id" value="{{$uploaded->requested_id}}"/>
                    <button type="submit" class="btn-action-danger" title="Delete Request">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

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

<style>
.table-title {
  min-width: 250px;
  font-weight: 600;
}

.table-artist {
  min-width: 150px;
}

.table-language {
  min-width: 120px;
}

.table-vote {
  text-align: center;
  min-width: 120px;
}

.table-actions {
  text-align: center;
  min-width: 120px;
  white-space: nowrap;
  padding: 12px !important;
}

.song-title {
  font-weight: 600;
  color: var(--text-primary);
  font-size: 14px;
}

.btn-action-danger {
  background: transparent;
  border: 1px solid rgba(220, 53, 69, 0.3);
  color: #dc3545;
  border-radius: 6px;
  padding: 6px 10px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-action-danger:hover {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.btn-danger {
  background: #dc3545;
  border: none;
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btn-danger:hover {
  background: #c82333;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DELETE BUTTON DEBUG ===');
    
    // Check if Bootstrap is loaded (MDB includes Bootstrap)
    if (typeof bootstrap !== 'undefined') {
        console.log('Bootstrap loaded:', typeof bootstrap);
    } else if (typeof $ !== 'undefined' && $.fn.modal) {
        console.log('Bootstrap via jQuery detected');
    } else {
        console.warn('Bootstrap not found, but MDB may provide modal functionality');
    }
    
    // Find all delete buttons
    const deleteButtons = document.querySelectorAll('.btn-action-danger');
    console.log('Found delete buttons:', deleteButtons.length);
    
    // Find all modals
    const modals = document.querySelectorAll('[id^="deleteModal"]');
    console.log('Found modals:', modals.length);
    
    // Add click listeners to delete buttons
    deleteButtons.forEach(function(button, index) {
        const targetId = button.getAttribute('data-bs-target');
        console.log(`Delete button ${index}:`, {
            target: targetId,
            button: button,
            hasDataBsToggle: button.hasAttribute('data-bs-toggle')
        });
        
        // Check if modal exists
        if (targetId) {
            const modalId = targetId.replace('#', '');
            const modal = document.getElementById(modalId);
            console.log(`Modal ${modalId} exists:`, modal !== null);
            
            if (modal) {
            // Check form inside modal
            const form = modal.querySelector('form');
            const hiddenInput = form ? form.querySelector('input[name="id"]') : null;
            console.log(`Modal ${modalId} form:`, {
                formExists: form !== null,
                formAction: form ? form.getAttribute('action') : null,
                hiddenInputExists: hiddenInput !== null,
                hiddenInputValue: hiddenInput ? hiddenInput.value : null,
                hiddenInputAttributes: hiddenInput ? {
                    name: hiddenInput.getAttribute('name'),
                    value: hiddenInput.getAttribute('value'),
                    id: hiddenInput.getAttribute('id')
                } : null
            });
            
            // Verify the value is set
            if (hiddenInput && !hiddenInput.value) {
                console.error(`WARNING: Modal ${modalId} has hidden input but value is empty!`);
                console.error('Input element:', hiddenInput);
                console.error('Input HTML:', hiddenInput.outerHTML);
            }
            }
        }
        
        // Add click event listener
        button.addEventListener('click', function(e) {
            console.log('Delete button clicked!', {
                button: this,
                target: this.getAttribute('data-bs-target'),
                event: e
            });
        });
    });
    
    // Listen for modal events
    modals.forEach(function(modal) {
        modal.addEventListener('show.bs.modal', function(e) {
            console.log('Modal showing:', modal.id);
        });
        
        modal.addEventListener('shown.bs.modal', function(e) {
            console.log('Modal shown:', modal.id);
        });
        
        // Listen for form submission
        const form = modal.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const id = this.querySelector('input[name="id"]').value;
                console.log('Form submitting:', {
                    form: this,
                    action: this.getAttribute('action'),
                    id: id,
                    method: this.getAttribute('method')
                });
            });
        }
    });
    
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
