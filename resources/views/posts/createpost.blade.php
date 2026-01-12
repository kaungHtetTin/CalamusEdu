@extends('layouts.navbar')
<link rel="stylesheet" href="{{asset("public/css/admin.css")}}" />
@section('searchbox')
<form class="d-none d-md-flex input-group w-auto my-auto" action="{{route('searchUser')}}" method="GET">
  <input autocomplete="off" type="search" class="form-control rounded"
    placeholder='Search a user' style="min-width: 225px" name="phone" />
  <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
</form>
@endsection

@section('content')

@if (session('msg'))
<div class="instagram-create-alert alert-success" id="customMessageBox">
    <i class="material-icons">check_circle</i>
    <span>{{session('msg')}}</span>
</div>
@endif

@if (session('err'))
<div class="instagram-create-alert alert-error" id="customMessageBox">
    <i class="material-icons">error</i>
    <span>{{session('err')}}</span>
</div>
@endif

<style>
/* Instagram-Style Create Post Page */
.instagram-create-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 20px;
}

.instagram-create-card {
    background: #ffffff;
    border: 1px solid #dbdbdb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

body.dark-theme .instagram-create-card {
    background: #000000;
    border-color: #262626;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.instagram-create-header {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #efefef;
}

body.dark-theme .instagram-create-header {
    border-color: #262626;
}

.instagram-create-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-create-avatar {
    border-color: #262626;
}

.instagram-create-username {
    flex: 1;
    font-weight: 600;
    font-size: 14px;
    color: #262626;
}

body.dark-theme .instagram-create-username {
    color: #ffffff;
}

.instagram-create-body {
    padding: 20px;
}

.instagram-create-textarea {
    width: 100%;
    border: none;
    background: transparent;
    color: #262626;
    font-size: 15px;
    font-family: inherit;
    line-height: 1.5;
    resize: none;
    outline: none;
    min-height: 120px;
    padding: 0;
}

body.dark-theme .instagram-create-textarea {
    color: #ffffff;
}

.instagram-create-textarea::placeholder {
    color: #8e8e8e;
}

body.dark-theme .instagram-create-textarea::placeholder {
    color: #a8a8a8;
}

.instagram-create-char-count {
    text-align: right;
    font-size: 12px;
    color: #8e8e8e;
    margin-top: 8px;
}

body.dark-theme .instagram-create-char-count {
    color: #a8a8a8;
}

.instagram-create-divider {
    height: 1px;
    background: #efefef;
    margin: 20px 0;
}

body.dark-theme .instagram-create-divider {
    background: #262626;
}

.instagram-create-upload-area {
    margin-top: 16px;
}

.instagram-create-file-input {
    display: none;
}

.instagram-create-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    border: 2px dashed #dbdbdb;
    border-radius: 12px;
    background: #fafafa;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

body.dark-theme .instagram-create-upload-label {
    background: #1a1a1a;
    border-color: #363636;
}

.instagram-create-upload-label:hover {
    border-color: #0095f6;
    background: #f0f8ff;
}

body.dark-theme .instagram-create-upload-label:hover {
    border-color: #0095f6;
    background: #0a1a2a;
}

.instagram-create-upload-label.drag-over {
    border-color: #0095f6;
    background: #e3f2fd;
    transform: scale(1.02);
}

body.dark-theme .instagram-create-upload-label.drag-over {
    background: #0a1a2a;
}

.instagram-create-upload-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e3f2fd;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    transition: all 0.3s;
}

body.dark-theme .instagram-create-upload-icon {
    background: #1a3a5a;
}

.instagram-create-upload-label:hover .instagram-create-upload-icon {
    background: #0095f6;
    transform: scale(1.1);
}

.instagram-create-upload-label:hover .instagram-create-upload-icon i {
    color: #ffffff;
}

.instagram-create-upload-icon i {
    font-size: 32px;
    color: #0095f6;
    transition: all 0.3s;
}

.instagram-create-upload-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.instagram-create-upload-title {
    font-size: 16px;
    font-weight: 600;
    color: #262626;
}

body.dark-theme .instagram-create-upload-title {
    color: #ffffff;
}

.instagram-create-upload-subtitle {
    font-size: 13px;
    color: #8e8e8e;
}

body.dark-theme .instagram-create-upload-subtitle {
    color: #a8a8a8;
}

.instagram-create-image-preview {
    margin-top: 16px;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-out;
}

.instagram-create-image-preview.show {
    display: block !important;
    opacity: 1 !important;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.instagram-create-image-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #fafafa;
    border: 2px solid #0095f6;
}

body.dark-theme .instagram-create-image-wrapper {
    background: #1a1a1a;
    border-color: #0095f6;
}

.instagram-create-image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    max-height: 500px;
    object-fit: contain;
}

.instagram-create-remove-image {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.7);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #ffffff;
    transition: all 0.2s;
}

.instagram-create-remove-image:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.instagram-create-footer {
    padding: 16px 20px;
    border-top: 1px solid #efefef;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

body.dark-theme .instagram-create-footer {
    border-color: #262626;
}

.instagram-create-cancel-btn {
    background: none;
    border: 1px solid #dbdbdb;
    border-radius: 8px;
    padding: 10px 20px;
    color: #262626;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

body.dark-theme .instagram-create-cancel-btn {
    border-color: #363636;
    color: #ffffff;
}

.instagram-create-cancel-btn:hover {
    background: #f0f0f0;
    border-color: #a8a8a8;
    text-decoration: none;
    color: #262626;
}

body.dark-theme .instagram-create-cancel-btn:hover {
    background: #2a2a2a;
    border-color: #555555;
    color: #ffffff;
}

.instagram-create-submit-btn {
    background: #0095f6;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(0, 149, 246, 0.3);
}

.instagram-create-submit-btn:hover {
    background: #0084d4;
    box-shadow: 0 4px 12px rgba(0, 149, 246, 0.4);
    transform: translateY(-1px);
}

.instagram-create-submit-btn:active {
    transform: translateY(0);
}

.instagram-create-submit-btn:disabled {
    background: #b2dffc;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

.instagram-create-submit-btn i {
    font-size: 18px;
}

.instagram-create-alert {
    max-width: 600px;
    margin: 20px auto;
    padding: 12px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    animation: slideDown 0.3s ease-out;
}

.instagram-create-alert.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

body.dark-theme .instagram-create-alert.alert-success {
    background: #1a3a2a;
    color: #4ade80;
    border-color: #2d5a3d;
}

.instagram-create-alert.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

body.dark-theme .instagram-create-alert.alert-error {
    background: #3a1a1a;
    color: #f87171;
    border-color: #5a2d2d;
}

.instagram-create-alert i {
    font-size: 20px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .instagram-create-container {
        margin: 20px auto;
        padding: 0 16px;
    }
    
    .instagram-create-card {
        border-radius: 0;
        border-left: none;
        border-right: none;
    }
    
    .instagram-create-footer {
        flex-direction: column;
    }
    
    .instagram-create-cancel-btn,
    .instagram-create-submit-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="instagram-create-container">
    <div class="instagram-create-card">
        <div class="instagram-create-header">
            @php
                use App\Services\LanguageService;
                
                // Get language from service
                $language = LanguageService::findByCode($major);
                
                // Logo mapping for backward compatibility and fallback
                $logoMap = [
                    'english' => 'easyenglish.png',
                    'korea' => 'easykorean.png',
                    'korean' => 'easykorean.png',
                    'chinese' => 'easychinese.png',
                    'japanese' => 'easyjapanese.png',
                    'russian' => 'easyrussian.png',
                ];
                
                // Get display name from language service or fallback
                $displayName = $language ? $language->display_name : (ucfirst($major) . ' Language');
                
                // Get logo file - prefer image_path from language service, fallback to logo map
                $logoFile = null;
                if ($language && $language->image_path) {
                    // If image_path is a full path, extract filename; if it's just a filename, use it
                    $logoFile = basename($language->image_path);
                } else {
                    // Fallback to logo map
                    $logoFile = $logoMap[$major] ?? $logoMap[strtolower($major)] ?? 'placeholder.png';
                }
                
                // Special fallback for Chinese (has two possible logo files)
                $fallbackLogo = ($major == 'chinese' && $logoFile == 'easychinese.png') ? 'easychinese.png' : 'placeholder.png';
            @endphp
            
            <img class="instagram-create-avatar" 
                 src="{{asset('public/img/'.$logoFile)}}" 
                 alt="{{$displayName}}" 
                 onerror="this.onerror=null; this.src='{{asset('public/img/'.$fallbackLogo)}}'; this.onerror=null; this.src='{{asset('public/img/placeholder.png')}}';">
            <div class="instagram-create-username">{{$displayName}}</div>
        </div>
        
        <div class="instagram-create-body">
            <form action="{{route('addPost',$major)}}" method="POST" enctype="multipart/form-data" id="createPostForm">
                @csrf
                
                <textarea 
                    name="body" 
                    id="createPostBody" 
                    class="instagram-create-textarea" 
                    placeholder="What's on your mind?" 
                    rows="6"
                    maxlength="2200"></textarea>
                
                <div class="instagram-create-char-count">
                    <span id="charCount">0</span> / 2,200 characters
                </div>
                
                <div class="instagram-create-divider"></div>
                
                <div class="instagram-create-upload-area">
                    <input type="file" name="myfile" id="createPostImageFile" class="instagram-create-file-input" accept="image/*">
                    <label for="createPostImageFile" class="instagram-create-upload-label" id="uploadLabel">
                        <div class="instagram-create-upload-icon">
                            <i class="material-icons">cloud_upload</i>
                        </div>
                        <div class="instagram-create-upload-text">
                            <span class="instagram-create-upload-title">Click to upload or drag and drop</span>
                            <span class="instagram-create-upload-subtitle">PNG, JPG, GIF up to 10MB</span>
                        </div>
                    </label>
                </div>
                
                <div class="instagram-create-image-preview" id="imagePreview" style="display: none;">
                    <div class="instagram-create-image-wrapper">
                        <img id="previewImage" src="" alt="Preview" style="max-width: 100%; height: auto; display: block;">
                        <button type="button" class="instagram-create-remove-image" onclick="removeImage();">
                            <i class="material-icons">close</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="instagram-create-footer">
            <a href="{{route('showTimeline',$major)}}" class="instagram-create-cancel-btn">
                <i class="material-icons">close</i>
                <span>Cancel</span>
            </a>
            <button type="submit" form="createPostForm" class="instagram-create-submit-btn" id="submitBtn">
                <i class="material-icons">check</i>
                <span>Post</span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.getElementById('createPostBody');
    var charCount = document.getElementById('charCount');
    var imageFile = document.getElementById('createPostImageFile');
    var imagePreview = document.getElementById('imagePreview');
    var previewImage = document.getElementById('previewImage');
    var uploadLabel = document.getElementById('uploadLabel');
    var submitBtn = document.getElementById('submitBtn');
    var form = document.getElementById('createPostForm');
    
    // Character counter
    function updateCharCount() {
        var length = textarea.value.length;
        charCount.textContent = length;
        
        if(length > 2000) {
            charCount.style.color = '#ed4956';
        } else {
            charCount.style.color = '';
        }
    }
    
    textarea.addEventListener('input', updateCharCount);
    updateCharCount();
    
    // Image preview
    imageFile.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if(file) {
            // Validate file size (10MB)
            if(file.size > 10 * 1024 * 1024) {
                alert('Image size must be less than 10MB');
                this.value = '';
                imagePreview.classList.remove('show');
                uploadLabel.style.display = 'flex';
                return;
            }
            
            // Validate file type
            if(!file.type.match('image.*')) {
                alert('Please select an image file');
                this.value = '';
                imagePreview.classList.remove('show');
                uploadLabel.style.display = 'flex';
                return;
            }
            
            var reader = new FileReader();
            reader.onload = function(e) {
                console.log('FileReader onload triggered');
                previewImage.src = e.target.result;
                // Immediately show preview
                imagePreview.style.display = 'block';
                imagePreview.classList.add('show');
                uploadLabel.style.display = 'none';
                console.log('Preview should be visible');
            };
            reader.onerror = function() {
                console.error('Error reading file');
                alert('Error reading file');
                imageFile.value = '';
                imagePreview.classList.remove('show');
                imagePreview.style.display = 'none';
                uploadLabel.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.remove('show');
            imagePreview.style.display = 'none';
            uploadLabel.style.display = 'flex';
        }
    });
    
    // Remove image
    window.removeImage = function() {
        if(imageFile) imageFile.value = '';
        if(imagePreview) {
            imagePreview.classList.remove('show');
            imagePreview.style.display = 'none';
        }
        if(uploadLabel) uploadLabel.style.display = 'flex';
    };
    
    // Drag and drop
    var uploadArea = uploadLabel;
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, function() {
            uploadArea.classList.add('drag-over');
        }, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, function() {
            uploadArea.classList.remove('drag-over');
        }, false);
    });
    
    uploadArea.addEventListener('drop', function(e) {
        var dt = e.dataTransfer;
        var files = dt.files;
        if(files.length > 0) {
            imageFile.files = files;
            imageFile.dispatchEvent(new Event('change'));
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        var body = textarea.value.trim();
        var hasImage = imageFile.files.length > 0;
        
        if(!body && !hasImage) {
            e.preventDefault();
            alert('Please add some text or an image to your post');
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="material-icons" style="animation: spin 1s linear infinite;">sync</i><span>Posting...</span>';
    });
    
    // Auto-hide alerts
    var alertBox = document.getElementById('customMessageBox');
    if(alertBox) {
        setTimeout(function() {
            alertBox.style.transition = 'opacity 0.3s ease-out';
            alertBox.style.opacity = '0';
            setTimeout(function() {
                alertBox.remove();
            }, 300);
        }, 3000);
    }
});
</script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection
