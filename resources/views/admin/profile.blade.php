@extends('layouts.main')

@section('content')
<style>
  .profile-container {
    max-width: 800px;
    margin: 0 auto;
  }
  
  .profile-header {
    margin-bottom: 32px;
  }
  
  .profile-header h1 {
    font-size: 28px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0;
  }
  
  .profile-header p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
  }
  
  .profile-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 24px;
    overflow: hidden;
  }
  
  .profile-section-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-tertiary);
  }
  
  .profile-section-header h2 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
  }
  
  .profile-section-body {
    padding: 24px;
  }
  
  .form-group {
    margin-bottom: 24px;
  }
  
  .form-group:last-child {
    margin-bottom: 0;
  }
  
  .form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 8px;
  }
  
  .form-input {
    width: 100%;
    padding: 10px 14px;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-primary);
    font-size: 14px;
    transition: all 0.2s ease;
  }
  
  .form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
  }
  
  .form-input[type="file"] {
    padding: 8px;
    cursor: pointer;
  }
  
  .form-help {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 6px;
  }
  
  .image-preview-container {
    margin-top: 16px;
  }
  
  .image-preview {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border-color);
    display: block;
  }
  
  .current-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border-color);
    display: block;
    margin-top: 16px;
  }
  
  .avatar-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: var(--bg-tertiary);
    border: 3px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: var(--text-muted);
    margin-top: 16px;
  }
  
  .btn-save {
    padding: 10px 24px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .btn-save:hover {
    background: var(--primary-color-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
  }
  
  .alert {
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 24px;
    font-size: 14px;
  }
  
  .alert-success {
    background: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.3);
    color: #28a745;
  }
  
  .alert-error {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #dc3545;
  }
  
  .error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 6px;
  }
</style>

<div class="profile-container">
  <div class="profile-header">
    <h1>Profile Settings</h1>
    <p>Manage your profile information and security settings</p>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-error">
      {{ session('error') }}
    </div>
  @endif

  <!-- Profile Information Section -->
  <div class="profile-section">
    <div class="profile-section-header">
      <h2>Profile Information</h2>
    </div>
    <div class="profile-section-body">
      <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
          <label class="form-label" for="name">Name</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            class="form-input" 
            value="{{ old('name', $admin->learner_name ?? '') }}"
            required
          >
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="image">Profile Image</label>
          <input 
            type="file" 
            id="image" 
            name="image" 
            class="form-input" 
            accept="image/*"
            onchange="previewImage(this)"
          >
          <div class="form-help">Upload a new profile image (JPG, PNG, GIF - Max 2MB)</div>
          @error('image')
            <div class="error-message">{{ $message }}</div>
          @enderror
          
          <div class="image-preview-container">
            @if($admin->learner_image && !empty($admin->learner_image))
              <img 
                src="{{ strpos($admin->learner_image, 'http') === 0 ? $admin->learner_image : asset('storage/' . $admin->learner_image) }}" 
                alt="Current Profile Image" 
                class="current-image"
                id="currentImage"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
              >
              <div class="avatar-placeholder" id="currentImageFallback" style="display: none;">
                {{ strtoupper(substr($admin->learner_name ?? 'A', 0, 1)) }}
              </div>
            @else
              <div class="avatar-placeholder" id="currentImage">
                {{ strtoupper(substr($admin->learner_name ?? 'A', 0, 1)) }}
              </div>
            @endif
            <img 
              src="" 
              alt="Preview" 
              class="image-preview" 
              id="imagePreview"
              style="display: none;"
            >
          </div>
        </div>

        <button type="submit" class="btn-save">Update Profile</button>
      </form>
    </div>
  </div>

  <!-- Password Change Section -->
  <div class="profile-section">
    <div class="profile-section-header">
      <h2>Change Password</h2>
    </div>
    <div class="profile-section-body">
      <form action="{{ route('admin.profile.password') }}" method="POST">
        @csrf
        
        <div class="form-group">
          <label class="form-label" for="current_password">Current Password</label>
          <input 
            type="password" 
            id="current_password" 
            name="current_password" 
            class="form-input" 
            required
          >
          @error('current_password')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="new_password">New Password</label>
          <input 
            type="password" 
            id="new_password" 
            name="new_password" 
            class="form-input" 
            required
            minlength="6"
          >
          <div class="form-help">Password must be at least 6 characters long</div>
          @error('new_password')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
          <input 
            type="password" 
            id="new_password_confirmation" 
            name="new_password_confirmation" 
            class="form-input" 
            required
            minlength="6"
          >
          @error('new_password_confirmation')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn-save">Update Password</button>
      </form>
    </div>
  </div>
</div>

<script>
  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');
    
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (currentImage) {
          currentImage.style.display = 'none';
        }
      }
      
      reader.readAsDataURL(input.files[0]);
    } else {
      preview.style.display = 'none';
      if (currentImage) {
        currentImage.style.display = 'block';
      }
    }
  }
</script>
@endsection
