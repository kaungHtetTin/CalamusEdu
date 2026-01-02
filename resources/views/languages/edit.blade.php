@extends('layouts.main')

@section('content')

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
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #FF9800;">
        <h5 class="language-data-title mb-0" style="color: #FF9800;">
          <i class="fas fa-edit me-2"></i>Edit Language - {{$language->display_name}}
        </h5>
        <a href="{{route('languages.index')}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <form action="{{route('languages.update', $language->id)}}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="form-section col-lg-6 col-md-6">
              <h6 class="form-section-title">
                <i class="fas fa-info-circle me-2"></i>Basic Information
              </h6>
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label for="name" class="form-label">Language Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control modern-input" id="name" name="name" value="{{old('name', $language->name)}}" required maxlength="100" placeholder="e.g., English">
                  <small class="text-muted">Internal name for the language</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="code" class="form-label">Language Code <span class="text-danger">*</span></label>
                  <input type="text" class="form-control modern-input" id="code" name="code" value="{{old('code', $language->code)}}" required maxlength="20" placeholder="e.g., english">
                  <small class="text-muted">Unique code used in database (lowercase, no spaces)</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="display_name" class="form-label">Display Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control modern-input" id="display_name" name="display_name" value="{{old('display_name', $language->display_name)}}" required maxlength="100" placeholder="e.g., Easy English">
                  <small class="text-muted">Name shown to users</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="module_code" class="form-label">Module Code <span class="text-danger">*</span></label>
                  <input type="text" class="form-control modern-input" id="module_code" name="module_code" value="{{old('module_code', $language->module_code)}}" required maxlength="10" placeholder="e.g., ee">
                  <small class="text-muted">Code used for user data tables (e.g., 'ee' for 'ee_user_datas')</small>
                </div>
              </div>
            </div>

            <div class="form-section col-lg-6 col-md-6">
              <h6 class="form-section-title">
                <i class="fas fa-cog me-2"></i>Configuration
              </h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="primary_color" class="form-label">Primary Color</label>
                  <input type="color" class="form-control form-control-color" id="primary_color" name="primary_color" value="{{old('primary_color', $language->primary_color ?? '#2196F3')}}">
                  <small class="text-muted">Primary theme color</small>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="secondary_color" class="form-label">Secondary Color</label>
                  <input type="color" class="form-control form-control-color" id="secondary_color" name="secondary_color" value="{{old('secondary_color', $language->secondary_color ?? '#1976D2')}}">
                  <small class="text-muted">Secondary theme color</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="image_path" class="form-label">Image Path</label>
                  <input type="text" class="form-control modern-input" id="image_path" name="image_path" value="{{old('image_path', $language->image_path)}}" maxlength="500" placeholder="e.g., /img/easyenglish.png">
                  <small class="text-muted">Path to language icon/image</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="notification_owner_id" class="form-label">Notification Owner ID</label>
                  <input type="text" class="form-control modern-input" id="notification_owner_id" name="notification_owner_id" value="{{old('notification_owner_id', $language->notification_owner_id)}}" maxlength="20" placeholder="e.g., 1001">
                  <small class="text-muted">ID for notification system</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="firebase_topic" class="form-label">Firebase Topic</label>
                  <input type="text" class="form-control modern-input" id="firebase_topic" name="firebase_topic" value="{{old('firebase_topic', $language->firebase_topic)}}" maxlength="100" placeholder="e.g., englishUsers">
                  <small class="text-muted">Firebase topic name for push notifications</small>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="user_data_table_prefix" class="form-label">User Data Table Prefix <span class="text-danger">*</span></label>
                  <input type="text" class="form-control modern-input" id="user_data_table_prefix" name="user_data_table_prefix" value="{{old('user_data_table_prefix', $language->user_data_table_prefix)}}" required maxlength="20" placeholder="e.g., ee">
                  <small class="text-muted">Prefix for user data table (e.g., 'ee' creates 'ee_user_datas')</small>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="sort_order" class="form-label">Sort Order</label>
                  <input type="number" class="form-control modern-input" id="sort_order" name="sort_order" value="{{old('sort_order', $language->sort_order)}}" min="0">
                  <small class="text-muted">Display order (lower = first)</small>
                </div>
                
                <div class="col-md-6 mb-3">
                  <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{old('is_active', $language->is_active) ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_active">Active</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('languages.index')}}" class="btn-back btn-sm">
              <i class="fas fa-arrow-left"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i>
              <span>Update Language</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

