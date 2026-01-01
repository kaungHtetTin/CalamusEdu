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
      <div class="course-title-header">
        <div class="d-flex align-items-center">
          <i class="fas fa-graduation-cap me-3" style="font-size: 24px; color: #32cd32;"></i>
          <h4 class="mb-0">Add New Course - {{$languageName}}</h4>
        </div>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('lessons.storeCourse', $language)}}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Basic Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="title" name="title" value="{{old('title')}}" required maxlength="50" placeholder="Enter course title">
              </div>

              <div class="col-md-6 mb-3">
                <label for="teacher_id" class="form-label">Teacher <span class="text-danger">*</span></label>
                <select class="form-control modern-input" id="teacher_id" name="teacher_id" required>
                  <option value="">Select Teacher</option>
                  @foreach($teachers as $teacher)
                    <option value="{{$teacher->id}}" {{old('teacher_id') == $teacher->id ? 'selected' : ''}}>
                      {{$teacher->name}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-certificate me-2"></i>Certificate Details
            </h6>
            <div class="row">

              <div class="col-md-6 mb-3">
                <label for="certificate_title" class="form-label">Certificate Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="certificate_title" name="certificate_title" value="{{old('certificate_title')}}" required maxlength="225" placeholder="Enter certificate title">
              </div>

              <div class="col-md-6 mb-3">
                <label for="certificate_code" class="form-label">Certificate Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="certificate_code" name="certificate_code" value="{{old('certificate_code')}}" required maxlength="5" placeholder="e.g., ENG01">
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-cog me-2"></i>Course Settings
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="duration" class="form-label">Duration (days) <span class="text-danger">*</span></label>
                <input type="number" class="form-control modern-input" id="duration" name="duration" value="{{old('duration')}}" required min="1" placeholder="Enter duration in days">
              </div>

              <div class="col-md-6 mb-3">
                <label for="fee" class="form-label">Fee <span class="text-danger">*</span></label>
                <input type="number" class="form-control modern-input" id="fee" name="fee" value="{{old('fee', 0)}}" required min="0" placeholder="Enter course fee">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="background_color" class="form-label">Background Color <span class="text-danger">*</span></label>
                <div class="d-flex gap-2">
                  <input type="color" class="form-control form-control-color" id="background_color_picker" value="{{old('background_color', '#2196F3')}}" style="width: 60px; height: 38px;">
                  <input type="text" class="form-control modern-input" id="background_color" name="background_color" value="{{old('background_color', '#2196F3')}}" required maxlength="225" placeholder="#2196F3">
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="is_vip" class="form-label">VIP Course <span class="text-danger">*</span></label>
                <select class="form-control modern-input" id="is_vip" name="is_vip" required>
                  <option value="0" {{old('is_vip') == 0 || old('is_vip') == null ? 'selected' : ''}}>No</option>
                  <option value="1" {{old('is_vip') == 1 ? 'selected' : ''}}>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-image me-2"></i>Media Upload
            </h6>
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="cover_image" class="form-label">Cover Image</label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="cover_upload_area">
                    <input type="file" class="d-none" id="cover_image" name="cover_image" accept="image/*">
                    <div class="upload-placeholder" id="cover_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload cover image</p>
                      <small class="text-muted">PNG, JPG, GIF, WEBP (Max 5MB)</small>
                    </div>
                    <div class="image-preview d-none" id="cover_preview">
                      <img id="cover_preview_img" src="" alt="Cover Preview">
                      <button type="button" class="btn-remove-image" id="cover_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  @if(old('cover_url'))
                    <small class="text-muted d-block mt-2">
                      <i class="fas fa-info-circle me-1"></i>Current: {{old('cover_url')}}
                    </small>
                  @endif
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <label for="web_cover_image" class="form-label">Web Cover Image</label>
                <div class="image-upload-wrapper">
                  <div class="image-upload-area" id="web_cover_upload_area">
                    <input type="file" class="d-none" id="web_cover_image" name="web_cover_image" accept="image/*">
                    <div class="upload-placeholder" id="web_cover_placeholder">
                      <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                      <p class="mb-2">Click to upload web cover image</p>
                      <small class="text-muted">PNG, JPG, GIF, WEBP (Max 5MB)</small>
                    </div>
                    <div class="image-preview d-none" id="web_cover_preview">
                      <img id="web_cover_preview_img" src="" alt="Web Cover Preview">
                      <button type="button" class="btn-remove-image" id="web_cover_remove_btn" title="Remove image">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  @if(old('web_cover'))
                    <small class="text-muted d-block mt-2">
                      <i class="fas fa-info-circle me-1"></i>Current: {{old('web_cover')}}
                    </small>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-align-left me-2"></i>Course Content
            </h6>
            <div class="mb-3">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control modern-input" id="description" name="description" rows="3" required maxlength="1000" placeholder="Enter course description">{{old('description')}}</textarea>
            </div>

            <div class="mb-3">
              <label for="details" class="form-label">Details <span class="text-danger">*</span></label>
              <div id="details-editor" style="min-height: 200px;"></div>
              <textarea class="d-none" id="details" name="details" required>{{old('details')}}</textarea>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('lessons.byLanguage', $language)}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Create Course</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<!-- Quill.js Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sync color picker with text input
    const colorPicker = document.getElementById('background_color_picker');
    const colorInput = document.getElementById('background_color');
    
    if (colorPicker && colorInput) {
        colorPicker.addEventListener('input', function() {
            colorInput.value = this.value;
        });
        
        colorInput.addEventListener('input', function() {
            if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                colorPicker.value = this.value;
            }
        });
    }

    // Image preview functionality for cover image
    const coverImageInput = document.getElementById('cover_image');
    const coverUploadArea = document.getElementById('cover_upload_area');
    const coverPlaceholder = document.getElementById('cover_placeholder');
    const coverPreview = document.getElementById('cover_preview');
    const coverPreviewImg = document.getElementById('cover_preview_img');
    const coverRemoveBtn = document.getElementById('cover_remove_btn');

    coverUploadArea.addEventListener('click', function() {
        coverImageInput.click();
    });

    coverImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreviewImg.src = e.target.result;
                coverPlaceholder.classList.add('d-none');
                coverPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    coverRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        coverImageInput.value = '';
        coverPlaceholder.classList.remove('d-none');
        coverPreview.classList.add('d-none');
        coverPreviewImg.src = '';
    });

    // Image preview functionality for web cover image
    const webCoverImageInput = document.getElementById('web_cover_image');
    const webCoverUploadArea = document.getElementById('web_cover_upload_area');
    const webCoverPlaceholder = document.getElementById('web_cover_placeholder');
    const webCoverPreview = document.getElementById('web_cover_preview');
    const webCoverPreviewImg = document.getElementById('web_cover_preview_img');
    const webCoverRemoveBtn = document.getElementById('web_cover_remove_btn');

    webCoverUploadArea.addEventListener('click', function() {
        webCoverImageInput.click();
    });

    webCoverImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                webCoverPreviewImg.src = e.target.result;
                webCoverPlaceholder.classList.add('d-none');
                webCoverPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    webCoverRemoveBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        webCoverImageInput.value = '';
        webCoverPlaceholder.classList.remove('d-none');
        webCoverPreview.classList.add('d-none');
        webCoverPreviewImg.src = '';
    });

    // Initialize Quill Rich Text Editor for Details
    const detailsEditor = document.getElementById('details-editor');
    const detailsTextarea = document.getElementById('details');
    
    if (detailsEditor && detailsTextarea) {
        // Initialize Quill with toolbar options
        const quill = new Quill('#details-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                ]
            },
            placeholder: 'Enter course details...'
        });

        // Set initial content from textarea
        if (detailsTextarea.value) {
            quill.root.innerHTML = detailsTextarea.value;
        }

        // Update textarea on text change
        quill.on('text-change', function() {
            detailsTextarea.value = quill.root.innerHTML;
        });

        // Also update on form submit to ensure latest content
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                detailsTextarea.value = quill.root.innerHTML;
            });
        }

        // Force icon colors in dark mode using JavaScript
        function setToolbarIconColors() {
            const toolbar = detailsEditor.querySelector('.ql-toolbar');
            if (toolbar && document.body.classList.contains('dark-theme')) {
                const buttons = toolbar.querySelectorAll('button');
                buttons.forEach(button => {
                    const svgs = button.querySelectorAll('svg, svg *');
                    svgs.forEach(svg => {
                        if (svg.tagName === 'svg' || svg.tagName === 'path' || svg.tagName === 'line' || 
                            svg.tagName === 'polyline' || svg.tagName === 'polygon' || 
                            svg.tagName === 'circle' || svg.tagName === 'rect') {
                            svg.setAttribute('stroke', '#ffffff');
                            svg.setAttribute('fill', '#ffffff');
                            svg.style.stroke = '#ffffff';
                            svg.style.fill = '#ffffff';
                            svg.style.color = '#ffffff';
                        }
                    });
                });
            }
        }

        // Set colors immediately and after a short delay to ensure Quill has rendered
        setTimeout(setToolbarIconColors, 100);
        setTimeout(setToolbarIconColors, 500);
        
        // Also set colors when theme changes
        const observer = new MutationObserver(function(mutations) {
            if (document.body.classList.contains('dark-theme')) {
                setToolbarIconColors();
            }
        });
        observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
    }
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

/* Cover Image - 1:1 Aspect Ratio (Square) */
#cover_upload_area {
   
    width: 200px;
    height: 200px;
}

/* Web Cover Image - 16:9 Aspect Ratio */
#web_cover_upload_area {
 
    width: 355px;
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

/* Quill Editor Styling */
#details-editor {
    border-radius: 4px;
}

#details-editor .ql-editor {
    min-height: 200px;
    font-size: 14px;
    line-height: 1.6;
}

#details-editor .ql-toolbar {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-bottom: 1px solid #ccc;
}

#details-editor .ql-container {
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
}

body.dark-theme #details-editor {
    background: transparent !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
}

body.dark-theme #details-editor .ql-container {
    background: var(--bg-secondary) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
}

body.dark-theme #details-editor .ql-editor {
    color: var(--text-primary) !important;
    background: var(--bg-secondary) !important;
}

body.dark-theme #details-editor .ql-toolbar {
    background: var(--bg-secondary) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
    border-bottom-color: rgba(255, 255, 255, 0.2) !important;
}

/* Dark theme toolbar icon fixes - using brighter color for visibility */
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow button {
    color: #ffffff !important;
}

body.dark-theme #details-editor .ql-toolbar button {
    color: #ffffff !important;
}

body.dark-theme #details-editor .ql-toolbar button:hover,
body.dark-theme #details-editor .ql-toolbar button.ql-active {
    background: rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
}

/* Target all stroke and fill elements directly - multiple selectors for maximum coverage */
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow .ql-stroke,
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow button .ql-stroke,
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow button svg .ql-stroke,
body.dark-theme #details-editor .ql-toolbar .ql-stroke,
body.dark-theme #details-editor .ql-toolbar button .ql-stroke,
body.dark-theme #details-editor .ql-toolbar button svg .ql-stroke {
    stroke: #ffffff !important;
}

body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow .ql-fill,
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow button .ql-fill,
body.dark-theme #details-editor.ql-container .ql-toolbar.ql-snow button svg .ql-fill,
body.dark-theme #details-editor .ql-toolbar .ql-fill,
body.dark-theme #details-editor .ql-toolbar button .ql-fill,
body.dark-theme #details-editor .ql-toolbar button svg .ql-fill {
    fill: #ffffff !important;
}

/* Target all SVG paths directly */
body.dark-theme #details-editor .ql-toolbar button svg,
body.dark-theme #details-editor .ql-toolbar button svg path,
body.dark-theme #details-editor .ql-toolbar button svg line,
body.dark-theme #details-editor .ql-toolbar button svg polyline,
body.dark-theme #details-editor .ql-toolbar button svg polygon,
body.dark-theme #details-editor .ql-toolbar button svg circle,
body.dark-theme #details-editor .ql-toolbar button svg rect {
    stroke: #ffffff !important;
    fill: #ffffff !important;
    color: #ffffff !important;
}

/* Target all child elements */
body.dark-theme #details-editor .ql-toolbar button svg * {
    stroke: #ffffff !important;
    fill: #ffffff !important;
    color: #ffffff !important;
}

/* Hover and active states */
body.dark-theme #details-editor .ql-toolbar button:hover svg,
body.dark-theme #details-editor .ql-toolbar button:hover svg *,
body.dark-theme #details-editor .ql-toolbar button.ql-active svg,
body.dark-theme #details-editor .ql-toolbar button.ql-active svg * {
    stroke: #ffffff !important;
    fill: #ffffff !important;
    color: #ffffff !important;
}

/* Specific button types */
body.dark-theme #details-editor .ql-toolbar button.ql-bold svg,
body.dark-theme #details-editor .ql-toolbar button.ql-italic svg,
body.dark-theme #details-editor .ql-toolbar button.ql-list svg,
body.dark-theme #details-editor .ql-toolbar button.ql-list svg * {
    stroke: #ffffff !important;
    fill: #ffffff !important;
    color: #ffffff !important;
}

body.dark-theme #details-editor .ql-toolbar .ql-picker-label {
    color: var(--text-primary) !important;
}

body.dark-theme #details-editor .ql-toolbar .ql-picker-options {
    background: var(--bg-secondary) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
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

