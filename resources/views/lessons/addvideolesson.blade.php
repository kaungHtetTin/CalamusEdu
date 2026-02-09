@extends('layouts.main')

@section('content')

@if (session('msgLesson'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msgLesson')}}
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

@php
    $isChannel=($course=='Video Channel')?1 : 0;
@endphp

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #2196f3;">
        <h5 class="language-data-title mb-0" style="color: #2196f3;">
          <i class="fas fa-video me-2"></i>Add Video Lesson - {{$course}} in {{session('major')}}
        </h5>
        <a href="javascript:history.back()" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('addLesson',$course)}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="isVideo" value="1"/>
          <input type="hidden" name="major" value="{{session('major')}}"/>
          <input type="hidden" name="link" value="">
          <input type="hidden" name="vimeo" value="">
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Lesson Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="title_mini" class="form-label">Title Mini <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="title_mini" name="title_mini" value="{{old('title_mini', $category_title)}}" required placeholder="Enter title mini">
              </div>

              <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Lesson Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="title" name="title" value="{{old('title')}}" required placeholder="Enter lesson title">
              </div>
            </div>

            <div class="mb-3">
              <label for="post" class="form-label">Post Content <span class="text-danger">*</span></label>
              <textarea class="form-control modern-input" id="post" name="post" rows="4" required placeholder="Enter post content">{{old('post')}}</textarea>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-folder me-2"></i>Category Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <div class="form-control modern-input" style="background-color: var(--bg-secondary); color: var(--text-secondary);">
                  <i class="fas fa-folder me-2"></i>{{$category_title}}
                </div>
                <input type="hidden" name="cate" value="{{$category_id}}" required>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-video me-2"></i>Video Upload
            </h6>
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="video_file" class="form-label">Video File <span class="text-danger">*</span></label>
                <input type="file" class="form-control modern-input" id="video_file" name="video_file" accept="video/*" required>
                <small class="form-text text-muted">Upload video file (MP4, MOV, AVI, MKV, WMV, FLV, WEBM) - Max 100MB</small>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-image me-2"></i>Video Thumbnail
            </h6>
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="myfile" class="form-label">Video Thumbnail Image</label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="thumbnail_upload_area">
                    <input type="file" class="d-none" id="myfile" name="myfile" accept="image/*">
                    <div class="upload-placeholder" id="thumbnail_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #2196f3;"></i>
                      <p class="mb-2">Click to upload thumbnail</p>
                      <small class="text-muted">PNG, JPG, GIF, WEBP (Max 5MB)</small>
                    </div>
                    <div class="image-preview d-none" id="thumbnail_preview">
                      <img id="thumbnail_preview_img" src="" alt="Thumbnail Preview">
                      <button type="button" class="btn-remove-image" id="thumbnail_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-cog me-2"></i>Lesson Settings
            </h6>
            <div class="row">
              <input type="hidden" name="isChannel" value="{{$isChannel == 1 ? '1' : '0'}}">
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="" type="checkbox" name="isVip" id="isVip" value="1" {{old('isVip') ? 'checked' : ''}}>
                  <label class="form-check-label" for="isVip">VIP Lesson</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="" type="checkbox" name="add_to_discuss" id="add_to_discuss" value="1" {{old('add_to_discuss') ? 'checked' : ''}}>
                  <label class="form-check-label" for="add_to_discuss">Add to discussion room</label>
                </div>
              </div>
            </div>
          </div>

          {{-- Upload Progress Section --}}
          <div id="upload-progress-section" class="form-section d-none">
            <h6 class="form-section-title">
              <i class="fas fa-upload me-2"></i>Upload Progress
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="upload-progress-item">
                  <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-cloud me-2"></i>Uploading to Vimeo...</span>
                    <span id="vimeo-progress-text" class="text-muted">0%</span>
                  </div>
                  <div class="progress" style="height: 25px;">
                    <div id="vimeo-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="upload-progress-item">
                  <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-server me-2"></i>Uploading to Server...</span>
                    <span id="server-progress-text" class="text-muted">0%</span>
                  </div>
                  <div class="progress" style="height: 25px;">
                    <div id="server-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%">0%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="javascript:history.back()" class="btn-back btn-sm" id="cancel-btn">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn" id="submit-btn">
              <i class="fas fa-save"></i>
              <span>Add Video Lesson</span>
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
    // Image preview functionality for thumbnail
    const thumbnailImageInput = document.getElementById('myfile');
    const thumbnailUploadArea = document.getElementById('thumbnail_upload_area');
    const thumbnailPlaceholder = document.getElementById('thumbnail_placeholder');
    const thumbnailPreview = document.getElementById('thumbnail_preview');
    const thumbnailPreviewImg = document.getElementById('thumbnail_preview_img');
    const thumbnailRemoveBtn = document.getElementById('thumbnail_remove_btn');

    if (thumbnailUploadArea) {
        thumbnailUploadArea.addEventListener('click', function() {
            thumbnailImageInput.click();
        });

        thumbnailImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    thumbnailPreviewImg.src = e.target.result;
                    thumbnailPlaceholder.classList.add('d-none');
                    thumbnailPreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        if (thumbnailRemoveBtn) {
            thumbnailRemoveBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                thumbnailImageInput.value = '';
                thumbnailPlaceholder.classList.remove('d-none');
                thumbnailPreview.classList.add('d-none');
                thumbnailPreviewImg.src = '';
            });
        }
    }

    // Video upload with progress tracking
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const progressSection = document.getElementById('upload-progress-section');
    const vimeoProgressBar = document.getElementById('vimeo-progress-bar');
    const vimeoProgressText = document.getElementById('vimeo-progress-text');
    const serverProgressBar = document.getElementById('server-progress-bar');
    const serverProgressText = document.getElementById('server-progress-text');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const videoFile = document.getElementById('video_file').files[0];
            
            if (!videoFile) {
                alert('Please select a video file');
                return;
            }

            // Show progress section
            progressSection.classList.remove('d-none');
            submitBtn.disabled = true;
            cancelBtn.style.pointerEvents = 'none';
            cancelBtn.style.opacity = '0.5';

            // Reset progress bars
            updateProgress('vimeo', 0, 'Starting upload...');
            updateProgress('server', 0, 'Waiting...');

            // Create XMLHttpRequest for progress tracking
            const xhr = new XMLHttpRequest();

            // Track upload progress for local server upload
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    // Show progress for server upload (this is the form data upload progress)
                    updateProgress('server', percentComplete, percentComplete + '%');
                }
            });

            // Handle response
            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            updateProgress('vimeo', 100, 'Complete');
                            updateProgress('server', 100, 'Complete');
                            setTimeout(function() {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                } else {
                                    window.location.reload();
                                }
                            }, 1000);
                        } else {
                            handleError(response.message || 'Upload failed');
                        }
                    } catch (e) {
                        // If response is HTML (redirect), just follow it
                        window.location.reload();
                    }
                } else {
                    handleError('Upload failed with status: ' + xhr.status);
                }
            });

            xhr.addEventListener('error', function() {
                handleError('Network error occurred');
            });

            // Simulate Vimeo upload progress (since it happens server-side)
            let vimeoProgress = 0;
            const vimeoInterval = setInterval(function() {
                if (vimeoProgress < 90) {
                    vimeoProgress += Math.random() * 15;
                    if (vimeoProgress > 90) vimeoProgress = 90;
                    updateProgress('vimeo', Math.round(vimeoProgress), Math.round(vimeoProgress) + '%');
                }
            }, 500);

            // Submit form
            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);

            // Clear interval when done
            xhr.addEventListener('loadend', function() {
                clearInterval(vimeoInterval);
            });
        });
    }

    function updateProgress(type, percent, text) {
        if (type === 'vimeo') {
            vimeoProgressBar.style.width = percent + '%';
            vimeoProgressBar.textContent = percent + '%';
            vimeoProgressText.textContent = text;
        } else if (type === 'server') {
            serverProgressBar.style.width = percent + '%';
            serverProgressBar.textContent = percent + '%';
            serverProgressText.textContent = text;
        }
    }

    function handleError(message) {
        alert('Error: ' + message);
        submitBtn.disabled = false;
        cancelBtn.style.pointerEvents = 'auto';
        cancelBtn.style.opacity = '1';
        progressSection.classList.add('d-none');
    }
});
</script>

<style>
.image-upload-wrapper {
    margin-bottom: 1rem;
}

.image-upload-area {
    position: relative;
    border: 2px dashed rgba(33, 150, 243, 0.3);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

#thumbnail_upload_area {
    width: 355px;
    height: 200px;
}

.image-upload-area:hover {
    border-color: #2196f3;
    background: rgba(33, 150, 243, 0.05);
}

.upload-placeholder {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.upload-placeholder i {
    opacity: 0.6;
}

.image-preview {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.btn-remove-image:hover {
    background: rgba(220, 53, 69, 1);
    transform: scale(1.1);
}

.form-section {
    border-bottom: none !important;
    margin-bottom: 2rem;
}

.form-section-title {
    border-bottom: none !important;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.upload-progress-item {
    margin-bottom: 1rem;
}

.upload-progress-item .progress {
    border-radius: 8px;
    overflow: hidden;
}

.upload-progress-item .progress-bar {
    transition: width 0.3s ease;
    font-size: 0.875rem;
    font-weight: 500;
}

body.dark-theme .image-upload-area {
    border-color: rgba(33, 150, 243, 0.5);
    background: rgba(255, 255, 255, 0.02);
}

body.dark-theme .image-upload-area:hover {
    border-color: #2196f3;
    background: rgba(33, 150, 243, 0.1);
}

body.light-theme .image-upload-area {
    border-color: rgba(33, 150, 243, 0.3);
    background: #f8f9fa;
}

body.light-theme .image-upload-area:hover {
    border-color: #2196f3;
    background: rgba(33, 150, 243, 0.05);
}
</style>
@endpush

@endsection
