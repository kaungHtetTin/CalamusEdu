@extends('layouts.navbar')

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

<div class="row">
  <div class="col-xl-8 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #32cd32;">
        <h5 class="language-data-title mb-0" style="color: #32cd32;">
          <i class="fas fa-comments me-2"></i>
          Add Dialogue For English Speaking Trainer
        </h5>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('addDialogue')}}" method="POST">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-user me-2"></i>Person A Dialogue
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="person_a" class="form-label">Person A - English <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="person_a"
                       name="person_a" 
                       value="{{old('person_a')}}"
                       placeholder="Enter Person A English dialogue"
                       required>
                @error('person_a')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="person_a_mm" class="form-label">Person A - Myanmar <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="person_a_mm"
                       name="person_a_mm" 
                       value="{{old('person_a_mm')}}"
                       placeholder="Enter Person A Myanmar dialogue"
                       required>
                @error('person_a_mm')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-user-friends me-2"></i>Person B Dialogue
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="person_b" class="form-label">Person B - English <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="person_b"
                       name="person_b" 
                       value="{{old('person_b')}}"
                       placeholder="Enter Person B English dialogue"
                       required>
                @error('person_b')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="person_b_mm" class="form-label">Person B - Myanmar <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="person_b_mm"
                       name="person_b_mm" 
                       value="{{old('person_b_mm')}}"
                       placeholder="Enter Person B Myanmar dialogue"
                       required>
                @error('person_b_mm')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-folder me-2"></i>Saturation Selection
            </h6>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="saturation" class="form-label">Select Saturation <span class="text-danger">*</span></label>
                <select class="form-control modern-input" 
                        id="saturation"
                        name="saturation"
                        required>
                  @foreach($saturations as $saturation)
                    <option value="{{$saturation->saturation_id}}" {{old('saturation') == $saturation->saturation_id ? 'selected' : ''}}>{{$saturation->title}}</option>
                  @endforeach
                </select>
                @error('saturation')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Add Dialogue</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #2196f3;">
        <h5 class="language-data-title mb-0" style="color: #2196f3;">
          <i class="fas fa-plus-circle me-2"></i>
          Add New Saturation
        </h5>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('addNewSaturation')}}" method="POST">
          @csrf
          
          <div class="form-section">
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="title" class="form-label">Saturation Title <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control modern-input" 
                       id="title"
                       name="title" 
                       value="{{old('title')}}"
                       placeholder="Enter saturation title"
                       required>
                @error('title')
                  <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="new-category-btn">
              <i class="fas fa-plus"></i>
              <span>Add Saturation</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection