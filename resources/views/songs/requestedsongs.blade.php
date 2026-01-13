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
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4 class="mb-1">Requested Songs ({{ucwords($major)}})</h4>
      <p class="text-muted mb-0">View and manage song requests for {{ucwords($major)}} language</p>
    </div>
    <a href="{{route('showSongs', $major)}}" class="btn-secondary btn-sm" title="Back to Songs">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-hand-paper me-2"></i>Requested Songs
      </h5>
      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('showRequestedSong', $major) }}" method="GET" class="d-flex align-items-center search-form">
          <div class="search-input-wrapper">
            <input type="text" 
                   name="search" 
                   class="form-control modern-search-input" 
                   placeholder="Search by title or artist..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            @if(!empty($search))
              <a href="{{ route('showRequestedSong', $major) }}" class="clear-search" title="Clear search">
                <i class="fas fa-times"></i>
              </a>
            @endif
          </div>
          <button type="submit" class="btn-primary btn-sm" title="Search" style="margin-left: 5px;">
            <i class="fas fa-search"></i>
            <span>Search</span>
          </button>
        </form>
        <span class="badge modern-badge" style="color: #fff;">{{number_format($total_requested)}} Total</span>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    @if(!empty($search))
    <div class="search-results-info">
      <div class="alert alert-info mb-0 border-0 rounded-0" style="background: linear-gradient(90deg, rgba(50, 205, 50, 0.1) 0%, transparent 100%); border-left: 4px solid #32cd32 !important;">
        <i class="fas fa-info-circle me-2"></i>
        Showing search results for: <strong>"{{ $search }}"</strong>
        <a href="{{ route('showRequestedSong', $major) }}" class="ms-2 text-decoration-none">
          <i class="fas fa-times me-1"></i>Clear
        </a>
      </div>
    </div>
    @endif
    <div class="table-responsive">
      <table class="table modern-table mb-0">
        <thead>
          <tr>
            <th scope="col" class="table-title">Title</th>
            <th scope="col" class="table-artist">Artist</th>
            <th scope="col" class="table-vote" style="text-align: center;">Votes</th>
            <th scope="col" class="table-actions" style="text-align: center; width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($songs as $song)
          <tr>
            <td class="table-title">
              <div class="song-title">{{$song->title}}</div>
            </td>
            <td class="table-artist">
              <span class="table-text">{{$song->artist}}</span>
            </td>
            <td class="table-vote">
              <div class="d-flex align-items-center justify-content-center gap-2" style="font-size: 14px;">
                <span class="table-text">
                  <i class="fas fa-thumbs-up me-1" style="color: #4caf50;"></i>{{number_format($song->vote)}}
                </span>
              </div>
            </td>
            <td class="table-actions">
              <button type="button" 
                      class="btn-action-danger" 
                      data-bs-toggle="modal" 
                      data-bs-target="#deleteModal{{$song->id}}" 
                      title="Delete Request">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>

          <!-- Delete Modal -->
          <div class="modal fade" id="deleteModal{{$song->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$song->id}}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel{{$song->id}}">Delete Requested Song</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete the requested song <strong>"{{$song->title}}"</strong> by <strong>{{$song->artist}}</strong>?</p>
                  <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <form method="POST" action="{{route('deleteRequestedSong')}}" style="display: inline;">
                    @csrf
                    <input type="hidden" value="{{$song->id}}" name="id"/>
                    <button type="submit" class="btn-danger">
                      <i class="fas fa-trash me-1"></i>Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @empty
          <tr>
            <td colspan="4" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-hand-paper fa-2x mb-2" style="opacity: 0.3;"></i>
                <p class="mb-0">No requested songs found</p>
                @if(!empty($search))
                  <small>Try adjusting your search criteria</small>
                @else
                  <small>There are no song requests for {{ucwords($major)}} language</small>
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
.table-title {
  min-width: 250px;
  font-weight: 600;
}

.table-artist {
  min-width: 200px;
}

.table-vote {
  text-align: center;
  min-width: 120px;
}

.table-actions {
  text-align: center;
  min-width: 100px;
  white-space: nowrap;
  padding: 12px !important;
}

.song-title {
  font-weight: 600;
  color: var(--text-primary);
  font-size: 14px;
}

.search-form {
  display: flex;
  align-items: center;
}

.search-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  min-width: 200px;
}

.clear-search {
  position: absolute;
  right: 10px;
  color: var(--text-secondary);
  text-decoration: none;
  z-index: 10;
}

.clear-search:hover {
  color: var(--text-primary);
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
}
</style>
@endpush

@endsection