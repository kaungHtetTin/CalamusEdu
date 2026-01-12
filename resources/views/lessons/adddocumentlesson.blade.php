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
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #ff9800;">
        <h5 class="language-data-title mb-0" style="color: #ff9800;">
          <i class="fas fa-file-alt me-2"></i>Add Document Lesson - {{$course}} in {{session('major')}}
        </h5>
        <a href="javascript:history.back()" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('addLesson',$course)}}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="major" value="{{session('major')}}"/>
          
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

            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="html_file" class="form-label">HTML File <span class="text-danger">*</span></label>
                <input type="file" class="form-control modern-input" id="html_file" name="html_file" accept=".html,.htm" value="{{old('html_file')}}" required>
                <small class="form-text text-muted">Upload HTML file to automatically post to Blogger</small>
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

          <div class="form-actions">
            <a href="javascript:history.back()" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Add Document Lesson</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
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
</style>
@endpush

@endsection
