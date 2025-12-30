@extends('layouts.main')

@section('content')

<div class="row mb-4">
  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="course-title-header">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <img src="{{$icon}}" style="width: 40px; height:40 px; margin-right: 16px; border-radius: 50%;" alt="{{$cate}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Crect width=\'48\' height=\'48\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'20\'%3E📚%3C/text%3E%3C/svg%3E'"/>
            <h4 class="mb-0">{{$cate}}</h4>
          </div>
          <a href="javascript:history.back()" class="new-category-btn btn-cancel">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
          </a>
        </div>
      </div>
      <div class="card-body">
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
                      <i class="fas fa-clock me-1"></i>{{$lesson->duration}} min
                    </span>
                  @endif
                </div>
              </div>
              <div class="lesson-item-buttons">
                <a href="{{$viewLesson}}" class="lesson-action-btn btn-detail" title="View Details">
                  <i class="fas fa-eye"></i>
                  <span>Detail</span>
                </a>
                <a href="{{route('showAddLesson', $lesson->category_id)}}?edit={{$lesson->id}}" class="lesson-action-btn btn-edit" title="Edit Lesson">
                  <i class="fas fa-edit"></i>
                  <span>Edit</span>
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

@endsection
