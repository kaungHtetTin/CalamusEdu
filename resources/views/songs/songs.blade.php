@extends('layouts.navbar')

@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a song' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection


@section('content')

<div class="mb-4">
  <h4 class="mb-1">Songs ({{ucwords($major)}})</h4>
  <p class="text-muted mb-0">Manage and view all songs for {{ucwords($major)}} language</p>
</div>

{{-- Statistics Cards - Vimeo Style --}}
<div class="row mb-3">
  <div class="col-xl-2-4 col-lg-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Songs</div>
            <div class="activity-stat-value">{{number_format($total_songs)}}</div>
            <div class="activity-stat-subtext">{{ucwords($major)}} language</div>
          </div>
          <div class="activity-stat-icon learns">
            <i class="fas fa-music"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-lg-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Likes</div>
            <div class="activity-stat-value">{{number_format($total_likes)}}</div>
            <div class="activity-stat-subtext">All songs</div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-heart"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-lg-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Downloads</div>
            <div class="activity-stat-value">{{number_format($total_downloads)}}</div>
            <div class="activity-stat-subtext">All songs</div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-download"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-lg-4 col-md-6 mb-3">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Total Artists</div>
            <div class="activity-stat-value">{{number_format($total_artists)}}</div>
            <div class="activity-stat-subtext">{{ucwords($major)}} language</div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-user-friends"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2-4 col-lg-4 col-md-6 mb-3">
    <a href="{{route('showRequestedSong', $major)}}" class="text-decoration-none">
      <div class="card activity-stat-card" style="cursor: pointer; transition: transform 0.2s ease;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="activity-stat-label">Requested Songs</div>
              <div class="activity-stat-value">{{number_format($total_requested)}}</div>
              <div class="activity-stat-subtext">{{ucwords($major)}} language</div>
            </div>
            <div class="activity-stat-icon active-users">
              <i class="fas fa-hand-paper"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-music me-2"></i>All Songs
      </h5>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <form action="{{ route('showSongs', $major) }}" method="GET" class="d-flex align-items-center search-form flex-grow-1">
          <div class="search-input-wrapper flex-grow-1">
            <input type="text" 
                   name="search" 
                   class="form-control modern-search-input" 
                   placeholder="Search..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            @if(!empty($search))
              <a href="{{ route('showSongs', $major) }}" class="clear-search" title="Clear search">
                <i class="fas fa-times"></i>
              </a>
            @endif
          </div>
          <select name="artist" class="form-control modern-filter-select" style="width: auto; min-width: 140px; margin-left: 5px;">
            <option value="">All Artists</option>
            @foreach($artists as $artist)
              <option value="{{$artist->name}}" {{$filter_artist == $artist->name ? 'selected' : ''}}>{{$artist->name}}</option>
            @endforeach
          </select>
          <button type="submit" class="btn-primary btn-sm" title="Search" style="margin-left: 5px;">
            <i class="fas fa-search"></i>
          </button>
          @if(!empty($search) || !empty($filter_artist))
            <a href="{{ route('showSongs', $major) }}" class="btn-secondary btn-sm" title="Clear filters" style="margin-left: 5px;">
              <i class="fas fa-times"></i>
            </a>
          @endif
        </form>
        <span class="badge modern-badge" style="color: #fff;">{{number_format($total_songs)}} Total</span>
        <a href="{{route('showAddSong',$major)}}" class="btn-primary btn-sm" title="Add New Song">
          <i class="fas fa-plus"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    @if(!empty($search) || !empty($filter_artist))
    <div class="search-results-info">
      <div class="alert alert-info mb-0 border-0 rounded-0" style="background: linear-gradient(90deg, rgba(50, 205, 50, 0.1) 0%, transparent 100%); border-left: 4px solid #32cd32 !important;">
        <i class="fas fa-info-circle me-2"></i>
        @if(!empty($search))
          Showing search results for: <strong>"{{ $search }}"</strong>
        @endif
        @if(!empty($filter_artist))
          @if(!empty($search)), @endif
          Filtered by artist: <strong>"{{ $filter_artist }}"</strong>
        @endif
        <a href="{{ route('showSongs', $major) }}" class="ms-2 text-decoration-none">
          <i class="fas fa-times me-1"></i>Clear
        </a>
      </div>
    </div>
    @endif
    <div class="table-responsive">
      <table class="table modern-table mb-0">
        <thead>
          <tr>
            <th scope="col" class="table-image"></th>
            <th scope="col" class="table-title">Title</th>
            <th scope="col" class="table-artist">Artist</th>
            <th scope="col" class="table-drama">Drama</th>
            <th scope="col" class="table-stats" style="text-align: center">Stats</th>
            <th scope="col" class="table-actions" style="text-align: center;width: 150px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($songs as $song)
          <tr>
            <td class="table-image">
              <div class="song-image-wrapper">
                <img src="https://www.calamuseducation.com/uploads/songs/image/{{$song->url}}.png" 
                     class="song-image" 
                     alt="{{$song->title}}"
                     width="80"
                     height="45"
                     style="width: 80px; height: 45px; object-fit: cover; border-radius: 6px;"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'45\'%3E%3Crect width=\'80\' height=\'45\' fill=\'%233d3d3d\' rx=\'6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'12\'%3EMusic%3C/text%3E%3C/svg%3E'; this.style.width='80px'; this.style.height='45px'; this.style.borderRadius='6px';">
              </div>
            </td>
            <td class="table-title">
              <div class="song-title">{{$song->title}}</div>
            </td>
            <td class="table-artist">
              <span class="table-text">{{$song->artist}}</span>
            </td>
            <td class="table-drama">
              <span class="table-text">{{$song->drama != '...' ? $song->drama : 'N/A'}}</span>
            </td>
            <td class="table-stats">
              <div class="d-flex align-items-center justify-content-center gap-2" style="font-size: 12px;">
                <span class="table-text">
                  <i class="fas fa-heart me-1" style="color: #e91e63;"></i>{{number_format($song->like_count)}}
                </span>
                <span class="table-text">
                  <i class="fas fa-download me-1" style="color: #2196f3;"></i>{{number_format($song->download_count)}}
                </span>
              </div>
            </td>
            <td class="table-actions">
              <a href="{{route('showSongDetail', $song->id)}}?major={{$major}}" 
                 class="btn-action-primary" 
                 title="View Details">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{route('editSong', $song->id)}}?major={{$major}}" 
                 class="btn-action-warning" 
                 title="Edit Song">
                <i class="fas fa-edit"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-music fa-2x mb-2" style="opacity: 0.3;"></i>
                <p class="mb-0">No songs found</p>
                @if(!empty($search) || !empty($filter_artist))
                  <small>Try adjusting your search or filter criteria</small>
                @endif
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer modern-table-footer">
      {{$songs->links('pagination.default')}}
    </div>
  </div>
</div>

@push('styles')
<style>
.col-xl-2-4 {
  flex: 0 0 auto;
  width: 20%;
}

@media (max-width: 1399px) {
  .col-xl-2-4 {
    width: 25%;
  }
}

@media (max-width: 1199px) {
  .col-xl-2-4 {
    width: 33.333333%;
  }
}

.activity-stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

a .activity-stat-card {
  text-decoration: none;
}

a:hover .activity-stat-card {
  text-decoration: none;
}

.song-image-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 80px;
  height: 45px;
  min-width: 80px;
  min-height: 45px;
  max-width: 80px;
  max-height: 45px;
  border-radius: 6px;
  overflow: hidden;
  background: var(--bg-tertiary);
  flex-shrink: 0;
}

.song-image-wrapper img {
  border-radius: 6px;
}

.song-image {
  width: 80px;
  height: 45px;
  min-width: 80px;
  min-height: 45px;
  max-width: 80px;
  max-height: 45px;
  object-fit: cover;
  border-radius: 6px;
  display: block;
  overflow: hidden;
}

.song-title {
  font-weight: 600;
  color: var(--text-primary);
  font-size: 14px;
}

.table-image {
  width: 100px;
  min-width: 100px;
  padding: 12px !important;
  vertical-align: middle;
}

.table-title {
  min-width: 200px;
  font-weight: 600;
}

.table-artist,
.table-drama {
  min-width: 150px;
}

.table-stats {
  text-align: center;
  min-width: 120px;
  max-width: 140px;
}

.table-actions {
  text-align: center;
  min-width: 120px;
  white-space: nowrap;
  padding: 12px !important;
}

.search-form {
  display: flex;
  align-items: center;
  gap: 5px;
}

.search-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  min-width: 200px;
  flex: 1;
}

.modern-filter-select {
  height: 40px;
  border: 2px solid rgba(61, 61, 61, 0.5);
  border-radius: 20px;
  padding: 0 12px;
  background-color: var(--bg-secondary);
  color: var(--text-primary);
  font-size: 13px;
  min-width: 140px;
}

.modern-filter-select:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px var(--primary-color-light);
}

body.light-theme .modern-filter-select {
  background-color: #ffffff;
  border-color: rgba(218, 220, 224, 0.8);
  color: #202124;
}

body.light-theme .modern-filter-select:focus {
  border-color: #1967d2;
  box-shadow: 0 0 0 3px rgba(25, 103, 210, 0.1);
}

@media (max-width: 1200px) {
  .search-form {
    flex-wrap: wrap;
  }
  
  .search-input-wrapper {
    min-width: 180px;
  }
  
  .modern-filter-select {
    min-width: 130px;
  }
}

@media (max-width: 992px) {
  .modern-table-header {
    flex-direction: column;
    align-items: flex-start !important;
  }
  
  .modern-table-header > div:last-child {
    width: 100%;
    margin-top: 10px;
  }
  
  .search-form {
    width: 100%;
    flex-wrap: wrap;
  }
  
  .search-input-wrapper {
    width: 100% !important;
    min-width: 100% !important;
    margin-left: 0 !important;
    margin-bottom: 5px;
  }
  
  .modern-filter-select {
    width: 100% !important;
    min-width: 100% !important;
    margin-left: 0 !important;
    margin-top: 5px;
  }
}

@media (max-width: 768px) {
  .modern-table-header > div:last-child {
    flex-direction: column;
    align-items: stretch !important;
  }
  
  .badge,
  .btn-primary {
    width: 100%;
    margin-top: 5px;
    text-align: center;
  }
  
  .search-form {
    margin-bottom: 10px;
  }
}
</style>
@endpush
@endsection