@extends('layouts.navbar')

@section('content')

@if (session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msg')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('err'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>{{session('err')}}
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
          <i class="fas fa-cloud me-2"></i>
          Send Cloud Messaging For Notification
        </h5>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('sendCloudMessage')}}" method="POST">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-info-circle me-2"></i>Notification Details
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Notification Title <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="title"
                       name="title" 
                       value="{{old('title')}}"
                       placeholder="Enter notification title"
                       required>
                @error('title')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="msg" class="form-label">Notification Message <span class="text-danger">*</span></label>
                <textarea class="form-control modern-input" 
                          id="msg"
                          name="msg" 
                          rows="6"
                          placeholder="Enter notification message"
                          required>{{old('msg')}}</textarea>
                @error('msg')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-users me-2"></i>Target Audience
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="app" class="form-label">Select Audience <span class="text-danger">*</span></label>
                <select class="form-control modern-input" 
                        id="app"
                        name="app"
                        required>
                  <option value="englishUsers" {{old('app') == 'englishUsers' ? 'selected' : ''}}>Easy English</option>
                  <option value="koreaUsers" {{old('app') == 'koreaUsers' ? 'selected' : ''}}>Easy Korean</option>
                  <option value="chineseUsers" {{old('app') == 'chineseUsers' ? 'selected' : ''}}>Easy Chinese</option>
                  <option value="japaneseUsers" {{old('app') == 'japaneseUsers' ? 'selected' : ''}}>Easy Japanese</option>
                  <option value="russianUsers" {{old('app') == 'russianUsers' ? 'selected' : ''}}>Easy Russian</option>
                </select>
                @error('app')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="new-category-btn">
              <i class="fas fa-paper-plane"></i>
              <span>Send Notification</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

