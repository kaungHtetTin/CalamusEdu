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
          <i class="fas fa-edit me-2"></i>Edit Category - {{$course_title}} ({{$languageName}})
        </h5>
        <a href="{{route('lessons.byLanguage', $language)}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('lessons.updateCategory', $category->id)}}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Category Information
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="category_title" class="form-label">Category Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="category_title" name="category_title" value="{{old('category_title', $category->category_title)}}" required maxlength="128" placeholder="Enter category title">
                <small class="text-muted">This is the display name for the category</small>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-image me-2"></i>Category Image
            </h6>
            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="category_image" class="form-label">Category Image</label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="category_upload_area">
                    <input type="file" class="d-none" id="category_image" name="category_image" accept="image/*">
                    <div class="upload-placeholder {{$category->image_url ? 'd-none' : ''}}" id="category_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload category image</p>
                      <small class="text-muted">PNG, JPG, GIF, WEBP (Max 5MB)</small>
                    </div>
                    <div class="image-preview {{$category->image_url ? '' : 'd-none'}}" id="category_preview">
                      <img id="category_preview_img" src="{{$category->image_url}}" alt="Category Preview">
                      <button type="button" class="btn-remove-image" id="category_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  @if($category->image_url)
                    <small class="text-muted d-block mt-2">
                      <i class="fas fa-info-circle me-1"></i>Current image will be replaced if you upload a new one
                    </small>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('lessons.byLanguage', $language)}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Update Category</span>
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
    // Image preview functionality for category image
    const categoryImageInput = document.getElementById('category_image');
    const categoryUploadArea = document.getElementById('category_upload_area');
    const categoryPlaceholder = document.getElementById('category_placeholder');
    const categoryPreview = document.getElementById('category_preview');
    const categoryPreviewImg = document.getElementById('category_preview_img');
    const categoryRemoveBtn = document.getElementById('category_remove_btn');

    categoryUploadArea.addEventListener('click', function() {
        categoryImageInput.click();
    });

    categoryImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                categoryPreviewImg.src = e.target.result;
                categoryPlaceholder.classList.add('d-none');
                categoryPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    categoryRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        categoryImageInput.value = '';
        categoryPlaceholder.classList.remove('d-none');
        categoryPreview.classList.add('d-none');
        categoryPreviewImg.src = '';
    });
});
</script>

<style>
.image-upload-wrapper {
    margin-bottom: 1rem;
}

.image-upload-area {
    position: relative;
    border: 2px dashed rgba(156, 39, 176, 0.3);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Category Image - Square Aspect Ratio */
#category_upload_area {
    width: 200px;
    height: 200px;
}

.image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
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

body.dark-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.5);
    background: rgba(255, 255, 255, 0.02);
}

body.dark-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.1);
}

body.light-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.3);
    background: #f8f9fa;
}

body.light-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

/* Remove unnecessary dividers from form sections */
.form-section {
    border-bottom: none !important;
}

.form-section-title {
    border-bottom: none !important;
}
</style>
@endpush

@endsection

