@extends('layouts.navbar')

@section('content')

@if (session('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('msg')}}
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
          <i class="fas fa-gamepad me-2"></i>
          Add Game Word - {{ucwords($major)}}
        </h5>
        <a href="{{route('showGameWord', $major)}}" class="btn-back btn-sm">
          <i class="fas fa-arrow-left"></i>
          <span>Back</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <ul class="nav nav-tabs mb-4" id="gameWordTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="word-tab" data-toggle="tab" href="#word" role="tab" aria-controls="word" aria-selected="true">
              <i class="fas fa-font me-2"></i>Display Word
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="image-tab" data-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">
              <i class="fas fa-image me-2"></i>Display Image
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="audio-tab" data-toggle="tab" href="#audio" role="tab" aria-controls="audio" aria-selected="false">
              <i class="fas fa-volume-up me-2"></i>Display Audio
            </a>
          </li>
        </ul>

        <div class="tab-content" id="gameWordTabContent">
          <!-- Display Word Tab -->
          <div class="tab-pane fade show active" id="word" role="tabpanel">
            <form action="{{route('addGameWord',$major)}}" method="POST">
              @csrf
              <input type="hidden" value="1" name="category"/>
              
              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-font me-2"></i>Word Display
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="displayword" class="form-label">Display Word</label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="displayword"
                           name="displayword" 
                           value="{{old('displayword')}}"
                           placeholder="Enter word to display">
                    @error('displayword')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-list-ul me-2"></i>Answer Options
                </h6>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="ansA_word" class="form-label">Option A <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansA_word"
                           name="ansA" 
                           value="{{old('ansA')}}"
                           placeholder="Enter option A"
                           required>
                    @error('ansA')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansB_word" class="form-label">Option B <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansB_word"
                           name="ansB" 
                           value="{{old('ansB')}}"
                           placeholder="Enter option B"
                           required>
                    @error('ansB')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansC_word" class="form-label">Option C <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansC_word"
                           name="ansC" 
                           value="{{old('ansC')}}"
                           placeholder="Enter option C"
                           required>
                    @error('ansC')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-check-circle me-2"></i>Correct Answer
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Select Correct Answer <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_a_word" value="a" {{old('ans') == 'a' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_a_word">Option A</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_b_word" value="b" {{old('ans') == 'b' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_b_word">Option B</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_c_word" value="c" {{old('ans') == 'c' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_c_word">Option C</label>
                      </div>
                    </div>
                    @error('ans')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <a href="{{route('showGameWord', $major)}}" class="btn-back btn-sm">
                  <i class="fas fa-arrow-left"></i>
                  <span>Cancel</span>
                </a>
                <button type="submit" class="new-category-btn">
                  <i class="fas fa-save"></i>
                  <span>Add Game Word</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Display Image Tab -->
          <div class="tab-pane fade" id="image" role="tabpanel">
            <form action="{{route('addGameWord',$major)}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" value="2" name="category"/>
              
              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-image me-2"></i>Image Upload
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="imageFile" class="form-label">Game Word Image <span class="text-danger">*</span></label>
                    <div class="image-upload-wrapper">
                      <div class="image-upload-area" id="image_upload_area">
                        <input type="file" class="d-none" id="imageFile" name="myfile" accept="image/*" required>
                        <div class="upload-placeholder" id="image_placeholder">
                          <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9c27b0;"></i>
                          <p class="mb-2">Click to upload image</p>
                          <small class="text-muted">Image format (Required)</small>
                        </div>
                        <div class="image-preview d-none" id="image_preview">
                          <img id="image_preview_img" src="" alt="Image Preview">
                          <button type="button" class="btn-remove-image" id="image_remove_btn" title="Remove image">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    @error('myfile')
                      <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-list-ul me-2"></i>Answer Options
                </h6>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="ansA_image" class="form-label">Option A <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansA_image"
                           name="ansA" 
                           value="{{old('ansA')}}"
                           placeholder="Enter option A"
                           required>
                    @error('ansA')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansB_image" class="form-label">Option B <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansB_image"
                           name="ansB" 
                           value="{{old('ansB')}}"
                           placeholder="Enter option B"
                           required>
                    @error('ansB')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansC_image" class="form-label">Option C <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansC_image"
                           name="ansC" 
                           value="{{old('ansC')}}"
                           placeholder="Enter option C"
                           required>
                    @error('ansC')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-check-circle me-2"></i>Correct Answer
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Select Correct Answer <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_a_image" value="a" {{old('ans') == 'a' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_a_image">Option A</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_b_image" value="b" {{old('ans') == 'b' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_b_image">Option B</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_c_image" value="c" {{old('ans') == 'c' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_c_image">Option C</label>
                      </div>
                    </div>
                    @error('ans')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <a href="{{route('showGameWord', $major)}}" class="btn-back btn-sm">
                  <i class="fas fa-arrow-left"></i>
                  <span>Cancel</span>
                </a>
                <button type="submit" class="new-category-btn">
                  <i class="fas fa-save"></i>
                  <span>Add Game Word</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Display Audio Tab -->
          <div class="tab-pane fade" id="audio" role="tabpanel">
            <form action="{{route('addGameWord',$major)}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" value="3" name="category"/>
              
              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-volume-up me-2"></i>Audio Upload
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="audioFile" class="form-label">Game Word Audio <span class="text-danger">*</span></label>
                    <div class="file-upload-wrapper">
                      <div class="file-upload-area" id="audio_upload_area">
                        <input type="file" class="d-none" id="audioFile" name="myfile" accept="audio/*" required>
                        <div class="upload-placeholder" id="audio_placeholder">
                          <i class="fas fa-music fa-3x mb-3" style="color: #9c27b0;"></i>
                          <p class="mb-2">Click to upload audio file</p>
                          <small class="text-muted">Audio format (Required)</small>
                        </div>
                        <div class="file-preview d-none" id="audio_preview">
                          <i class="fas fa-file-audio fa-3x mb-2"></i>
                          <div class="file-name-wrapper">
                            <span class="file-name" id="audio_file_name"></span>
                            <button type="button" class="btn-remove-file" id="audio_remove_btn" title="Remove file">
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @error('myfile')
                      <p class="text-danger" style="font-size: 12px; margin-top: 5px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-list-ul me-2"></i>Answer Options
                </h6>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="ansA_audio" class="form-label">Option A <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansA_audio"
                           name="ansA" 
                           value="{{old('ansA')}}"
                           placeholder="Enter option A"
                           required>
                    @error('ansA')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansB_audio" class="form-label">Option B <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansB_audio"
                           name="ansB" 
                           value="{{old('ansB')}}"
                           placeholder="Enter option B"
                           required>
                    @error('ansB')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="ansC_audio" class="form-label">Option C <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control modern-input" 
                           id="ansC_audio"
                           name="ansC" 
                           value="{{old('ansC')}}"
                           placeholder="Enter option C"
                           required>
                    @error('ansC')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h6 class="form-section-title">
                  <i class="fas fa-check-circle me-2"></i>Correct Answer
                </h6>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Select Correct Answer <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_a_audio" value="a" {{old('ans') == 'a' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_a_audio">Option A</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_b_audio" value="b" {{old('ans') == 'b' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_b_audio">Option B</label>
                      </div>
                      <div class="form-check">
                        <input class="" type="radio" name="ans" id="ans_c_audio" value="c" {{old('ans') == 'c' ? 'checked' : ''}} required>
                        <label class="form-check-label" for="ans_c_audio">Option C</label>
                      </div>
                    </div>
                    @error('ans')
                      <p class="text-danger" style="font-size: 12px;">{{$message}}</p>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <a href="{{route('showGameWord', $major)}}" class="btn-back btn-sm">
                  <i class="fas fa-arrow-left"></i>
                  <span>Cancel</span>
                </a>
                <button type="submit" class="new-category-btn">
                  <i class="fas fa-save"></i>
                  <span>Add Game Word</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.file-upload-wrapper {
    margin-bottom: 1rem;
}

.file-upload-area {
    position: relative;
    border: 2px dashed rgba(156, 39, 176, 0.6);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 150px;
}

.file-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

.file-preview {
    text-align: center;
    padding: 20px;
    color: var(--text-primary);
    position: relative;
    z-index: 1;
    width: 100%;
}

.file-preview i {
    color: #9c27b0;
    font-size: 2.5rem !important;
    margin-bottom: 10px;
    display: block;
}

.file-name-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 6px 8px;
    background: rgba(156, 39, 176, 0.1);
    border-radius: 6px;
    max-width: 90%;
}

.file-name {
    font-size: 12px;
    font-weight: 500;
    word-break: break-word;
    color: var(--text-primary);
    flex: 1;
    min-width: 0;
}

.btn-remove-file {
    background: transparent;
    color: var(--text-secondary);
    border: none;
    border-radius: 4px;
    width: 20px;
    height: 20px;
    min-width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    flex-shrink: 0;
}

.btn-remove-file:hover {
    background: rgba(220, 53, 69, 0.15);
    color: #dc3545;
}

.image-upload-wrapper {
    margin-bottom: 1rem;
}

.image-upload-area {
    position: relative;
    border: 2px dashed rgba(156, 39, 176, 0.6);
    border-radius: 12px;
    background: var(--bg-secondary);
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 16 / 9;
    max-width: 400px;
}

.image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

.upload-placeholder {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    position: relative;
    z-index: 1;
}

.upload-placeholder i {
    color: #9c27b0;
    font-size: 2.5rem !important;
    margin-bottom: 10px;
    display: block;
}

.upload-placeholder p {
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 5px !important;
    color: var(--text-primary);
}

.upload-placeholder small {
    font-size: 11px;
    color: var(--text-secondary);
    display: block;
}

.image-preview {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
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
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
    z-index: 10;
}

.btn-remove-image:hover {
    background: #c82333;
}

.nav-tabs {
    border-bottom: 2px solid var(--bg-tertiary);
}

.nav-tabs .nav-link {
    color: var(--text-secondary);
    border: none;
    border-bottom: 2px solid transparent;
    padding: 12px 20px;
    transition: all 0.2s ease;
}

.nav-tabs .nav-link:hover {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color-light);
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    background: transparent;
    border-bottom-color: var(--primary-color);
    font-weight: 600;
}

body.dark-theme .file-upload-area,
body.dark-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.7);
    background: rgba(255, 255, 255, 0.02);
}

body.dark-theme .file-upload-area:hover,
body.dark-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.1);
}

body.light-theme .file-upload-area,
body.light-theme .image-upload-area {
    border-color: rgba(156, 39, 176, 0.5);
    background: #f8f9fa;
}

body.light-theme .file-upload-area:hover,
body.light-theme .image-upload-area:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.08);
}

@media (max-width: 768px) {
    .image-upload-area {
        max-width: 100%;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation
    const tabLinks = document.querySelectorAll('#gameWordTabs .nav-link');
    const tabPanes = document.querySelectorAll('.tab-content .tab-pane');
    
    tabLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and panes
            tabLinks.forEach(function(tab) {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            tabPanes.forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            
            // Show corresponding pane
            const targetId = this.getAttribute('href').substring(1);
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
    
    // Image upload
    const imageInput = document.getElementById('imageFile');
    const imageUploadArea = document.getElementById('image_upload_area');
    const imagePlaceholder = document.getElementById('image_placeholder');
    const imagePreview = document.getElementById('image_preview');
    const imagePreviewImg = document.getElementById('image_preview_img');
    const imageRemoveBtn = document.getElementById('image_remove_btn');

    if (imageUploadArea) {
        imageUploadArea.addEventListener('click', function() {
            imageInput.click();
        });

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviewImg.src = e.target.result;
                    imagePlaceholder.classList.add('d-none');
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        imageRemoveBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            imageInput.value = '';
            imagePlaceholder.classList.remove('d-none');
            imagePreview.classList.add('d-none');
            imagePreviewImg.src = '';
        });
    }

    // Audio upload
    const audioInput = document.getElementById('audioFile');
    const audioUploadArea = document.getElementById('audio_upload_area');
    const audioPlaceholder = document.getElementById('audio_placeholder');
    const audioPreview = document.getElementById('audio_preview');
    const audioFileName = document.getElementById('audio_file_name');
    const audioRemoveBtn = document.getElementById('audio_remove_btn');

    if (audioUploadArea) {
        audioUploadArea.addEventListener('click', function() {
            audioInput.click();
        });

        audioInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                audioFileName.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
                audioPlaceholder.classList.add('d-none');
                audioPreview.classList.remove('d-none');
            }
        });

        audioRemoveBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            audioInput.value = '';
            audioPlaceholder.classList.remove('d-none');
            audioPreview.classList.add('d-none');
            audioFileName.textContent = '';
        });
    }
});
</script>
@endpush

@endsection