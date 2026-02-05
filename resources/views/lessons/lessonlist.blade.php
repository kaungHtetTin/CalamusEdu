@extends('layouts.main')

@section('content')

<div class="row mb-4">
  <div class="col-xl-12 col-md-12">
    <div class="card language-data-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #32cd32;">
        <h5 class="language-data-title mb-0" style="color: #32cd32;">
          <img src="{{$icon}}" style="width: 24px; height: 24px; margin-right: 8px; border-radius: 50%; vertical-align: middle;" alt="{{$cate}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\'%3E%3Crect width=\'24\' height=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'12\'%3E📚%3C/text%3E%3C/svg%3E'"/>
          {{$cate}}
        </h5>
        <div class="d-flex gap-2 flex-wrap">
          <button type="button" class="btn-primary btn-sm" data-mdb-toggle="modal" data-mdb-target="#newLessonModal">
            <i class="fas fa-plus"></i>
            <span>New Lesson</span>
          </button>
          <a href="javascript:history.back()" class="btn-back btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
          </a>
        </div>
      </div>
      <div class="language-data-body">
        <div class="lesson-list-container">
          @foreach ($lessons as $lesson)
          @php
            if($lesson->isVideo==1){
              $viewLesson=route('viewVideoLesson',$lesson->id);
            }else{
              $viewLesson=route('viewBlogLesson',$lesson->id);
            }
          @endphp
          
          <div class="lesson-item-card">
            <div class="lesson-item-content">
              <div class="lesson-thumbnail">
                @if ($lesson->isVideo==1)
                  <img src="{{$lesson->thumbnail}}" alt="{{$lesson->title}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'60\'%3E%3Crect width=\'80\' height=\'60\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'24\'%3E▶%3C/text%3E%3C/svg%3E'">
                  <div class="video-play-overlay">
                    <i class="fas fa-play"></i>
                  </div>
                @else
                  <img src="{{$icon}}" alt="{{$lesson->title}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'60\'%3E%3Crect width=\'80\' height=\'60\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'20\'%3E📄%3C/text%3E%3C/svg%3E'">
                @endif
                @if($lesson->isVip==1)
                  <div class="vip-badge">
                    <i class="fas fa-crown"></i>
                  </div>
                @endif
              </div>
              <div class="lesson-item-info">
                <h6 class="lesson-title">{{$lesson->title}}</h6>
                <div class="lesson-meta">
                  @if($lesson->isVideo==1)
                    <span class="lesson-type-badge video-badge">
                      <i class="fas fa-video me-1"></i>Video
                    </span>
                  @else
                    <span class="lesson-type-badge document-badge">
                      <i class="fas fa-file-alt me-1"></i>Document
                    </span>
                  @endif
                  @if($lesson->duration > 0)
                    <span class="lesson-duration">
                      <i class="fas fa-clock me-1"></i>{{\App\Services\VimeoService::formatDuration($lesson->duration)}}
                    </span>
                  @endif
                </div>
              </div>
              <div class="lesson-item-buttons">
                <a href="{{$viewLesson}}" class="btn-action-primary" title="View Details">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{$lesson->isVideo == 1 ? route('lessons.editVideo', $lesson->id) : route('lessons.editDocument', $lesson->id)}}" class="btn-action-warning" title="Edit Lesson">
                  <i class="fas fa-edit"></i>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- New Lesson Modal --}}
<div class="modal fade" id="newLessonModal" tabindex="-1" aria-labelledby="newLessonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content language-data-card" style="max-width: 480px;">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #32cd32;">
        <h5 class="language-data-title mb-0" style="color: #32cd32;">
          <i class="fas fa-plus me-2"></i>Select Lesson Type
        </h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" style="filter: invert(1); opacity: 0.6;"></button>
      </div>
      <div class="language-data-body">
        <div class="lesson-list-container">
          <a href="{{route('showAddVideoLesson', $category_id)}}" class="lesson-item-card" style="text-decoration: none; display: block;">
            <div class="lesson-item-content">
              <div class="lesson-thumbnail">
                <div style="width: 100%; height: 100%; background: rgba(33, 150, 243, 0.1); display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                  <i class="fas fa-video" style="color: #2196f3; font-size: 24px;"></i>
                </div>
              </div>
              <div class="lesson-item-info">
                <h6 class="lesson-title">Video Lesson</h6>
                <div class="lesson-meta">
                  <span class="lesson-type-badge video-badge">
                    <i class="fas fa-video me-1"></i>Video
                  </span>
                </div>
              </div>
            </div>
          </a>
          <a href="{{route('showAddDocumentLesson', $category_id)}}" class="lesson-item-card" style="text-decoration: none; display: block;">
            <div class="lesson-item-content">
              <div class="lesson-thumbnail">
                <div style="width: 100%; height: 100%; background: rgba(255, 152, 0, 0.1); display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                  <i class="fas fa-file-alt" style="color: #ff9800; font-size: 24px;"></i>
                </div>
              </div>
              <div class="lesson-item-info">
                <h6 class="lesson-title">Document Lesson</h6>
                <div class="lesson-meta">
                  <span class="lesson-type-badge document-badge">
                    <i class="fas fa-file-alt me-1"></i>Document
                  </span>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
.modal-content.language-data-card {
  border: 1px solid var(--border-color);
  border-radius: 6px;
  overflow: hidden;
}

.modal-content.language-data-card .language-data-header {
  border-radius: 0;
}

.modal-content.language-data-card .btn-close:hover {
  opacity: 1;
}

body.light-theme .modal-content.language-data-card .btn-close {
  filter: none;
  opacity: 0.5;
}

body.light-theme .modal-content.language-data-card .btn-close:hover {
  opacity: 0.75;
}

.lesson-item-card {
  cursor: pointer;
}

.lesson-item-card:hover {
  text-decoration: none;
}

/* Center modal between drawer and window edge */
@media (min-width: 992px) {
  #newLessonModal .modal-dialog {
    left: calc(50% + 140px);
    transform: translate(-50%, -50%);
    margin: 0;
  }
}

@media (max-width: 991.98px) {
  #newLessonModal .modal-dialog {
    left: 50%;
    transform: translate(-50%, -50%);
    margin: 0;
  }
}
</style>
@endpush

@endsection
