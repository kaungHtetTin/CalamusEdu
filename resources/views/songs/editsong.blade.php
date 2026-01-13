@extends('layouts.navbar')

@section('content')

@if (session('msgSong'))
<div class="card bg-success" id="customMessageBox">
    {{session('msgSong')}}
</div>
@endif

<div class="mb-4">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4 class="mb-1">
        @if ($major=="english")
          Edit English Song
        @else
          Edit {{ucwords($major)}} Song
        @endif
      </h4>
      <p class="text-muted mb-0">Update song information</p>
    </div>
    <a href="{{route('showSongs', $major)}}" class="btn-secondary btn-sm" title="Back to Songs">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>
</div>

@if($song)
<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card">
      <div class="card-body">
        <form action="{{route('updateSong', $song->id)}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="major" value="{{$major}}"/>
          
          <div class="row mb-3">
            <div class="col-md-6 mb-3">
              <label class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" 
                     class="form-control" 
                     name="title" 
                     value="{{$song->title}}" 
                     required>
              @error('title')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>
            
            <div class="col-md-6 mb-3">
              <label class="form-label">Artist <span class="text-danger">*</span></label>
              <input type="text" 
                     class="form-control" 
                     name="artist" 
                     value="{{$song->artist}}" 
                     required>
              @error('artist')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12 mb-3">
              <label class="form-label">Drama (Optional)</label>
              <input type="text" 
                     class="form-control" 
                     name="drama" 
                     value="{{$song->drama != '...' ? $song->drama : ''}}" 
                     placeholder="Enter Drama Name Or Single Artist">
              @error('drama')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>
          </div>

          <hr>

          <div class="row mb-3">
            <div class="col-md-12">
              <h6 class="mb-3">Current Files (Leave empty to keep existing files)</h6>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
              <label class="form-label">Audio File (.mp3)</label>
              <div class="mb-2">
                <small class="text-muted">Current: {{$song->url}}.mp3</small>
              </div>
              <input type="file" 
                     accept=".mp3" 
                     name="audioFile" 
                     class="form-control">
              <small class="text-muted">Leave empty to keep current file</small>
              @error('audioFile')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
              <label class="form-label">Mobile Image (.png)</label>
              <div class="mb-2">
                <img src="https://www.calamuseducation.com/uploads/songs/image/{{$song->url}}.png" 
                     style="width: 100px; height: 56px; border-radius: 6px; object-fit: cover;"
                     onerror="this.style.display='none'">
              </div>
              <input type="file" 
                     accept=".png" 
                     name="imageFile" 
                     class="form-control">
              <small class="text-muted">Leave empty to keep current file</small>
              @error('imageFile')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
              <label class="form-label">Web Image (.png)</label>
              <div class="mb-2">
                <img src="https://www.calamuseducation.com/uploads/songs/web/{{$song->url}}.png" 
                     style="width: 100px; height: 56px; border-radius: 6px; object-fit: cover;"
                     onerror="this.style.display='none'">
              </div>
              <input type="file" 
                     accept=".png" 
                     name="imageFileWeb" 
                     class="form-control">
              <small class="text-muted">Leave empty to keep current file</small>
              @error('imageFileWeb')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
              <label class="form-label">Lyrics File (.txt)</label>
              <div class="mb-2">
                <small class="text-muted">Current: {{$song->url}}.txt</small>
              </div>
              <input type="file" 
                     accept=".txt" 
                     name="lyricsFile" 
                     class="form-control">
              <small class="text-muted">Leave empty to keep current file</small>
              @error('lyricsFile')
                <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
              @enderror
            </div>
          </div>

          <hr>

          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary">
              <i class="fas fa-save me-1"></i>Update Song
            </button>
            <a href="{{route('showSongs', $major)}}" class="btn-secondary">
              <i class="fas fa-times me-1"></i>Cancel
            </a>
          </div>
        </form>
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

@endsection
