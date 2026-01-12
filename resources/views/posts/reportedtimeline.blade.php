@extends('layouts.navbar')
@section('content')

<style>
/* Reported Post Badge */
.reported-badge {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-left: 8px;
}

.reported-badge i {
    font-size: 10px;
}

/* Review Actions */
.review-actions {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    border-top: 1px solid #dbdbdb;
    background: #fafafa;
}

body.dark-theme .review-actions {
    border-color: #262626;
    background: #1a1a1a;
}

.review-btn {
    flex: 1;
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.review-btn-approve {
    background: #4caf50;
    color: white;
}

.review-btn-approve:hover {
    background: #45a049;
}

.review-btn-delete {
    background: #f44336;
    color: white;
}

.review-btn-delete:hover {
    background: #da190b;
}

.review-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Instagram Style Post Design */
.instagram-post {
    background: #ffffff;
    border: 1px solid #dbdbdb;
    border-radius: 0;
    margin-bottom: 24px;
    max-width: 614px;
    margin-left: auto;
    margin-right: auto;
    border-left: 4px solid #ff9800;
}

body.dark-theme .instagram-post {
    background: #000000;
    border-color: #262626;
    border-left-color: #ff9800;
}

/* Post Header */
.instagram-post-header {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-bottom: none;
}

.instagram-post-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-post-avatar {
    border-color: #262626;
}

.instagram-post-username {
    flex: 1;
    font-weight: 600;
    font-size: 14px;
    color: #262626;
    text-decoration: none;
}

body.dark-theme .instagram-post-username {
    color: #ffffff;
}

/* Post Media */
.instagram-post-media {
    width: 100%;
    background: #000000;
    display: block;
}

.instagram-post-media img {
    width: 100%;
    height: auto;
    display: block;
}

.instagram-post-video {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    background: #000000;
}

.instagram-post-video iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Post Engagement */
.instagram-post-engagement {
    padding: 0 16px 8px;
}

.instagram-likes-count {
    font-weight: 600;
    font-size: 14px;
    color: #262626;
    margin-bottom: 8px;
}

body.dark-theme .instagram-likes-count {
    color: #ffffff;
}

.instagram-post-caption {
    font-size: 14px;
    color: #262626;
    line-height: 1.5;
    margin-bottom: 4px;
    word-wrap: break-word;
}

body.dark-theme .instagram-post-caption {
    color: #ffffff;
}

.instagram-caption-username {
    font-weight: 600;
    color: #262626;
    text-decoration: none;
}

body.dark-theme .instagram-caption-username {
    color: #ffffff;
}

.post-meta {
    font-size: 12px;
    color: #8e8e8e;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #efefef;
}

body.dark-theme .post-meta {
    color: #a8a8a8;
    border-color: #262626;
}

.reported-timeline-header {
    max-width: 614px;
    margin: 24px auto;
    padding: 0 16px;
}

.reported-timeline-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: #262626;
    margin-bottom: 8px;
}

body.dark-theme .reported-timeline-header h2 {
    color: #ffffff;
}

.reported-timeline-header p {
    font-size: 14px;
    color: #8e8e8e;
    margin: 0;
}

body.dark-theme .reported-timeline-header p {
    color: #a8a8a8;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    max-width: 614px;
    margin: 0 auto;
}

.empty-state i {
    font-size: 64px;
    color: #dbdbdb;
    margin-bottom: 16px;
}

body.dark-theme .empty-state i {
    color: #262626;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 600;
    color: #262626;
    margin-bottom: 8px;
}

body.dark-theme .empty-state h3 {
    color: #ffffff;
}

.empty-state p {
    font-size: 14px;
    color: #8e8e8e;
}

body.dark-theme .empty-state p {
    color: #a8a8a8;
}

.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<div class="reported-timeline-header">
    <h2><i class="fas fa-flag"></i> Reported Posts</h2>
    <p>Review and moderate reported content. Total: {{ number_format($totalReported) }} reported posts</p>
</div>

<div class="instagram-container">
    <div class="container-fluid px-0">
        <div id="reportedPostsContainer">
            @if($reportedPosts && count($reportedPosts) > 0)
                @foreach ($reportedPosts as $reportedPost)
                    <div class="instagram-post" id="post-{{ $reportedPost->postId }}">
                        {{-- Post Header --}}
                        <div class="instagram-post-header">
                            <img class="instagram-post-avatar" 
                                 src="{{ $reportedPost->userImage }}" 
                                 alt="{{ $reportedPost->userName }}" 
                                 onerror="this.src='{{ asset('public/img/default-avatar.png') }}'">
                            <a href="#" class="instagram-post-username">{{ $reportedPost->userName }}</a>
                            <span class="reported-badge">
                                <i class="fas fa-flag"></i>
                                Reported {{ $reportedPost->report_count }} {{ $reportedPost->report_count == 1 ? 'time' : 'times' }}
                            </span>
                        </div>

                        {{-- Post Media --}}
                        @if($reportedPost->postImage != "" && $reportedPost->has_video == "0")
                            <img class="instagram-post-media" src="{{ $reportedPost->postImage }}" alt="Post image" onerror="this.style.display='none'">
                        @elseif($reportedPost->has_video == "1")
                            <div class="instagram-post-video">
                                <iframe src="{{ $reportedPost->vimeo }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @endif

                        {{-- Post Engagement --}}
                        <div class="instagram-post-engagement">
                            <div class="instagram-likes-count">{{ number_format($reportedPost->postLikes) }} likes</div>
                            <div class="instagram-post-caption">
                                <span class="instagram-caption-username">{{ $reportedPost->userName }}</span>
                                {{ $reportedPost->body }}
                            </div>
                            <div class="post-meta">
                                <div>Comments: {{ number_format($reportedPost->comments) }}</div>
                                @if($reportedPost->has_video == "1")
                                    <div>Views: {{ number_format($reportedPost->viewCount) }}</div>
                                @endif
                                <div>Language: {{ ucfirst($reportedPost->major) }}</div>
                            </div>
                        </div>

                        {{-- Review Actions --}}
                        <div class="review-actions">
                            <button type="button" 
                                    class="review-btn review-btn-approve" 
                                    onclick="approveReport({{ $reportedPost->postId }})"
                                    id="approve-btn-{{ $reportedPost->postId }}">
                                <i class="fas fa-check"></i>
                                <span>Approve</span>
                            </button>
                            <button type="button" 
                                    class="review-btn review-btn-delete" 
                                    onclick="deleteReportedPost({{ $reportedPost->postId }})"
                                    id="delete-btn-{{ $reportedPost->postId }}">
                                <i class="fas fa-trash"></i>
                                <span>Delete Post</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <h3>No Reported Posts</h3>
                    <p>All posts have been reviewed. Great job!</p>
                </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
            <div style="max-width: 614px; margin: 24px auto; padding: 0 16px; display: flex; justify-content: space-between; align-items: center;">
                @if($page > 1)
                    <a href="{{ route('showReportedPostsTimeline', ['page' => $page - 1]) }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @else
                    <span></span>
                @endif
                
                <span style="color: #8e8e8e; font-size: 14px;">
                    Page {{ $page }} of {{ $totalPages }}
                </span>
                
                @if($page < $totalPages)
                    <a href="{{ route('showReportedPostsTimeline', ['page' => $page + 1]) }}" 
                       class="btn btn-outline-primary">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span></span>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
function approveReport(postId) {
    if (!confirm('Are you sure you want to approve this post? It will be removed from the reported list.')) {
        return;
    }

    const approveBtn = document.getElementById('approve-btn-' + postId);
    const deleteBtn = document.getElementById('delete-btn-' + postId);
    const originalApproveText = approveBtn.innerHTML;
    
    // Disable buttons and show loading
    approveBtn.disabled = true;
    deleteBtn.disabled = true;
    approveBtn.innerHTML = '<span class="loading-spinner"></span> Approving...';

    const ajax = new XMLHttpRequest();
    ajax.open('POST', '{{url('/api/reports/approve')}}', true);
    ajax.setRequestHeader('Content-Type', 'application/json');
    ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                try {
                    const response = JSON.parse(ajax.responseText);
                    if (response.success) {
                        // Remove post from DOM with fade out
                        const postElement = document.getElementById('post-' + postId);
                        if (postElement) {
                            postElement.style.transition = 'opacity 0.3s, max-height 0.3s';
                            postElement.style.opacity = '0';
                            postElement.style.maxHeight = postElement.offsetHeight + 'px';
                            
                            setTimeout(function() {
                                postElement.style.maxHeight = '0';
                                postElement.style.overflow = 'hidden';
                                postElement.style.marginBottom = '0';
                                
                                setTimeout(function() {
                                    postElement.remove();
                                    
                                    // Check if container is empty
                                    const container = document.getElementById('reportedPostsContainer');
                                    if (container && container.children.length === 0) {
                                        container.innerHTML = `
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle"></i>
                                                <h3>No Reported Posts</h3>
                                                <p>All posts have been reviewed. Great job!</p>
                                            </div>
                                        `;
                                    }
                                }, 300);
                            }, 300);
                        }
                        
                        // Show success message
                        alert('Post approved successfully!');
                    } else {
                        alert('Error: ' + (response.message || 'Failed to approve post'));
                        approveBtn.disabled = false;
                        deleteBtn.disabled = false;
                        approveBtn.innerHTML = originalApproveText;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert('Error processing response');
                    approveBtn.disabled = false;
                    deleteBtn.disabled = false;
                    approveBtn.innerHTML = originalApproveText;
                }
            } else {
                alert('Network error. Please try again.');
                approveBtn.disabled = false;
                deleteBtn.disabled = false;
                approveBtn.innerHTML = originalApproveText;
            }
        }
    };
    
    ajax.send(JSON.stringify({ post_id: postId }));
}

function deleteReportedPost(postId) {
    if (!confirm('Are you sure you want to DELETE this post? This action cannot be undone. The post and all its comments will be permanently removed.')) {
        return;
    }

    const approveBtn = document.getElementById('approve-btn-' + postId);
    const deleteBtn = document.getElementById('delete-btn-' + postId);
    const originalDeleteText = deleteBtn.innerHTML;
    
    // Disable buttons and show loading
    approveBtn.disabled = true;
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<span class="loading-spinner"></span> Deleting...';

    const ajax = new XMLHttpRequest();
    ajax.open('POST', '{{url('/api/reports/delete-post')}}', true);
    ajax.setRequestHeader('Content-Type', 'application/json');
    ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                try {
                    const response = JSON.parse(ajax.responseText);
                    if (response.success) {
                        // Remove post from DOM with fade out
                        const postElement = document.getElementById('post-' + postId);
                        if (postElement) {
                            postElement.style.transition = 'opacity 0.3s, max-height 0.3s';
                            postElement.style.opacity = '0';
                            postElement.style.maxHeight = postElement.offsetHeight + 'px';
                            
                            setTimeout(function() {
                                postElement.style.maxHeight = '0';
                                postElement.style.overflow = 'hidden';
                                postElement.style.marginBottom = '0';
                                
                                setTimeout(function() {
                                    postElement.remove();
                                    
                                    // Check if container is empty
                                    const container = document.getElementById('reportedPostsContainer');
                                    if (container && container.children.length === 0) {
                                        container.innerHTML = `
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle"></i>
                                                <h3>No Reported Posts</h3>
                                                <p>All posts have been reviewed. Great job!</p>
                                            </div>
                                        `;
                                    }
                                }, 300);
                            }, 300);
                        }
                        
                        // Show success message
                        alert('Post deleted successfully!');
                    } else {
                        alert('Error: ' + (response.message || 'Failed to delete post'));
                        approveBtn.disabled = false;
                        deleteBtn.disabled = false;
                        deleteBtn.innerHTML = originalDeleteText;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert('Error processing response');
                    approveBtn.disabled = false;
                    deleteBtn.disabled = false;
                    deleteBtn.innerHTML = originalDeleteText;
                }
            } else {
                alert('Network error. Please try again.');
                approveBtn.disabled = false;
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = originalDeleteText;
            }
        }
    };
    
    ajax.send(JSON.stringify({ post_id: postId }));
}
</script>

@endsection
