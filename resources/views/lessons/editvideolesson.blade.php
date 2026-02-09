@extends('layouts.main')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
    $isChannel = $lesson->isChannel;
@endphp

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #2196f3;">
        <h5 class="language-data-title mb-0" style="color: #2196f3;">
          <i class="fas fa-video me-2"></i>Edit Video Lesson - {{$course}} ({{$lesson->major}})
        </h5>
        <a href="{{route('lessons.list', $lesson->category_id)}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('lessons.update', $lesson->id)}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="isVideo" value="1"/>
          <input type="hidden" name="major" value="{{$lesson->major}}"/>
          <input type="hidden" name="link" value="">
          <input type="hidden" name="vimeo" value="">
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Lesson Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="title_mini" class="form-label">Title Mini <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="title_mini" name="title_mini" value="{{old('title_mini', $lesson->title_mini)}}" required placeholder="Enter title mini">
              </div>

              <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Lesson Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="title" name="title" value="{{old('title', $lesson->title)}}" required placeholder="Enter lesson title">
              </div>
            </div>

            <div class="mb-3">
              <label for="post" class="form-label">Post Content <span class="text-danger">*</span></label>
              <textarea class="form-control modern-input" id="post" name="post" rows="4" required placeholder="Enter post content">{{old('post', $post->body ?? '')}}</textarea>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-folder me-2"></i>Category Selection
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cate" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-control modern-input" id="cate" name="cate" required>
                  <option value="">Select Category</option>
                  @foreach ($categories as $cat)
                    <option value="{{$cat->id}}" {{old('cate', $lesson->category_id) == $cat->id ? 'selected' : ''}}>
                      {{$cat->category_title}}
                    </option>
                  @endforeach
                </select>
                @error('cate')
                  <div class="text-danger" style="font-size: 12px;">{{$message}}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-video me-2"></i>Video Content
            </h6>
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="video_file" class="form-label">Replace Video File</label>
                <input type="file" class="form-control modern-input" id="video_file" name="video_file" accept="video/*">
                <small class="form-text text-muted">Leave empty to keep current video. Upload new video file (MP4, MOV, AVI, MKV, WMV, FLV, WEBM) - Max 100MB</small>
                @if($post && $post->video_url)
                  <div class="mt-2">
                    <small class="text-muted">
                      <i class="fas fa-info-circle me-1"></i>Current video is stored on server
                    </small>
                  </div>
                @endif
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
                    @if($lesson->thumbnail)
                      <div class="image-preview" id="thumbnail_preview">
                        <img id="thumbnail_preview_img" src="{{$lesson->thumbnail}}" alt="Thumbnail Preview">
                        <button type="button" class="btn-remove-image" id="thumbnail_remove_btn" title="Remove image">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                      <div class="upload-placeholder d-none" id="thumbnail_placeholder">
                        <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #2196f3;"></i>
                        <p class="mb-2">Click to upload thumbnail</p>
                        <small class="text-muted">PNG, JPG, GIF, WEBP (Max 5MB)</small>
                      </div>
                    @else
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
                    @endif
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
                  <input class="" type="checkbox" name="isVip" id="isVip" value="1" {{old('isVip', $lesson->isVip) ? 'checked' : ''}}>
                  <label class="form-check-label" for="isVip">VIP Lesson</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="" type="checkbox" name="add_to_discuss" id="add_to_discuss" value="1" {{old('add_to_discuss', ($post->hide ?? 1) == 1 ? '' : 'checked')}}>
                  <label class="form-check-label" for="add_to_discuss">Add to discussion room</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('lessons.list', $lesson->category_id)}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Update Video Lesson</span>
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
