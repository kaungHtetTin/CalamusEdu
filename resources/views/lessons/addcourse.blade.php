@extends('layouts.main')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <div class="form-check modern-checkbox">
                  <input class="form-check-input" type="checkbox" id="is_vip" name="is_vip" value="1" {{old('is_vip') ? 'checked' : ''}}>
                  <label class="form-check-label" for="is_vip">
                    <i class="fas fa-crown me-2"></i>VIP Course
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-image me-2"></i>Media & URLs
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cover_url" class="form-label">Cover URL</label>
                <input type="url" class="form-control modern-input" id="cover_url" name="cover_url" value="{{old('cover_url')}}" maxlength="500" placeholder="https://example.com/cover.jpg">
              </div>

              <div class="col-md-6 mb-3">
                <label for="web_cover" class="form-label">Web Cover URL</label>
                <input type="url" class="form-control modern-input" id="web_cover" name="web_cover" value="{{old('web_cover')}}" maxlength="500" placeholder="https://example.com/web-cover.jpg">
              </div>
            </div>

            <div class="mb-3">
              <label for="preview" class="form-label">Preview URL</label>
              <input type="url" class="form-control modern-input" id="preview" name="preview" value="{{old('preview')}}" maxlength="1000" placeholder="https://example.com/preview">
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
              <textarea class="form-control modern-input" id="details" name="details" rows="5" required placeholder="Enter course details">{{old('details')}}</textarea>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('lessons.byLanguage', $language)}}" class="new-category-btn btn-cancel">
              <i class="fas fa-times"></i>
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
});
</script>
@endpush

@endsection

