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
          <i class="fas fa-user-plus me-3" style="font-size: 24px; color: #2196F3;"></i>
          <h4 class="mb-0">Add New Teacher</h4>
        </div>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('teachers.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Basic Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="name" name="name" value="{{old('name')}}" required placeholder="Enter teacher name">
              </div>

              <div class="col-md-6 mb-3">
                <label for="rank" class="form-label">Rank <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input" id="rank" name="rank" value="{{old('rank')}}" required placeholder="Enter teacher rank">
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-image me-2"></i>Profile Image
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="profile" class="form-label">Profile Image</label>
                <input type="file" class="form-control modern-input" id="profile" name="profile" accept="image/*">
                <small class="form-text">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-file-alt me-2"></i>Teacher Details
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control modern-input" id="description" name="description" rows="4" placeholder="Enter teacher description">{{old('description')}}</textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="qualification" class="form-label">Qualification</label>
                <textarea class="form-control modern-input" id="qualification" name="qualification" rows="4" placeholder="Enter qualifications">{{old('qualification')}}</textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="experience" class="form-label">Experience</label>
                <textarea class="form-control modern-input" id="experience" name="experience" rows="4" placeholder="Enter experience">{{old('experience')}}</textarea>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-share-alt me-2"></i>Social Media Links
            </h6>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="facebook" class="form-label">Facebook URL</label>
                <input type="url" class="form-control modern-input" id="facebook" name="facebook" value="{{old('facebook')}}" placeholder="https://facebook.com/...">
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="telegram" class="form-label">Telegram URL</label>
                <input type="url" class="form-control modern-input" id="telegram" name="telegram" value="{{old('telegram')}}" placeholder="https://t.me/...">
              </div>
              
              <div class="col-md-4 mb-3">
                <label for="youtube" class="form-label">YouTube URL</label>
                <input type="url" class="form-control modern-input" id="youtube" name="youtube" value="{{old('youtube')}}" placeholder="https://youtube.com/...">
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-graduation-cap me-2"></i>Course Information
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="total_course" class="form-label">Total Courses</label>
                <input type="number" class="form-control modern-input" id="total_course" name="total_course" value="{{old('total_course', 0)}}" min="0" placeholder="Enter total courses">
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('teachers.index')}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Add Teacher</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

