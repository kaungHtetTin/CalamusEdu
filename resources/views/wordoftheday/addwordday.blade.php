@extends('layouts.navbar')

@section('content')

@if (session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msg')}}
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
          <i class="fas fa-calendar-day me-2"></i>
          Add Word Of The Day - {{ucwords($major)}}
        </h5>
        <a href="{{route('showWordOfTheDay', $major)}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form enctype="multipart/form-data" action="{{route('addWordDay',$major)}}" method="POST">
          @csrf
          <input type="hidden" name="major" value="{{$major}}"/>
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Word Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="{{$major}}" class="form-label">{{ucwords($major)}} Word <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="{{$major}}"
                       name="{{$major}}" 
                       value="{{old($major)}}"
                       placeholder="Enter {{ucwords($major)}} word"
                       required>
                @error($major)
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="myanmar" class="form-label">Myanmar Translation <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="myanmar"
                       name="myanmar" 
                       value="{{old('myanmar')}}"
                       placeholder="Enter Myanmar translation"
                       required>
                @error('myanmar')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="speech" class="form-label">Part of Speech <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="speech"
                       name="speech" 
                       value="{{old('speech')}}"
                       placeholder="e.g., noun, verb, adjective"
                       required>
                @error('speech')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="image" class="form-label">Word Image <span class="text-danger">*</span></label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="word_image_upload_area">
                    <input type="file" class="d-none" id="image" name="image" accept="image/*" required>
                    <div class="upload-placeholder" id="word_image_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload word image</p>
                      <small class="text-muted">Image format (Required)</small>
                    </div>
                    <div class="image-preview d-none" id="word_image_preview">
                      <img id="word_image_preview_img" src="" alt="Word Image Preview" style="width: 50%; height: 50%; object-fit: cover; border-radius: 8px;">
                      <button type="button" class="btn-remove-image" id="word_image_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
                @error('image')
                  <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-book me-2"></i>Example Usage
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="example" class="form-label">Example Sentence <span class="text-danger">*</span></label>
                <textarea class="form-control modern-input" 
                          id="example"
                          name="example" 
                          rows="6"
                          placeholder="Enter example sentence using this word"
                          required>{{old('example')}}</textarea>
                @error('example')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('showWordOfTheDay', $major)}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Add Word</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Word image upload
    const wordImageInput = document.getElementById('image');
    const wordImageUploadArea = document.getElementById('word_image_upload_area');
    const wordImagePlaceholder = document.getElementById('word_image_placeholder');
    const wordImagePreview = document.getElementById('word_image_preview');
    const wordImagePreviewImg = document.getElementById('word_image_preview_img');
    const wordImageRemoveBtn = document.getElementById('word_image_remove_btn');

    wordImageUploadArea.addEventListener('click', function() {
        wordImageInput.click();
    });

    wordImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                wordImagePreviewImg.src = e.target.result;
                wordImagePlaceholder.classList.add('d-none');
                wordImagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    wordImageRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        wordImageInput.value = '';
        wordImagePlaceholder.classList.remove('d-none');
        wordImagePreview.classList.add('d-none');
        wordImagePreviewImg.src = '';
    });
});
</script>

<style>
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
    max-width: 400px;
}

.image-upload-area:hover {
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

body.dark-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.7);
    background: rgba(255, 255, 255, 0.02);
}

body.dark-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.1);
}

body.light-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.5);
    background: #f8f9fa;
}

body.light-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.08);
}

@media (max-width: 768px) {
    .image-upload-area {
        max-width: 100%;
    }
}
</style>

@endsection