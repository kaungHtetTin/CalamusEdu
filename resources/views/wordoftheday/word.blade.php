@extends('layouts.navbar')

@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a word' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>

@endsection


@section('content')

<div class="mb-4">
  <h4 class="mb-1">Words Of The Day ({{ucwords($major)}})</h4>
  <p class="text-muted mb-0">Manage and view all words for {{ucwords($major)}} language</p>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-calendar-day me-2"></i>All Words
      </h5>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="badge modern-badge" style="color: #fff;">{{number_format($words->total())}} Total</span>
        <a href="{{route('showWordDayAdding',$major)}}" class="btn-primary btn-sm" title="Add New Word">
          <i class="fas fa-plus"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table modern-table mb-0">
        <thead>
          <tr>
            <th scope="col" class="table-image"></th>
            <th scope="col" class="table-title">{{ucwords($major)}}</th>
            <th scope="col" class="table-artist">Myanmar</th>
            <th scope="col" class="table-drama">Speech</th>
            <th scope="col" class="table-actions" style="text-align: center;width: 150px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($words as $word)
          <tr>
            <td class="table-image">
              <div class="song-image-wrapper">
                <img src="{{$word->thumb}}" 
                     class="song-image" 
                     alt="{{$word->$major}}"
                     width="80"
                     height="45"
                     style="width: 80px; height: 45px; object-fit: cover; border-radius: 6px;"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'45\'%3E%3Crect width=\'80\' height=\'45\' fill=\'%233d3d3d\' rx=\'6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'12\'%3EWord%3C/text%3E%3C/svg%3E'; this.style.width='80px'; this.style.height='45px'; this.style.borderRadius='6px';">
              </div>
            </td>
            <td class="table-title">
              <div class="song-title">{{$word->$major}}</div>
            </td>
            <td class="table-artist">
              <span class="table-text">{{$word->myanmar}}</span>
            </td>
            <td class="table-drama">
              <span class="table-text">{{$word->speech}}</span>
            </td>
            <td class="table-actions">
              <form method="POST" action="{{route('deleteWordDay')}}" style="display: inline-block;">
                @csrf
                <input type="hidden" name="id" value="{{$word->id}}">
                <input type="hidden" name="major" value="{{$major}}">
                <button type="submit" class="btn-action-danger" title="Delete Word">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-calendar-day fa-2x mb-2" style="opacity: 0.3;"></i>
                <p class="mb-0">No words found</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer modern-table-footer">
      {{$words->links('pagination.default')}}
    </div>
  </div>
</div>

@push('styles')
<style>
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

.table-actions {
  text-align: center;
  min-width: 120px;
  white-space: nowrap;
  padding: 12px !important;
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
}
</style>
@endpush
@endsection