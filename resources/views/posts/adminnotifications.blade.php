@extends('layouts.main')

@section('content')

<style>
.notification-item {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.notification-item.unread {
    background-color: #f8f9fa;
    border-left-color: #2196F3;
}

body.dark-theme .notification-item.unread {
    background-color: #1a1a1a;
    border-left-color: #2196F3;
}

.notification-item:hover {
    background-color: #f0f0f0;
}

body.dark-theme .notification-item:hover {
    background-color: #2a2a2a;
}

.notification-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e0e0e0;
}

body.dark-theme .notification-avatar {
    border-color: #404040;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #f44336;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
}

.mark-all-read-btn {
    margin-left: auto;
}
</style>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-bell"></i> Comments & Replies Notifications
                    @if($unreadNotificationsCount > 0)
                        <span class="badge badge-primary ml-2">{{ $unreadNotificationsCount }} unread</span>
                    @endif
                </h4>
                @if($unreadNotificationsCount > 0)
                    <button type="button" class="btn btn-sm btn-primary mark-all-read-btn" onclick="markAllAsRead()">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </button>
                @endif
            </div>
            <div class="card-body p-0">
                @if($adminNotifications && count($adminNotifications) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($adminNotifications as $notification)
                            @php
                                $isReply = $notification->comment_parent > 0;
                                $timeAgo = '';
                                if($notification->time) {
                                    $diff = time() - ($notification->time / 1000);
                                    if ($diff < 60) $timeAgo = 'Just now';
                                    elseif ($diff < 3600) $timeAgo = floor($diff/60) . 'm ago';
                                    elseif ($diff < 86400) $timeAgo = floor($diff/3600) . 'h ago';
                                    elseif ($diff < 604800) $timeAgo = floor($diff/86400) . 'd ago';
                                    elseif ($diff < 2592000) $timeAgo = floor($diff/604800) . 'w ago';
                                    elseif ($diff < 31536000) $timeAgo = floor($diff/2592000) . 'mo ago';
                                    else $timeAgo = floor($diff/31536000) . 'y ago';
                                }
                                
                                $mCodeMap = [
                                    'english' => 'ee',
                                    'korea' => 'ko',
                                    'chinese' => 'cn',
                                    'japanese' => 'jp',
                                    'russian' => 'ru'
                                ];
                                $mCode = $mCodeMap[$notification->major ?? 'english'] ?? 'ee';
                            @endphp
                            <div class="list-group-item notification-item {{ $notification->seen == 0 ? 'unread' : '' }}" 
                                 data-notification-id="{{ $notification->id }}">
                                <div class="d-flex align-items-start">
                                    <div style="position: relative; margin-right: 16px;">
                                        <img src="{{ $notification->writer_image ?? asset('public/img/default-avatar.png') }}" 
                                             alt="{{ $notification->writer_name }}" 
                                             class="notification-avatar"
                                             onerror="this.src='{{ asset('public/img/default-avatar.png') }}'">
                                        @if($notification->seen == 0)
                                            <span class="notification-badge"></span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong style="font-size: 15px;">{{ $notification->writer_name ?? 'Unknown User' }}</strong>
                                                <span class="text-muted ml-2" style="font-size: 14px;">
                                                    {{ $isReply ? 'replied to your comment' : 'commented on your post' }}
                                                </span>
                                                @if($notification->seen == 0)
                                                    <span class="badge badge-primary badge-sm ml-2">New</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $timeAgo }}</small>
                                        </div>
                                        
                                        @if($notification->comment_body)
                                            <div class="mb-2" style="padding: 12px; background: #f5f5f5; border-radius: 8px; font-size: 14px; color: #333;">
                                                <i class="fas fa-comment text-primary"></i>
                                                {{ Str::limit($notification->comment_body, 150) }}
                                            </div>
                                        @endif
                                        
                                        @if($notification->post_body)
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-file-alt"></i> 
                                                    <strong>Post:</strong> {{ Str::limit($notification->post_body, 80) }}
                                                </small>
                                            </div>
                                        @endif
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('showTimeline', $notification->major ?? 'english') }}?mCode={{ $mCode }}&page=1#post-{{ $notification->post_id }}" 
                                               class="btn btn-sm btn-primary" 
                                               onclick="markAsRead({{ $notification->id }})">
                                                <i class="fas fa-eye"></i> View Post
                                            </a>
                                            @if($notification->seen == 0)
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary" 
                                                        onclick="markAsRead({{ $notification->id }})">
                                                    <i class="fas fa-check"></i> Mark as Read
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No notifications yet</h5>
                        <p class="text-muted">You'll see comments and replies on your posts here.</p>
                        <a href="{{ route('showMainPostControllerView') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left"></i> Back to Posts
                        </a>
                    </div>
                @endif
            </div>
            
            @if($totalPages > 1)
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Showing page {{ $page }} of {{ $totalPages }} ({{ $totalNotifications }} total notifications)
                            </small>
                        </div>
                        <div>
                            @if($page > 1)
                                <a href="{{ route('showAdminNotifications', ['page' => $page - 1]) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif
                            
                            @if($page < $totalPages)
                                <a href="{{ route('showAdminNotifications', ['page' => $page + 1]) }}" 
                                   class="btn btn-sm btn-outline-primary ml-2">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
    
    // Optimistically update UI
    if (notificationElement) {
        notificationElement.classList.remove('unread');
        const badge = notificationElement.querySelector('.notification-badge');
        if (badge) badge.remove();
        const newBadge = notificationElement.querySelector('.badge-primary');
        if (newBadge && newBadge.textContent.trim() === 'New') {
            newBadge.remove();
        }
    }
    
    // Mark as read via API
    const ajax = new XMLHttpRequest();
    ajax.open('POST', '/api/notifications/mark-read', true);
    ajax.setRequestHeader('Content-Type', 'application/json');
    ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                try {
                    const response = JSON.parse(ajax.responseText);
                    if (response.success) {
                        // Update unread count if displayed
                        const unreadBadge = document.querySelector('.badge-primary');
                        if (unreadBadge) {
                            const currentCount = parseInt(unreadBadge.textContent);
                            if (currentCount > 1) {
                                unreadBadge.textContent = currentCount - 1;
                            } else {
                                unreadBadge.remove();
                                const markAllBtn = document.querySelector('.mark-all-read-btn');
                                if (markAllBtn) markAllBtn.remove();
                            }
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            } else {
                // Rollback on error
                if (notificationElement) {
                    notificationElement.classList.add('unread');
                }
            }
        }
    };
    
    ajax.send(JSON.stringify({ notification_id: notificationId }));
}

function markAllAsRead() {
    if (!confirm('Mark all notifications as read?')) {
        return;
    }
    
    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
    const notificationIds = Array.from(unreadNotifications).map(el => 
        parseInt(el.getAttribute('data-notification-id'))
    );
    
    if (notificationIds.length === 0) {
        return;
    }
    
    // Optimistically update UI
    unreadNotifications.forEach(el => {
        el.classList.remove('unread');
        const badge = el.querySelector('.notification-badge');
        if (badge) badge.remove();
        const newBadge = el.querySelector('.badge-primary');
        if (newBadge && newBadge.textContent.trim() === 'New') {
            newBadge.remove();
        }
    });
    
    // Mark all as read via API
    notificationIds.forEach(notificationId => {
        const ajax = new XMLHttpRequest();
        ajax.open('POST', '/api/notifications/mark-read', true);
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        ajax.send(JSON.stringify({ notification_id: notificationId }));
    });
    
    // Update UI
    const unreadBadge = document.querySelector('.badge-primary');
    if (unreadBadge) unreadBadge.remove();
    const markAllBtn = document.querySelector('.mark-all-read-btn');
    if (markAllBtn) markAllBtn.remove();
}
</script>

@endsection
