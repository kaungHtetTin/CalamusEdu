@extends('layouts.main')

@section('content')
<style>
  .post-detail-container {
    max-width: 800px;
    margin: 0 auto;
  }
  
  .post-detail-header {
    margin-bottom: 24px;
  }
  
  .post-detail-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0;
  }
  
  .post-detail-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 24px;
    overflow: hidden;
  }
  
  .post-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  .post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .post-user-info {
    flex: 1;
  }
  
  .post-username {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
    margin: 0;
  }
  
  .post-meta {
    font-size: 12px;
    color: var(--text-muted);
    margin: 0;
  }
  
  .post-body {
    padding: 16px 20px;
    color: var(--text-primary);
    line-height: 1.6;
    white-space: pre-wrap;
  }
  
  .post-media {
    width: 100%;
    max-height: 600px;
    object-fit: contain;
    background: var(--bg-primary);
  }
  
  .post-video {
    width: 100%;
    max-height: 600px;
  }
  
  .post-actions {
    padding: 12px 20px;
    border-top: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 16px;
  }
  
  .post-action-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 14px;
  }
  
  .post-action-item i {
    font-size: 18px;
  }
  
  .comments-section {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 20px;
  }
  
  .comments-section-header {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border-color);
  }
  
  .comments-section-header h2 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
  }
  
  .comment-item {
    padding: 16px 0;
    border-bottom: 1px solid var(--border-color);
  }
  
  .comment-item:last-child {
    border-bottom: none;
  }
  
  .comment-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
  }
  
  .comment-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .comment-user {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
  }
  
  .comment-time {
    font-size: 12px;
    color: var(--text-muted);
    margin-left: auto;
  }
  
  .comment-body {
    color: var(--text-primary);
    font-size: 14px;
    line-height: 1.5;
    margin-left: 44px;
    white-space: pre-wrap;
  }
  
  .comment-image {
    max-width: 300px;
    max-height: 300px;
    border-radius: 8px;
    margin-top: 8px;
    margin-left: 44px;
  }
  
  .comment-actions {
    margin-left: 44px;
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 16px;
  }
  
  .comment-action-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 12px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    transition: all 0.2s ease;
  }
  
  .comment-action-btn:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
  }
  
  .replies-section {
    margin-left: 44px;
    margin-top: 16px;
    padding-left: 16px;
    border-left: 2px solid var(--border-color);
  }
  
  .reply-item {
    padding: 12px 0;
    border-bottom: 1px solid var(--border-color);
  }
  
  .reply-item:last-child {
    border-bottom: none;
  }
  
  .reply-form {
    margin-top: 16px;
    padding: 16px;
    background: var(--bg-tertiary);
    border-radius: 8px;
  }
  
  .reply-form textarea {
    width: 100%;
    padding: 12px;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-primary);
    font-size: 14px;
    resize: vertical;
    min-height: 80px;
    margin-bottom: 12px;
  }
  
  .reply-form textarea:focus {
    outline: none;
    border-color: var(--primary-color);
  }
  
  .reply-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
  }
  
  .btn-reply {
    padding: 8px 16px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .btn-reply:hover {
    background: var(--primary-color-hover);
  }
  
  .btn-cancel {
    padding: 8px 16px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .btn-cancel:hover {
    background: var(--bg-primary);
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
  
  .empty-comments {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
  }
  
  .empty-comments i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
  }
</style>

<div class="post-detail-container">
  <div class="post-detail-header">
    <a href="{{ route('showAdminNotifications') }}" class="btn btn-sm btn-outline-secondary mb-3">
      <i class="fas fa-arrow-left"></i> Back to Notifications
    </a>
    <h1>Post Detail</h1>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if($post)
    <!-- Post Card -->
    <div class="post-detail-card">
      <div class="post-header">
        <img src="{{ $post->userImage ?? asset('public/img/default-avatar.png') }}" 
             alt="{{ $post->userName }}" 
             class="post-avatar"
             onerror="this.src='{{ asset('public/img/default-avatar.png') }}'">
        <div class="post-user-info">
          <p class="post-username">{{ $post->userName ?? 'Unknown User' }}</p>
          <p class="post-meta">
            <i class="fas fa-globe"></i> {{ ucfirst($post->major ?? 'english') }}
            @if($post->view_count)
              <span class="ml-3"><i class="fas fa-eye"></i> {{ number_format($post->view_count) }} views</span>
            @endif
          </p>
        </div>
      </div>

      @if($post->body)
        <div class="post-body">{{ $post->body }}</div>
      @endif

      @if($post->has_video && $post->vimeo)
        <div style="padding: 0;">
          <iframe src="{{ $post->vimeo }}" 
                  width="100%" 
                  height="450" 
                  frameborder="0" 
                  allow="autoplay; fullscreen; picture-in-picture" 
                  allowfullscreen
                  class="post-video"></iframe>
        </div>
      @elseif($post->image)
        <img src="{{ $post->image }}" alt="Post image" class="post-media">
      @endif

      <div class="post-actions">
        <div class="post-action-item">
          <i class="fas fa-heart"></i>
          <span>{{ number_format($post->post_like ?? 0) }}</span>
        </div>
        <div class="post-action-item">
          <i class="fas fa-comment"></i>
          <span>{{ number_format($post->comments ?? 0) }}</span>
        </div>
        <div class="post-action-item">
          <i class="fas fa-share"></i>
          <span>{{ number_format($post->share_count ?? 0) }}</span>
        </div>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
      <div class="comments-section-header">
        <h2>
          <i class="fas fa-comments"></i> 
          Comments ({{ count($comments) }})
        </h2>
      </div>

      @if(count($comments) > 0)
        @foreach($comments as $comment)
          <div class="comment-item" id="comment-{{ $comment->time }}">
            <div class="comment-header">
              <img src="{{ $comment->userImage ?? asset('public/img/default-avatar.png') }}" 
                   alt="{{ $comment->userName }}" 
                   class="comment-avatar"
                   onerror="this.src='{{ asset('public/img/default-avatar.png') }}'">
              <span class="comment-user">{{ $comment->userName ?? 'Unknown User' }}</span>
              <span class="comment-time">
                @php
                  $timeAgo = '';
                  if($comment->time) {
                    $diff = time() - ($comment->time / 1000);
                    if ($diff < 60) $timeAgo = 'Just now';
                    elseif ($diff < 3600) $timeAgo = floor($diff/60) . 'm ago';
                    elseif ($diff < 86400) $timeAgo = floor($diff/3600) . 'h ago';
                    elseif ($diff < 604800) $timeAgo = floor($diff/86400) . 'd ago';
                    else $timeAgo = date('M j, Y', $comment->time / 1000);
                  }
                @endphp
                {{ $timeAgo }}
              </span>
            </div>
            <div class="comment-body">{{ $comment->body }}</div>
            @if($comment->commentImage)
              <img src="{{ $comment->commentImage }}" alt="Comment image" class="comment-image">
            @endif
            <div class="comment-actions">
              <button type="button" 
                      class="comment-action-btn" 
                      onclick="toggleReplyForm({{ $comment->time }})">
                <i class="fas fa-reply"></i> Reply
              </button>
              @if($comment->likes > 0)
                <span class="comment-action-btn">
                  <i class="fas fa-heart"></i> {{ $comment->likes }}
                </span>
              @endif
            </div>

            <!-- Reply Form (Hidden by default) -->
            <div class="reply-form" id="reply-form-{{ $comment->time }}" style="display: none;">
              <form action="{{ route('posts.reply') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->time }}">
                <textarea name="body" 
                          placeholder="Write a reply..." 
                          required
                          rows="3"></textarea>
                <div class="reply-form-actions">
                  <button type="button" 
                          class="btn-cancel" 
                          onclick="toggleReplyForm({{ $comment->time }})">
                    Cancel
                  </button>
                  <button type="submit" class="btn-reply">
                    <i class="fas fa-paper-plane"></i> Reply
                  </button>
                </div>
              </form>
            </div>

            <!-- Replies -->
            @if(isset($comment->replies) && count($comment->replies) > 0)
              <div class="replies-section">
                @foreach($comment->replies as $reply)
                  <div class="reply-item" id="reply-{{ $reply->time }}">
                    <div class="comment-header">
                      <img src="{{ $reply->userImage ?? asset('public/img/default-avatar.png') }}" 
                           alt="{{ $reply->userName }}" 
                           class="comment-avatar"
                           onerror="this.src='{{ asset('public/img/default-avatar.png') }}'">
                      <span class="comment-user">
                        {{ $reply->userName ?? 'Unknown User' }}
                        @if($reply->writer_id == 10000)
                          <span class="badge badge-primary badge-sm ml-2">Admin</span>
                        @endif
                      </span>
                      <span class="comment-time">
                        @php
                          $timeAgo = '';
                          if($reply->time) {
                            $diff = time() - ($reply->time / 1000);
                            if ($diff < 60) $timeAgo = 'Just now';
                            elseif ($diff < 3600) $timeAgo = floor($diff/60) . 'm ago';
                            elseif ($diff < 86400) $timeAgo = floor($diff/3600) . 'h ago';
                            elseif ($diff < 604800) $timeAgo = floor($diff/86400) . 'd ago';
                            else $timeAgo = date('M j, Y', $reply->time / 1000);
                          }
                        @endphp
                        {{ $timeAgo }}
                      </span>
                    </div>
                    <div class="comment-body">{{ $reply->body }}</div>
                    @if($reply->commentImage)
                      <img src="{{ $reply->commentImage }}" alt="Reply image" class="comment-image">
                    @endif
                    @if($reply->likes > 0)
                      <div class="comment-actions">
                        <span class="comment-action-btn">
                          <i class="fas fa-heart"></i> {{ $reply->likes }}
                        </span>
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        @endforeach
      @else
        <div class="empty-comments">
          <i class="fas fa-comment-slash"></i>
          <p>No comments yet. Be the first to comment!</p>
        </div>
      @endif
    </div>
  @else
    <div class="alert alert-error">
      Post not found.
    </div>
  @endif
</div>

<script>
  function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
      if (form.style.display === 'block') {
        const textarea = form.querySelector('textarea');
        if (textarea) {
          textarea.focus();
        }
      }
    }
  }
</script>
@endsection
