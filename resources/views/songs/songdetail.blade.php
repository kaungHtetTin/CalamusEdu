@extends('layouts.navbar')

@section('content')

<div class="mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4 class="mb-1">Song Details</h4>
      <p class="text-muted mb-0">View song information for {{ucwords($major)}} language</p>
    </div>
    <a href="{{route('showSongs', $major)}}" class="btn-secondary btn-sm" title="Back to Songs">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

@if($song)
<div class="row">
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Song Information & Statistics</h5>
        <a href="{{route('editSong', $song->id)}}?major={{$major}}" style="width: 100px; height: 30px;" class="btn-action-warning" title="Edit Song">
          <i class="fas fa-edit me-1"></i>Edit Song
        </a>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
            <div class="song-detail-image-wrapper">
              <img src="https://www.calamuseducation.com/uploads/songs/image/{{$song->url}}.png" 
                   class="song-detail-image" 
                   alt="{{$song->title}}"
                   style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                   onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'113\'%3E%3Crect width=\'200\' height=\'113\' fill=\'%233d3d3d\' rx=\'6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'14\'%3EMusic%3C/text%3E%3C/svg%3E'">
            </div>
          </div>
          <div class="col-md-8 col-sm-12">
            <div class="table-responsive">
              <table class="table song-detail-table mb-0">
                <tbody>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-heading me-2 text-muted"></i>Title
                    </td>
                    <td><strong>{{$song->title}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-user me-2 text-muted"></i>Artist
                    </td>
                    <td><strong>{{$song->artist}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-film me-2 text-muted"></i>Drama
                    </td>
                    <td><strong>{{$song->drama != '...' ? $song->drama : 'N/A'}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-language me-2 text-muted"></i>Language
                    </td>
                    <td><strong>{{ucwords($song->type)}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-heart me-2" style="color: #e91e63;"></i>Likes
                    </td>
                    <td><strong>{{number_format($song->like_count)}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-download me-2" style="color: #2196f3;"></i>Downloads
                    </td>
                    <td><strong>{{number_format($song->download_count)}}</strong></td>
                  </tr>
                  <tr>
                    <td class="table-label">
                      <i class="fas fa-comments me-2" style="color: #ff9800;"></i>Comments
                    </td>
                    <td><strong>{{number_format($song->comment_count)}}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Files</h5>
      </div>
      <div class="card-body">
        <div class="mb-2">
          <a href="https://www.calamuseducation.com/uploads/songs/audio/{{$song->url}}.mp3" target="_blank" class="btn-secondary btn-sm w-100">
            <i class="fas fa-music me-1"></i>Audio File
          </a>
        </div>
        <div class="mb-2">
          <a href="https://www.calamuseducation.com/uploads/songs/lyrics/{{$song->url}}.txt" target="_blank" class="btn-secondary btn-sm w-100">
            <i class="fas fa-file-alt me-1"></i>Lyrics File
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="card">
  <div class="card-body text-center py-5">
    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
    <h5>Song not found</h5>
    <a href="{{route('showSongs', $major)}}" class="btn-primary">Back to Songs</a>
  </div>
</div>
@endif

@push('styles')
<style>
.song-detail-table {
  margin-bottom: 0;
  border: none;
}

.song-detail-table td {
  padding: 12px 15px;
  vertical-align: middle;
  border: none;
  border-bottom: none;
}

.song-detail-table tr {
  border: none;
}

.song-detail-table .table-label {
  font-weight: 600;
  color: var(--text-secondary);
  white-space: nowrap;
}

.song-detail-image-wrapper {
  width: 100%;
  max-width: 200px;
  aspect-ratio: 16 / 9;
  border-radius: 8px;
  overflow: hidden;
  background: var(--bg-tertiary);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.song-detail-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
  display: block;
}
</style>
@endpush

@endsection
