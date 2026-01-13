@extends('layouts.navbar')

@section('content')

@if (session('msgSong'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msgSong')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #32cd32;">
        <h5 class="language-data-title mb-0" style="color: #32cd32;">
          <i class="fas fa-music me-2"></i>
          @if ($major=="english")
            Add New Song - English
          @else
            Add New Song - {{ucwords($major)}}
          @endif
        </h5>
        <a href="{{route('showSongs', $major)}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('addSong',$major)}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="major" value="{{$major}}"/>
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Song Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="title"
                       name="title" 
                       value="{{old('title')}}"
                       placeholder="Enter Title Of Song"
                       required>
                @error('title')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="artist" class="form-label">Artist <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="artist"
                       name="artist" 
                       value="{{old('artist')}}"
                       placeholder="Enter Artist Name"
                       required>
                @error('artist')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="drama" class="form-label">Drama (Optional)</label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="drama"
                       name="drama" 
                       value="{{old('drama')}}"
                       placeholder="Enter Drama Name Or Single Artist">
                @error('drama')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-upload me-2"></i>Upload Files
            </h6>

            <div class="row">
              <div class="col-lg-6 col-md-6 mb-4">
                <label for="audioFile" class="form-label">Audio File (.mp3) <span class="text-danger">*</span></label>
                <div class="file-upload-wrapper">
                  <div class="file-upload-area" id="audio_upload_area">
                    <input type="file" class="d-none" id="audioFile" name="audioFile" accept=".mp3" required>
                    <div class="upload-placeholder" id="audio_placeholder">
                      <i class="fas fa-music fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload audio file</p>
                      <small class="text-muted">MP3 format (Required)</small>
                    </div>
                    <div class="file-preview d-none" id="audio_preview">
                      <i class="fas fa-file-audio fa-3x mb-2"></i>
                      <div class="file-name-wrapper">
                        <span class="file-name" id="audio_file_name"></span>
                        <button type="button" class="btn-remove-file" id="audio_remove_btn" title="Remove file">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                @error('audioFile')
                  <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                @enderror
              </div>

              <div class="col-lg-6 col-md-6 mb-4">
                <label for="lyricsFile" class="form-label">Lyrics File (.txt) <span class="text-danger">*</span></label>
                <div class="file-upload-wrapper">
                  <div class="file-upload-area" id="lyrics_upload_area">
                    <input type="file" class="d-none" id="lyricsFile" name="lyricsFile" accept=".txt" required>
                    <div class="upload-placeholder" id="lyrics_placeholder">
                      <i class="fas fa-file-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload lyrics file</p>
                      <small class="text-muted">TXT format (Required)</small>
                    </div>
                    <div class="file-preview d-none" id="lyrics_preview">
                      <i class="fas fa-file-alt fa-3x mb-2"></i>
                      <div class="file-name-wrapper">
                        <span class="file-name" id="lyrics_file_name"></span>
                        <button type="button" class="btn-remove-file" id="lyrics_remove_btn" title="Remove file">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                @error('lyricsFile')
                  <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6 col-md-6 mb-4">
                <label for="imageFile" class="form-label">Mobile Image (.png) <span class="text-danger">*</span></label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="mobile_image_upload_area">
                    <input type="file" class="d-none" id="imageFile" name="imageFile" accept=".png" required>
                    <div class="upload-placeholder" id="mobile_image_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload mobile image</p>
                      <small class="text-muted">PNG format (Required)</small>
                    </div>
                    <div class="image-preview d-none" id="mobile_image_preview">
                      <img id="mobile_image_preview_img" src="" alt="Mobile Image Preview">
                      <button type="button" class="btn-remove-image" id="mobile_image_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
                @error('imageFile')
                  <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                @enderror
              </div>

              <div class="col-lg-6 col-md-6 mb-4">
                <label for="imageFileWeb" class="form-label">Web Image (.png) <span class="text-danger">*</span></label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="web_image_upload_area">
                    <input type="file" class="d-none" id="imageFileWeb" name="imageFileWeb" accept=".png" required>
                    <div class="upload-placeholder" id="web_image_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload web image</p>
                      <small class="text-muted">PNG format (Required)</small>
                    </div>
                    <div class="image-preview d-none" id="web_image_preview">
                      <img id="web_image_preview_img" src="" alt="Web Image Preview">
                      <button type="button" class="btn-remove-image" id="web_image_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
                @error('imageFileWeb')
                  <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('showSongs', $major)}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Add Song</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Audio file upload
    const audioInput = document.getElementById('audioFile');
    const audioUploadArea = document.getElementById('audio_upload_area');
    const audioPlaceholder = document.getElementById('audio_placeholder');
    const audioPreview = document.getElementById('audio_preview');
    const audioFileName = document.getElementById('audio_file_name');
    const audioRemoveBtn = document.getElementById('audio_remove_btn');

    audioUploadArea.addEventListener('click', function() {
        audioInput.click();
    });

    audioInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            audioFileName.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
            audioPlaceholder.classList.add('d-none');
            audioPreview.classList.remove('d-none');
        }
    });

    audioRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        audioInput.value = '';
        audioPlaceholder.classList.remove('d-none');
        audioPreview.classList.add('d-none');
        audioFileName.textContent = '';
    });

    // Lyrics file upload
    const lyricsInput = document.getElementById('lyricsFile');
    const lyricsUploadArea = document.getElementById('lyrics_upload_area');
    const lyricsPlaceholder = document.getElementById('lyrics_placeholder');
    const lyricsPreview = document.getElementById('lyrics_preview');
    const lyricsFileName = document.getElementById('lyrics_file_name');
    const lyricsRemoveBtn = document.getElementById('lyrics_remove_btn');

    lyricsUploadArea.addEventListener('click', function() {
        lyricsInput.click();
    });

    lyricsInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            lyricsFileName.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
            lyricsPlaceholder.classList.add('d-none');
            lyricsPreview.classList.remove('d-none');
        }
    });

    lyricsRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        lyricsInput.value = '';
        lyricsPlaceholder.classList.remove('d-none');
        lyricsPreview.classList.add('d-none');
        lyricsFileName.textContent = '';
    });

    // Mobile image upload
    const mobileImageInput = document.getElementById('imageFile');
    const mobileImageUploadArea = document.getElementById('mobile_image_upload_area');
    const mobileImagePlaceholder = document.getElementById('mobile_image_placeholder');
    const mobileImagePreview = document.getElementById('mobile_image_preview');
    const mobileImagePreviewImg = document.getElementById('mobile_image_preview_img');
    const mobileImageRemoveBtn = document.getElementById('mobile_image_remove_btn');

    mobileImageUploadArea.addEventListener('click', function() {
        mobileImageInput.click();
    });

    mobileImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mobileImagePreviewImg.src = e.target.result;
                mobileImagePlaceholder.classList.add('d-none');
                mobileImagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    mobileImageRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        mobileImageInput.value = '';
        mobileImagePlaceholder.classList.remove('d-none');
        mobileImagePreview.classList.add('d-none');
        mobileImagePreviewImg.src = '';
    });

    // Web image upload
    const webImageInput = document.getElementById('imageFileWeb');
    const webImageUploadArea = document.getElementById('web_image_upload_area');
    const webImagePlaceholder = document.getElementById('web_image_placeholder');
    const webImagePreview = document.getElementById('web_image_preview');
    const webImagePreviewImg = document.getElementById('web_image_preview_img');
    const webImageRemoveBtn = document.getElementById('web_image_remove_btn');

    webImageUploadArea.addEventListener('click', function() {
        webImageInput.click();
    });

    webImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                webImagePreviewImg.src = e.target.result;
                webImagePlaceholder.classList.add('d-none');
                webImagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    webImageRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        webImageInput.value = '';
        webImagePlaceholder.classList.remove('d-none');
        webImagePreview.classList.add('d-none');
        webImagePreviewImg.src = '';
    });
});
</script>
@endpush

<style>
.file-upload-wrapper {
    margin-bottom: 1rem;
}

.file-upload-area {
    position: relative;
    border: 2px dashed rgba(156, 39, 176, 0.6);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 150px;
}

.file-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

.upload-placeholder {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    position: relative;
    z-index: 1;
}

.upload-placeholder i {
    color: #9c27b0;
    font-size: 2.5rem !important;
    margin-bottom: 10px;
    display: block;
}

.upload-placeholder p {
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 5px !important;
    color: var(--text-primary);
}

.upload-placeholder small {
    font-size: 11px;
    color: var(--text-secondary);
    display: block;
}

.file-preview {
    text-align: center;
    padding: 20px;
    color: var(--text-primary);
    position: relative;
    z-index: 1;
    width: 100%;
}

.file-preview i {
    color: #9c27b0;
    font-size: 2.5rem !important;
    margin-bottom: 10px;
    display: block;
}

.file-name-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 6px 8px;
    background: rgba(156, 39, 176, 0.1);
    border-radius: 6px;
    max-width: 90%;
}

.file-name {
    font-size: 12px;
    font-weight: 500;
    word-break: break-word;
    color: var(--text-primary);
    flex: 1;
    min-width: 0;
}

.btn-remove-file {
    background: transparent;
    color: var(--text-secondary);
    border: none;
    border-radius: 4px;
    width: 20px;
    height: 20px;
    min-width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    flex-shrink: 0;
}

.btn-remove-file i {
    font-size: 11px;
}

.btn-remove-file:hover {
    background: rgba(220, 53, 69, 0.15);
    color: #dc3545;
}

.image-upload-wrapper {
    margin-bottom: 1rem;
}

.image-upload-area {
    position: relative;
    border: 2px dashed rgba(156, 39, 176, 0.6);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 16 / 9;
    max-width: 300px;
}

.image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

.image-preview {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

.btn-remove-image {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
    z-index: 10;
}

.btn-remove-image:hover {
    background: #c82333;
}

body.dark-theme .file-upload-area,
body.dark-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.7);
    background: rgba(255, 255, 255, 0.02);
}

body.dark-theme .file-upload-area:hover,
body.dark-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.1);
}

body.light-theme .file-upload-area,
body.light-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.5);
    background: #f8f9fa;
}

body.light-theme .file-upload-area:hover,
body.light-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.08);
}

@media (max-width: 768px) {
    .file-upload-area {
        min-height: 130px;
    }
    
    .upload-placeholder {
        padding: 15px;
    }
    
    .upload-placeholder i {
        font-size: 2rem !important;
    }
    
    .image-upload-area {
        max-width: 100%;
    }
}
</style>

@endsection