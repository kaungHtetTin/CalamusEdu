@extends('layouts.main')

@section('content')

@php
    $views=countFormat($post->view_count,"view");
    $commentCount=countFormat($post->comments,"comment");
    $likes=countFormat($post->postLikes,"like");
    function countFormat($count ,$unit){
      if($count==0){
            return "No ".$unit;
        }else if($count==1){
            return "1 ".$unit;
        }else if($count>=1000&&$count<1000000){
            $count=number_format($count/1000,1);
            return $count."k ".$unit."s";
        }else if($count>=1000000){
            $count=number_format($count/1000000,1);
            return $count."M ".$unit."s";
        }else{
            return  $count." ".$unit."s";
        }
    }
@endphp

<div class="row mb-4">
  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="course-title-header">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="fas fa-video me-3" style="font-size: 24px; color: #32cd32;"></i>
            <h4 class="mb-0">{{$lesson->title}}</h4>
          </div>
          <a href="javascript:history.back()" class="btn-back btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          {{-- Video Player Section --}}
          <div class="col-xl-8 col-md-12 mb-4">
            <div class="video-player-container">
              <div class="video-wrapper">
                <iframe id="myVimeoPlayer" src="{{$post->vimeo}}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="{{$lesson->title}}"></iframe>
              </div>
              
              {{-- Video Stats --}}
              <div class="video-stats-bar">
                <div class="video-stat-item" id="react" onclick="likeVideo();" style="cursor: pointer">
                  @if ($post->is_liked==0)
                    <i class="material-icons" id="noneReactIcon">favorite_border</i>
                  @else
                    <i class="material-icons" id="noneReactIcon" style="color:#f44336">favorite</i>
                  @endif
                  <span id="tvLikes">{{$likes}}</span>
                </div>
                <div class="video-stat-item">
                  <i class="material-icons">speaker_notes</i>
                  <span>{{$commentCount}}</span>
                </div>
                <div class="video-stat-item">
                  <i class="material-icons">visibility</i>
                  <span>{{$views}}</span>
                </div>
                @if($post->video_url != "")
                <div class="video-stat-item">
                  <a href="{{$post->video_url}}" target="_blank" class="download-link" title="Download Video">
                    <i class="fas fa-download"></i>
                    <span>Download</span>
                  </a>
                </div>
                @endif
              </div>
            </div>
          </div>

          {{-- Lesson Info Sidebar --}}
          <div class="col-xl-4 col-md-12 mb-4">
            <div class="lesson-info-card">
              <div class="lesson-info-header">
                <h6 class="mb-0">
                  <i class="fas fa-info-circle me-2"></i>Lesson Information
                </h6>
              </div>
              <div class="lesson-info-body">
                <div class="info-item">
                  <span class="info-label">Type:</span>
                  <span class="info-value">
                    <span class="lesson-type-badge video-badge">
                      <i class="fas fa-video me-1"></i>Video Lesson
                    </span>
                  </span>
                </div>
                @if($lesson->duration > 0)
                <div class="info-item">
                  <span class="info-label">Duration:</span>
                  <span class="info-value">{{$lesson->duration}} minutes</span>
                </div>
                @endif
                @if($lesson->isVip==1)
                <div class="info-item">
                  <span class="info-label">Access:</span>
                  <span class="info-value">
                    <span class="vip-label">
                      <i class="fas fa-crown me-1"></i>VIP
                    </span>
                  </span>
                </div>
                @endif
                @if($post->video_url != "")
                <div class="info-item">
                  <span class="info-label">Download:</span>
                  <span class="info-value">
                    <a href="{{$post->video_url}}" target="_blank" class="download-link-text">
                      <i class="fas fa-download me-1"></i>Available
                    </a>
                  </span>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        {{-- Comments Section --}}
        <div class="row mt-2">
          <div class="col-xl-12">
            <div class="comments-section">
              <div class="comments-header">
                <h6 class="mb-0">
                  <i class="fas fa-comments me-2"></i>Comments ({{$commentCount}})
                </h6>
              </div>
              
              {{-- Add Comment Form --}}
              <div class="comment-form-container">
                <form id="addCommentForm" class="comment-form">
                  <div class="comment-form-avatar">
                    @if(isset($adminUser) && $adminUser && $adminUser->learner_image)
                      <img src="{{$adminUser->learner_image}}" alt="{{$adminUser->learner_name ?? 'Admin'}}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(50, 205, 50, 0.3);" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                      <i class="fas fa-user-circle" style="display: none;"></i>
                    @else
                      <i class="fas fa-user-circle"></i>
                    @endif
                  </div>
                  <div class="comment-form-input-wrapper">
                    <input type="text" 
                           id="commentInput" 
                           class="comment-form-input" 
                           placeholder="Write a comment..." 
                           autocomplete="off">
                    <button type="submit" class="comment-form-submit">
                      <i class="fas fa-paper-plane"></i>
                      <span>Post</span>
                    </button>
                  </div>
                </form>
              </div>

              <div class="comments-list" id="commentsList">
                @if(count($comments) > 0)
                  @foreach ($comments as $comment)
                  <div class="comment-item" data-comment-id="{{$comment->id}}">
                    <div class="comment-avatar">
                      <img src="{{$comment->userImage}}" alt="{{$comment->userName}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\'%3E%3Ccircle cx=\'20\' cy=\'20\' r=\'20\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'16\' font-weight=\'600\'%3E{{substr($comment->userName, 0, 1)}}%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="comment-content">
                      <div class="comment-header">
                        <span class="comment-author">{{$comment->userName}}</span>
                        <span class="comment-date">
                          <?php 
                            $s = $comment->time/ 1000;
                            $d= date("d/M/Y", $s);
                            echo $d;
                          ?>
                        </span>
                      </div>
                      <div class="comment-body">
                        {{$comment->body}}
                      </div>
                      <div class="comment-actions">
                        <button class="comment-reply-btn" onclick="showReplyForm({{$comment->id}}, '{{$comment->userName}}')">
                          <i class="fas fa-reply me-1"></i>Reply
                        </button>
                      </div>
                      {{-- Reply Form (Hidden by default) --}}
                      <div class="reply-form-container" id="replyForm{{$comment->id}}" style="display: none;">
                        <form class="reply-form" onsubmit="submitReply(event, {{$comment->id}})">
                          <div class="reply-form-input-wrapper">
                            <input type="text" 
                                   class="reply-form-input" 
                                   id="replyInput{{$comment->id}}"
                                   placeholder="Reply to {{$comment->userName}}..." 
                                   autocomplete="off">
                            <button type="submit" class="reply-form-submit">
                              <i class="fas fa-paper-plane"></i>
                            </button>
                            <button type="button" class="reply-form-cancel" onclick="hideReplyForm({{$comment->id}})">
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </form>
                      </div>
                      {{-- Replies Container --}}
                      <div class="replies-container" id="replies{{$comment->id}}">
                        @if(isset($comment->replies) && count($comment->replies) > 0)
                          @foreach($comment->replies as $reply)
                          <div class="reply-item">
                            <div class="reply-avatar">
                              <img src="{{$reply->userImage}}" alt="{{$reply->userName}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'32\' height=\'32\'%3E%3Ccircle cx=\'16\' cy=\'16\' r=\'16\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'12\' font-weight=\'600\'%3E{{substr($reply->userName, 0, 1)}}%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="reply-content">
                              <div class="reply-header">
                                <span class="reply-author">{{$reply->userName}}</span>
                                <span class="reply-date">
                                  <?php 
                                    $s = $reply->time/ 1000;
                                    $d= date("d/M/Y", $s);
                                    echo $d;
                                  ?>
                                </span>
                              </div>
                              <div class="reply-body">
                                {{$reply->body}}
                              </div>
                            </div>
                          </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                  @endforeach
                @else
                  <div class="no-comments">
                    <i class="fas fa-comment-slash me-2"></i>No comments yet
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
  var isAlreadyLike = "<?php echo $post->is_liked ?>"==1 ? true : false;
  var likeCount="<?php echo $post->postLikes?>";
  var postId = <?php echo $post->post_id?>;
  var ownerId = <?php echo $post->learner_id ?? 0?>;
  // Admin user with learner_phone 10000
  var userId = 10000; // This is the learner_phone for the admin user

  function likeVideo(){
    var noneReatIcon=document.getElementById('noneReactIcon');
    var tvLikes=document.getElementById('tvLikes');
    if(isAlreadyLike){
      isAlreadyLike=false;
      noneReatIcon.innerHTML="favorite_border";
      noneReatIcon.removeAttribute('style');
      likeCount--;
    }else{
      isAlreadyLike=true;
      noneReatIcon.innerHTML="favorite";
      noneReatIcon.setAttribute('style','color:#f44336');
      likeCount++;
    }
    var ajax=new XMLHttpRequest();
    ajax.onload =function(){
      if(ajax.status==200 || ajax.readyState==4){
        if(likeCount<=999){
          if(likeCount>1){
            tvLikes.innerHTML=likeCount.toString().concat(' likes');
          }else{
            tvLikes.innerHTML=likeCount.toString().concat(' like');
          }
        }else{
          tvLikes.innerHTML='<?php echo $likes?>';
        }
      }
    }
    ajax.open("POST","https://www.calamuseducation.com/calamus/api/posts/like",true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("user_id=10000&post_id="+postId+"&time=<?php echo time()?>");
  }

  // Add Comment
  document.getElementById('addCommentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var commentText = document.getElementById('commentInput').value.trim();
    if(commentText.length < 1){
      alert('Please enter a comment!');
      return;
    }
    addComment(postId, ownerId, 0, commentText);
  });

  function addComment(post_id, owner_id, action, body) {
    var ajax = new XMLHttpRequest();
    ajax.onload = function() {
      if(ajax.status == 200 || ajax.readyState == 4) {
        document.getElementById('commentInput').value = '';
        fetchComments();
      }
    }
    var time = Math.round(Date.now());
    ajax.open("POST", "https://www.calamuseducation.com/calamus/api/comments/add", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("writer_id=" + userId + "&post_id=" + post_id + "&time=" + time + "&body=" + encodeURIComponent(body) + "&owner_id=" + owner_id + "&action=" + action);
  }

  // Reply to Comment
  function showReplyForm(commentId, userName) {
    var replyForm = document.getElementById('replyForm' + commentId);
    var replyInput = document.getElementById('replyInput' + commentId);
    replyForm.style.display = 'block';
    replyInput.focus();
    replyInput.placeholder = 'Reply to ' + userName + '...';
  }

  function hideReplyForm(commentId) {
    document.getElementById('replyForm' + commentId).style.display = 'none';
    document.getElementById('replyInput' + commentId).value = '';
  }

  function submitReply(event, parentCommentId) {
    event.preventDefault();
    var replyInput = document.getElementById('replyInput' + parentCommentId);
    var replyText = replyInput.value.trim();
    if(replyText.length < 1) {
      alert('Please enter a reply!');
      return;
    }
    // For replies, action should be the parent comment ID
    addComment(postId, ownerId, parentCommentId, replyText);
    hideReplyForm(parentCommentId);
  }

  // Fetch Comments (to refresh after adding)
  function fetchComments() {
    var ajax = new XMLHttpRequest();
    ajax.onload = function() {
      if(ajax.status == 200 || ajax.readyState == 4) {
        location.reload(); // Simple reload for now, can be optimized with AJAX
      }
    }
    ajax.open("GET", window.location.href, true);
    ajax.send();
  }

  // Vimeo Player initialization
  var iframe = document.querySelector('#myVimeoPlayer');
  if(iframe){
    var player = new Vimeo.Player(iframe);
    player.on('play', function() {
      console.log('Played the video');
    });
    player.getVideoTitle().then(function(title) {
      console.log('title:', title);
    });
  }
</script>
@endpush

@endsection

 

