@extends('layouts.navbar')
@section('content')

<style>
/* Instagram Style Post Design */
.instagram-post {
    background: #ffffff;
    border: 1px solid #dbdbdb;
    border-radius: 0;
    margin-bottom: 24px;
    max-width: 614px;
    margin-left: auto;
    margin-right: auto;
}

body.dark-theme .instagram-post {
    background: #000000;
    border-color: #262626;
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

.instagram-post-username:hover {
    text-decoration: none;
    color: #262626;
}

body.dark-theme .instagram-post-username:hover {
    color: #ffffff;
}

.instagram-post-more {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    color: #262626;
    display: flex;
    align-items: center;
    justify-content: center;
}

body.dark-theme .instagram-post-more {
    color: #ffffff;
}

.instagram-post-more:hover {
    opacity: 0.7;
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

/* Post Actions */
.instagram-post-actions {
    padding: 0;
    display: flex;
    align-items: center;
    padding: 6px 0;
}

.instagram-action-btn {
    background: none;
    border: none;
    padding: 8px 16px 8px 0;
    cursor: pointer;
    color: #262626;
    display: flex;
    align-items: center;
    transition: opacity 0.2s;
}

body.dark-theme .instagram-action-btn {
    color: #ffffff;
}

.instagram-action-btn:hover {
    opacity: 0.7;
}

.instagram-action-btn i {
    font-size: 24px;
}

.instagram-action-btn.liked i {
    color: #ed4956;
}

.instagram-action-btn.liked {
    color: #ed4956;
}

.instagram-action-btn.save-btn {
    margin-left: auto;
    padding-right: 0;
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

.instagram-caption-username:hover {
    text-decoration: none;
}

.instagram-view-comments {
    font-size: 14px;
    color: #8e8e8e;
    cursor: pointer;
    margin-top: 4px;
    margin-bottom: 4px;
}

body.dark-theme .instagram-view-comments {
    color: #a8a8a8;
}

.instagram-view-comments:hover {
    color: #8e8e8e;
}

body.dark-theme .instagram-view-comments:hover {
    color: #a8a8a8;
}

.instagram-post-time {
    font-size: 10px;
    color: #8e8e8e;
    text-transform: uppercase;
    margin-top: 8px;
    margin-bottom: 4px;
}

body.dark-theme .instagram-post-time {
    color: #a8a8a8;
}

/* Comment Input */
.instagram-comment-box {
    border-top: 1px solid #efefef;
    padding: 0 16px;
    display: flex;
    align-items: center;
    min-height: 56px;
}

body.dark-theme .instagram-comment-box {
    border-color: #262626;
}

.instagram-comment-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin-right: 16px;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-comment-avatar {
    border-color: #262626;
}

.instagram-comment-input {
    flex: 1;
    border: none;
    background: transparent;
    color: #262626;
    font-size: 14px;
    padding: 0;
    outline: none;
    resize: none;
    max-height: 80px;
}

body.dark-theme .instagram-comment-input {
    color: #ffffff;
}

.instagram-comment-input::placeholder {
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-input::placeholder {
    color: #a8a8a8;
}

.instagram-comment-post {
    background: none;
    border: none;
    color: #0095f6;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    padding: 0;
    margin-left: 16px;
    opacity: 0.3;
    transition: opacity 0.2s;
}

.instagram-comment-post.active {
    opacity: 1;
}

.instagram-comment-post:hover {
    opacity: 0.7;
}

/* Create Post Box */
.instagram-create-post {
    background: #ffffff;
    border: 1px solid #dbdbdb;
    border-radius: 0;
    padding: 16px;
    margin-bottom: 24px;
    max-width: 614px;
    margin-left: auto;
    margin-right: auto;
}

body.dark-theme .instagram-create-post {
    background: #000000;
    border-color: #262626;
}

.instagram-create-post-header {
    display: flex;
    align-items: center;
    gap: 12px;
}

.instagram-create-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-create-avatar {
    border-color: #262626;
}

.instagram-create-input {
    flex: 1;
    border: 1px solid #dbdbdb;
    border-radius: 6px;
    padding: 8px 12px;
    background: #fafafa;
    color: #262626;
    font-size: 14px;
    cursor: pointer;
    transition: border-color 0.2s;
}

body.dark-theme .instagram-create-input {
    background: #262626;
    border-color: #363636;
    color: #ffffff;
}

.instagram-create-input:hover {
    border-color: #a8a8a8;
}

body.dark-theme .instagram-create-input:hover {
    border-color: #555555;
}

.instagram-create-input::placeholder {
    color: #8e8e8e;
}

body.dark-theme .instagram-create-input::placeholder {
    color: #a8a8a8;
}

/* Container */
.instagram-container {
    background: #fafafa;
    min-height: 100vh;
    padding: 30px 0;
}

body.dark-theme .instagram-container {
    background: #000000;
}

@media (max-width: 768px) {
    .instagram-post,
    .instagram-create-post {
        max-width: 100%;
        border-left: none;
        border-right: none;
        margin-bottom: 0;
    }
    
    .instagram-container {
        padding: 0;
    }
}

/* Comment Modal - Instagram Style */
.instagram-comment-modal {
    max-width: 500px;
}

.instagram-comment-modal-content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 90vh;
}

body.dark-theme .instagram-comment-modal-content {
    background: #000000;
}

.instagram-comment-header {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 14px 16px;
    border-bottom: 1px solid #efefef;
    position: relative;
}

body.dark-theme .instagram-comment-header {
    border-color: #262626;
}

.instagram-comment-title {
    font-size: 16px;
    font-weight: 600;
    color: #262626;
    margin: 0;
}

body.dark-theme .instagram-comment-title {
    color: #ffffff;
}

.instagram-comment-close {
    position: absolute;
    right: 16px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #262626;
    display: flex;
    align-items: center;
    justify-content: center;
}

body.dark-theme .instagram-comment-close {
    color: #ffffff;
}

.instagram-comment-close:hover {
    opacity: 0.7;
}

.instagram-comment-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 140px);
}

.instagram-comment-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-loading {
    color: #a8a8a8;
}

.instagram-comment-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid #efefef;
    border-top-color: #262626;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-bottom: 12px;
}

body.dark-theme .instagram-comment-spinner {
    border-color: #262626;
    border-top-color: #ffffff;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Smooth transitions */
.instagram-edit-section {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .instagram-edit-modal {
        max-width: 100%;
        margin: 0;
    }
    
    .instagram-edit-modal-content {
        border-radius: 0;
        max-height: 100vh;
    }
    
    .instagram-edit-body {
        max-height: calc(100vh - 140px);
    }
    
    .instagram-edit-footer {
        flex-direction: column;
        gap: 12px;
    }
    
    .instagram-edit-cancel-btn,
    .instagram-edit-save-btn {
        width: 100%;
        justify-content: center;
    }
}

.instagram-comment-item {
    display: flex;
    padding: 12px 16px;
    border-bottom: 1px solid #efefef;
    transition: background-color 0.2s;
}

body.dark-theme .instagram-comment-item {
    border-color: #262626;
}

.instagram-comment-item:hover {
    background-color: #fafafa;
}

body.dark-theme .instagram-comment-item:hover {
    background-color: #1a1a1a;
}

.instagram-comment-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
    flex-shrink: 0;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-comment-avatar {
    border-color: #262626;
}

.instagram-comment-content {
    flex: 1;
    min-width: 0;
}

.instagram-comment-author {
    font-weight: 600;
    font-size: 14px;
    color: #262626;
    text-decoration: none;
    margin-right: 4px;
}

body.dark-theme .instagram-comment-author {
    color: #ffffff;
}

.instagram-comment-author:hover {
    text-decoration: none;
    color: #262626;
}

body.dark-theme .instagram-comment-author:hover {
    color: #ffffff;
}

.instagram-comment-text {
    font-size: 14px;
    color: #262626;
    line-height: 1.5;
    word-wrap: break-word;
    margin: 0;
    display: inline;
}

body.dark-theme .instagram-comment-text {
    color: #ffffff;
}

.instagram-comment-image {
    width: 200px;
    height: auto;
    border-radius: 8px;
    margin-top: 8px;
    display: block;
}

.instagram-comment-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 8px;
    font-size: 12px;
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-actions {
    color: #a8a8a8;
}

.instagram-comment-like-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #8e8e8e;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    transition: color 0.2s;
}

body.dark-theme .instagram-comment-like-btn {
    color: #a8a8a8;
}

.instagram-comment-like-btn:hover {
    color: #262626;
}

body.dark-theme .instagram-comment-like-btn:hover {
    color: #ffffff;
}

.instagram-comment-like-btn.liked {
    color: #ed4956;
}

.instagram-comment-like-btn i {
    font-size: 16px;
}

.instagram-comment-time {
    font-size: 12px;
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-time {
    color: #a8a8a8;
}

/* Reply Comments */
.instagram-comment-replies {
    margin-left: 44px;
    margin-top: 8px;
    padding-left: 12px;
    border-left: 2px solid #efefef;
}

body.dark-theme .instagram-comment-replies {
    border-color: #262626;
}

.instagram-comment-reply-item {
    display: flex;
    padding: 8px 0;
    border-bottom: none;
}

.instagram-comment-reply-item:hover {
    background-color: transparent;
}

body.dark-theme .instagram-comment-reply-item:hover {
    background-color: transparent;
}

.instagram-comment-reply-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 8px;
    flex-shrink: 0;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-comment-reply-avatar {
    border-color: #262626;
}

.instagram-comment-reply-content {
    flex: 1;
    min-width: 0;
}

.instagram-comment-reply-text {
    font-size: 14px;
    color: #262626;
    line-height: 1.5;
    word-wrap: break-word;
    margin: 0;
    display: inline;
}

body.dark-theme .instagram-comment-reply-text {
    color: #ffffff;
}

.instagram-comment-reply-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 4px;
    font-size: 12px;
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-reply-actions {
    color: #a8a8a8;
}

.instagram-comment-reply-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #8e8e8e;
    font-size: 12px;
    font-weight: 600;
    transition: color 0.2s;
}

body.dark-theme .instagram-comment-reply-btn {
    color: #a8a8a8;
}

.instagram-comment-reply-btn:hover {
    color: #262626;
}

body.dark-theme .instagram-comment-reply-btn:hover {
    color: #ffffff;
}

.instagram-comment-delete-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #8e8e8e;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    transition: color 0.2s;
    opacity: 0.7;
}

body.dark-theme .instagram-comment-delete-btn {
    color: #a8a8a8;
}

.instagram-comment-delete-btn:hover {
    color: #ed4956;
    opacity: 1;
}

body.dark-theme .instagram-comment-delete-btn:hover {
    color: #ed4956;
}

.instagram-comment-delete-btn i {
    font-size: 16px;
}

.instagram-comment-reply-form {
    margin-left: 44px;
    margin-top: 8px;
    padding: 8px 0;
    display: none;
}

.instagram-comment-reply-form.active {
    display: block;
}

.instagram-comment-reply-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.instagram-comment-reply-input {
    flex: 1;
    border: 1px solid #dbdbdb;
    border-radius: 6px;
    padding: 6px 12px;
    background: #fafafa;
    color: #262626;
    font-size: 14px;
    outline: none;
    resize: none;
}

body.dark-theme .instagram-comment-reply-input {
    background: #262626;
    border-color: #363636;
    color: #ffffff;
}

.instagram-comment-reply-input:focus {
    border-color: #a8a8a8;
}

body.dark-theme .instagram-comment-reply-input:focus {
    border-color: #555555;
}

.instagram-comment-reply-submit {
    background: none;
    border: none;
    color: #0095f6;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    padding: 6px 12px;
    opacity: 0.3;
    transition: opacity 0.2s;
}

.instagram-comment-reply-submit:not(:disabled) {
    opacity: 1;
}

.instagram-comment-reply-submit:not(:disabled):hover {
    opacity: 0.7;
}

.instagram-comment-reply-submit:disabled {
    cursor: not-allowed;
}

.instagram-comment-reply-cancel {
    background: none;
    border: none;
    color: #8e8e8e;
    font-size: 14px;
    cursor: pointer;
    padding: 6px 12px;
}

body.dark-theme .instagram-comment-reply-cancel {
    color: #a8a8a8;
}

.instagram-comment-reply-cancel:hover {
    color: #262626;
}

body.dark-theme .instagram-comment-reply-cancel:hover {
    color: #ffffff;
}

.instagram-view-replies {
    font-size: 12px;
    color: #8e8e8e;
    cursor: pointer;
    margin-left: 44px;
    margin-top: 4px;
    font-weight: 600;
}

body.dark-theme .instagram-view-replies {
    color: #a8a8a8;
}

.instagram-view-replies:hover {
    color: #262626;
}

body.dark-theme .instagram-view-replies:hover {
    color: #ffffff;
}

.instagram-comment-reply-count {
    font-size: 12px;
    color: #8e8e8e;
    margin-left: 44px;
    margin-top: 4px;
    font-weight: 600;
    cursor: pointer;
    display: inline-block;
}

body.dark-theme .instagram-comment-reply-count {
    color: #a8a8a8;
}

.instagram-comment-reply-count:hover {
    color: #262626;
}

body.dark-theme .instagram-comment-reply-count:hover {
    color: #ffffff;
}

.instagram-comment-empty {
    text-align: center;
    padding: 60px 20px;
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-empty {
    color: #a8a8a8;
}

.instagram-comment-empty i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.instagram-comment-footer {
    border-top: 1px solid #efefef;
    padding: 8px 16px;
}

body.dark-theme .instagram-comment-footer {
    border-color: #262626;
}

.instagram-comment-input-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.instagram-comment-footer-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 1px solid #dbdbdb;
}

body.dark-theme .instagram-comment-footer-avatar {
    border-color: #262626;
}

.instagram-comment-input-field {
    flex: 1;
    border: none;
    background: transparent;
    color: #262626;
    font-size: 14px;
    padding: 8px 0;
    outline: none;
    resize: none;
}

body.dark-theme .instagram-comment-input-field {
    color: #ffffff;
}

.instagram-comment-input-field::placeholder {
    color: #8e8e8e;
}

body.dark-theme .instagram-comment-input-field::placeholder {
    color: #a8a8a8;
}

.instagram-comment-post-btn {
    background: none;
    border: none;
    color: #0095f6;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    padding: 0;
    opacity: 0.3;
    transition: opacity 0.2s;
}

.instagram-comment-post-btn:not(:disabled) {
    opacity: 1;
}

.instagram-comment-post-btn:not(:disabled):hover {
    opacity: 0.7;
}

.instagram-comment-post-btn:disabled {
    cursor: not-allowed;
}

/* Modal backdrop */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.65);
}

body.dark-theme .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.85);
}

/* Scrollbar styling for comment body */
.instagram-comment-body::-webkit-scrollbar {
    width: 8px;
}

.instagram-comment-body::-webkit-scrollbar-track {
    background: #fafafa;
}

body.dark-theme .instagram-comment-body::-webkit-scrollbar-track {
    background: #1a1a1a;
}

.instagram-comment-body::-webkit-scrollbar-thumb {
    background: #dbdbdb;
    border-radius: 4px;
}

body.dark-theme .instagram-comment-body::-webkit-scrollbar-thumb {
    background: #363636;
}

.instagram-comment-body::-webkit-scrollbar-thumb:hover {
    background: #b2b2b2;
}

body.dark-theme .instagram-comment-body::-webkit-scrollbar-thumb:hover {
    background: #555555;
}

/* Enhanced Edit Post Modal Styles */
.instagram-edit-modal {
    max-width: 600px;
    z-index: 1070 !important;
}

.instagram-edit-modal-content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    position: relative;
    z-index: 1070;
}

body.dark-theme .instagram-edit-modal-content {
    background: #000000;
}

/* Ensure modal backdrop is above navbar */
#editPostDialog.modal {
    z-index: 1065 !important;
}

#editPostDialog.modal.show {
    z-index: 1065 !important;
}

/* Delete Post Dialog z-index fix */
#deletePostDialog.modal {
    z-index: 1065 !important;
}

#deletePostDialog.modal.show {
    z-index: 1065 !important;
}

#deletePostDialog .modal-dialog {
    z-index: 1065 !important;
}

/* Comment Dialog z-index fix */
#commentDialog.modal {
    z-index: 1065 !important;
}

#commentDialog.modal.show {
    z-index: 1065 !important;
}

#commentDialog .modal-dialog {
    z-index: 1065 !important;
}

/* Modal backdrop z-index fix */
body > .modal-backdrop {
    z-index: 1064 !important;
}

body > .modal-backdrop.show {
    z-index: 1064 !important;
}

/* Ensure modal dialog is above backdrop */
#editPostDialog .modal-dialog {
    z-index: 1065 !important;
}

.instagram-edit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #efefef;
    position: relative;
}

body.dark-theme .instagram-edit-header {
    border-color: #262626;
}

.instagram-edit-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.instagram-edit-back {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #262626;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}

body.dark-theme .instagram-edit-back {
    color: #ffffff;
}

.instagram-edit-back:hover {
    background: #f0f0f0;
}

body.dark-theme .instagram-edit-back:hover {
    background: #1a1a1a;
}

.instagram-edit-title {
    font-size: 16px;
    font-weight: 600;
    color: #262626;
    margin: 0;
}

body.dark-theme .instagram-edit-title {
    color: #ffffff;
}

.instagram-edit-close {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #262626;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}

body.dark-theme .instagram-edit-close {
    color: #ffffff;
}

.instagram-edit-close:hover {
    background: #f0f0f0;
}

body.dark-theme .instagram-edit-close:hover {
    background: #1a1a1a;
}

.instagram-edit-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    max-height: calc(90vh - 140px);
}

.instagram-edit-section {
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #efefef;
}

body.dark-theme .instagram-edit-section {
    border-color: #262626;
}

.instagram-edit-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.instagram-edit-section-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: 600;
    color: #262626;
}

body.dark-theme .instagram-edit-section-header {
    color: #ffffff;
}

.instagram-edit-section-header i {
    font-size: 20px;
    color: #8e8e8e;
}

body.dark-theme .instagram-edit-section-header i {
    color: #a8a8a8;
}

.instagram-edit-textarea {
    width: 100%;
    border: 1px solid #dbdbdb;
    border-radius: 8px;
    padding: 14px;
    background: #ffffff;
    color: #262626;
    font-size: 15px;
    font-family: inherit;
    line-height: 1.5;
    resize: vertical;
    outline: none;
    transition: all 0.2s;
    min-height: 120px;
}

body.dark-theme .instagram-edit-textarea {
    background: #262626;
    border-color: #363636;
    color: #ffffff;
}

.instagram-edit-textarea:focus {
    border-color: #0095f6;
    box-shadow: 0 0 0 3px rgba(0, 149, 246, 0.1);
}

body.dark-theme .instagram-edit-textarea:focus {
    border-color: #0095f6;
    box-shadow: 0 0 0 3px rgba(0, 149, 246, 0.2);
}

.instagram-edit-char-count {
    text-align: right;
    font-size: 12px;
    color: #8e8e8e;
    margin-top: 6px;
}

body.dark-theme .instagram-edit-char-count {
    color: #a8a8a8;
}

.instagram-edit-image-container {
    margin-top: 12px;
}

.instagram-edit-image-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #fafafa;
    border: 1px solid #efefef;
    transition: all 0.3s;
}

body.dark-theme .instagram-edit-image-wrapper {
    background: #1a1a1a;
    border-color: #262626;
}

.instagram-edit-image-wrapper:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

body.dark-theme .instagram-edit-image-wrapper:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.instagram-edit-image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    max-height: 400px;
    object-fit: contain;
}

.instagram-edit-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
}

.instagram-edit-image-wrapper:hover .instagram-edit-image-overlay {
    background: rgba(0, 0, 0, 0.5);
    opacity: 1;
}

.instagram-edit-image-btn {
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #ed4956;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.instagram-edit-image-btn:hover {
    background: #ffffff;
    transform: scale(1.05);
}

.instagram-edit-image-btn i {
    font-size: 20px;
}

.instagram-edit-upload-area {
    margin-top: 12px;
}

.instagram-edit-file-input {
    display: none;
}

.instagram-edit-upload-label {
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

body.dark-theme .instagram-edit-upload-label {
    background: #1a1a1a;
    border-color: #363636;
}

.instagram-edit-upload-label:hover {
    border-color: #0095f6;
    background: #f0f8ff;
}

body.dark-theme .instagram-edit-upload-label:hover {
    border-color: #0095f6;
    background: #0a1a2a;
}

.instagram-edit-upload-area.drag-over .instagram-edit-upload-label {
    border-color: #0095f6;
    background: #e3f2fd;
    transform: scale(1.02);
}

body.dark-theme .instagram-edit-upload-area.drag-over .instagram-edit-upload-label {
    background: #0a1a2a;
}

.instagram-edit-upload-icon {
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

body.dark-theme .instagram-edit-upload-icon {
    background: #1a3a5a;
}

.instagram-edit-upload-label:hover .instagram-edit-upload-icon {
    background: #0095f6;
    transform: scale(1.1);
}

.instagram-edit-upload-label:hover .instagram-edit-upload-icon i {
    color: #ffffff;
}

.instagram-edit-upload-icon i {
    font-size: 32px;
    color: #0095f6;
    transition: all 0.3s;
}

.instagram-edit-upload-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.instagram-edit-upload-title {
    font-size: 16px;
    font-weight: 600;
    color: #262626;
}

body.dark-theme .instagram-edit-upload-title {
    color: #ffffff;
}

.instagram-edit-upload-subtitle {
    font-size: 13px;
    color: #8e8e8e;
}

body.dark-theme .instagram-edit-upload-subtitle {
    color: #a8a8a8;
}

.instagram-edit-new-image-preview {
    margin-top: 16px;
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

.instagram-edit-new-image-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #fafafa;
    border: 2px solid #0095f6;
}

body.dark-theme .instagram-edit-new-image-wrapper {
    background: #1a1a1a;
    border-color: #0095f6;
}

.instagram-edit-new-image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    max-height: 400px;
    object-fit: contain;
}

.instagram-edit-remove-new-image {
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

.instagram-edit-remove-new-image:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.instagram-edit-image-info {
    text-align: center;
    margin-top: 8px;
    font-size: 12px;
    color: #8e8e8e;
    font-style: italic;
}

body.dark-theme .instagram-edit-image-info {
    color: #a8a8a8;
}

.instagram-edit-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-top: 1px solid #efefef;
    background: #fafafa;
}

body.dark-theme .instagram-edit-footer {
    border-color: #262626;
    background: #1a1a1a;
}

.instagram-edit-cancel-btn {
    background: none;
    border: 1px solid #dbdbdb;
    border-radius: 8px;
    padding: 10px 20px;
    color: #262626;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

body.dark-theme .instagram-edit-cancel-btn {
    border-color: #363636;
    color: #ffffff;
}

.instagram-edit-cancel-btn:hover {
    background: #f0f0f0;
    border-color: #a8a8a8;
}

body.dark-theme .instagram-edit-cancel-btn:hover {
    background: #2a2a2a;
    border-color: #555555;
}

.instagram-edit-save-btn {
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

.instagram-edit-save-btn:hover {
    background: #0084d4;
    box-shadow: 0 4px 12px rgba(0, 149, 246, 0.4);
    transform: translateY(-1px);
}

.instagram-edit-save-btn:active {
    transform: translateY(0);
}

.instagram-edit-save-btn:disabled {
    background: #b2dffc;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

.instagram-edit-save-btn i {
    font-size: 18px;
}

/* Delete Post Modal Styles */
.instagram-delete-post-body {
    padding: 20px;
    text-align: center;
}

.instagram-delete-post-body p {
    font-size: 14px;
    color: #262626;
    margin-bottom: 24px;
    line-height: 1.5;
}

body.dark-theme .instagram-delete-post-body p {
    color: #ffffff;
}

.instagram-delete-post-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.instagram-delete-post-cancel {
    background: none;
    border: 1px solid #dbdbdb;
    border-radius: 6px;
    padding: 10px 20px;
    color: #262626;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

body.dark-theme .instagram-delete-post-cancel {
    border-color: #363636;
    color: #ffffff;
}

.instagram-delete-post-cancel:hover {
    background: #fafafa;
}

body.dark-theme .instagram-delete-post-cancel:hover {
    background: #1a1a1a;
}

.instagram-delete-post-confirm {
    background: #ed4956;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.instagram-delete-post-confirm:hover {
    background: #d73645;
}

.instagram-delete-post-confirm:disabled {
    background: #f5a5ad;
    cursor: not-allowed;
}
</style>

<div class="instagram-container">
    <div class="container-fluid px-0">

@if (session('msg'))
<div class="card bg-success" id="customMessageBox">
    {{session('msg')}}
</div>
@endif


@php
    date_default_timezone_set("Asia/Yangon");
    function countFormat($count ,$unit){
      if($count==0){
            return "0";
        }else if($count==1){
            return "1";
        }else if($count>=1000&&$count<1000000){
            $count=number_format($count/1000,1);
            return $count."k";
        }else if($count>=1000000){
            $count=number_format($count/1000000,1);
            return $count."M";
        }else{
            return number_format($count);
        }
    }
    
    function timeAgo($timestamp) {
        $diff = time() - ($timestamp / 1000);
        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff/60) . 'm';
        if ($diff < 86400) return floor($diff/3600) . 'h';
        if ($diff < 604800) return floor($diff/86400) . 'd';
        if ($diff < 2592000) return floor($diff/604800) . 'w';
        if ($diff < 31536000) return floor($diff/2592000) . 'mo';
        return floor($diff/31536000) . 'y';
    }
@endphp

        {{-- Create Post Box - Instagram Style --}}
        <div class="instagram-create-post">
            <div class="instagram-create-post-header">
                @if ($major=='english')
                    <img class="instagram-create-avatar" src="{{asset('public/img/easyenglish.png')}}" alt="Easy English">
                @elseif($major=='korea')
                    <img class="instagram-create-avatar" src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean">
                @elseif($major=='chinese')
                    <img class="instagram-create-avatar" src="{{asset('public/img/easychineselogo.webp')}}" alt="Easy Chinese">
                @elseif($major=='japanese')
                    <img class="instagram-create-avatar" src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese">
                @elseif($major=='russian')
                    <img class="instagram-create-avatar" src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian">
                @endif
                <a href="{{route('showCreatePost',$major)}}" style="flex: 1; text-decoration: none;">
                    <input type="text" class="instagram-create-input" placeholder="What's on your mind?" readonly>
                </a>
            </div>
        </div>

        {{-- Posts Container --}}
        <div id="postContainer">
            @if($posts)
            @foreach ($posts as $post)
                <div class="instagram-post">
                    {{-- Post Header --}}
                    <div class="instagram-post-header">
                        <img class="instagram-post-avatar" src="{{$post->userImage}}" alt="{{$post->userName}}" onerror="this.src='{{asset('public/img/default-avatar.png')}}'">
                        <a href="#" class="instagram-post-username">{{$post->userName}}</a>
                        <div class="dropdown" style="margin-left: auto;">
                            <button class="instagram-post-more" type="button" id="dropdownMenuButton{{$post->postId}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="clickMore({{$post->postId}});">
                                <i class="material-icons" style="font-size: 20px;">more_horiz</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton{{$post->postId}}">
                                <a class="dropdown-item" href="#" onclick="editPost({{$post->postId}}, '{{addslashes($post->body)}}', '{{$post->postImage}}'); return false;">
                                    <i class="material-icons me-3" style="font-size: 18px; vertical-align: middle;">edit</i>Edit Post
                                </a>
                                <a class="dropdown-item" href="#" onclick="confirmDeletePost({{$post->postId}}); return false;" style="color: #ed4956;">
                                    <i class="material-icons me-3" style="font-size: 18px; color: #ed4956; vertical-align: middle;">delete</i>Delete Post
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Post Media --}}
                    @if($post->postImage!="" && $post->has_video=="0")
                        <img class="instagram-post-media" src="{{$post->postImage}}" alt="Post image" onerror="this.style.display='none'">
                    @elseif($post->has_video=="1")
                        <div class="instagram-post-video">
                            <iframe src="{{$post->vimeo}}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif

                    {{-- Post Actions --}}
                    <div class="instagram-post-actions" style="padding-left: 16px;">
                        <button type="button" class="instagram-action-btn {{$post->is_liked == 1 ? 'liked' : ''}}" id="react{{$post->postId}}" onclick="likePost({{$post->postId}},{{$post->is_liked}});">
                            <i class="material-icons" id="noneReactIcon{{$post->postId}}">{{$post->is_liked == 1 ? 'favorite' : 'favorite_border'}}</i>
                        </button>
                        <button type="button" class="instagram-action-btn" data-toggle="modal" data-target="#commentDialog" onclick="fetchComment({{$post->postId}},'{{$major}}');">
                            <i class="material-icons">chat_bubble_outline</i>
                        </button>
                        <button type="button" class="instagram-action-btn">
                            <i class="material-icons">send</i>
                        </button>
                    </div>

                    {{-- Post Engagement --}}
                    <div class="instagram-post-engagement">
                        @if($post->postLikes > 0)
                        <div class="instagram-likes-count" id="tvLikes{{$post->postId}}">{{number_format($post->postLikes)}} likes</div>
                        @else
                        <div class="instagram-likes-count" id="tvLikes{{$post->postId}}" style="display: none;"></div>
                        @endif

                        @if($post->body)
                        <div class="instagram-post-caption">
                            <a href="#" class="instagram-caption-username">{{$post->userName}}</a> {{$post->body}}
                        </div>
                        @endif

                        @if($post->comments > 0)
                        <div class="instagram-view-comments" data-toggle="modal" data-target="#commentDialog" onclick="fetchComment({{$post->postId}},'{{$major}}');">
                            View all {{number_format($post->comments)}} comments
                        </div>
                        @endif

                        <div class="instagram-post-time">{{timeAgo($post->postId)}}</div>
                    </div>

                    {{-- Comment Input --}}
                    <div class="instagram-comment-box" data-toggle="modal" data-target="#commentDialog" onclick="fetchComment({{$post->postId}},'{{$major}}');">
                        @if ($major=='english')
                            <img class="instagram-comment-avatar" src="{{asset('public/img/easyenglish.png')}}" alt="Easy English">
                        @elseif ($major=='korea')
                            <img class="instagram-comment-avatar" src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean">
                        @elseif ($major=='chinese')
                            <img class="instagram-comment-avatar" src="{{asset('public/img/easychineselogo.webp')}}" alt="Easy Chinese">
                        @elseif ($major=='japanese')
                            <img class="instagram-comment-avatar" src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese">
                        @elseif ($major=='russian')
                            <img class="instagram-comment-avatar" src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian">
                        @endif
                        <input type="text" class="instagram-comment-input" placeholder="Add a comment..." readonly>
                        <button type="button" class="instagram-comment-post">Post</button>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</div>


{{-- Post Edit Dialog --}}

<div class="modal fade" id="postEditDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">More Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div id="postEditContainer" style="display:flex">
                    <div class="ripple" style="flex:1; text-align:center">Edit Post</div>
                    <div class="ripple" style="flex:1; text-align:center">Delete Post</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Post Dialog - Enhanced Instagram Style --}}
<div class="modal fade" id="editPostDialog" tabindex="-1" aria-labelledby="editPostDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered instagram-edit-modal">
        <div class="modal-content instagram-edit-modal-content">
            <div class="instagram-edit-header">
                <div class="instagram-edit-header-left">
                    <button type="button" class="instagram-edit-back" onclick="closeEditPostDialog();" aria-label="Close">
                        <i class="material-icons">arrow_back</i>
                    </button>
                    <h5 class="instagram-edit-title">Edit Post</h5>
                </div>
                <button type="button" class="instagram-edit-close" onclick="closeEditPostDialog();" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            
            <div class="instagram-edit-body">
                <form id="editPostForm">
                    <input type="hidden" id="editPostId" value="">
                    
                    {{-- Post Content Section --}}
                    <div class="instagram-edit-section">
                        <div class="instagram-edit-section-header">
                            <i class="material-icons">text_fields</i>
                            <span>Post Content</span>
                        </div>
                        <textarea id="editPostBody" class="instagram-edit-textarea" placeholder="What's on your mind?" rows="6"></textarea>
                        <div class="instagram-edit-char-count">
                            <span id="editPostCharCount">0</span> characters
                        </div>
                    </div>
                    
                    {{-- Current Image Section --}}
                    <div class="instagram-edit-section" id="editPostImageSection" style="display: none;">
                        <div class="instagram-edit-section-header">
                            <i class="material-icons">image</i>
                            <span>Current Image</span>
                        </div>
                        <div class="instagram-edit-image-container">
                            <div class="instagram-edit-image-wrapper" id="editPostImagePreview">
                                <img id="editPostCurrentImage" src="" alt="Current post image">
                                <div class="instagram-edit-image-overlay">
                                    <button type="button" class="instagram-edit-image-btn" onclick="removeEditPostImage();" title="Remove image">
                                        <i class="material-icons">delete_outline</i>
                                        <span>Remove</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Upload New Image Section --}}
                    <div class="instagram-edit-section">
                        <div class="instagram-edit-section-header">
                            <i class="material-icons">add_photo_alternate</i>
                            <span id="editImageSectionTitle">Add Image</span>
                        </div>
                        <div class="instagram-edit-upload-area" id="editPostUploadArea">
                            <input type="file" id="editPostImageFile" class="instagram-edit-file-input" accept="image/*">
                            <label for="editPostImageFile" class="instagram-edit-upload-label">
                                <div class="instagram-edit-upload-icon">
                                    <i class="material-icons">cloud_upload</i>
                                </div>
                                <div class="instagram-edit-upload-text">
                                    <span class="instagram-edit-upload-title">Click to upload or drag and drop</span>
                                    <span class="instagram-edit-upload-subtitle">PNG, JPG, GIF up to 10MB</span>
                                </div>
                            </label>
                        </div>
                        <div class="instagram-edit-new-image-preview" id="editPostNewImagePreview" style="display: none;">
                            <div class="instagram-edit-new-image-wrapper">
                                <img id="editPostNewImage" src="" alt="New image preview">
                                <button type="button" class="instagram-edit-remove-new-image" onclick="removeNewEditImage();">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <div class="instagram-edit-image-info">
                                <span>New image will replace current image</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="instagram-edit-footer">
                <button type="button" class="instagram-edit-cancel-btn" onclick="closeEditPostDialog();">
                    <i class="material-icons">close</i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="instagram-edit-save-btn" id="editPostSaveBtn" onclick="$('#editPostForm').submit();">
                    <i class="material-icons">check</i>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Post Confirmation Dialog --}}
<div class="modal fade" id="deletePostDialog" tabindex="-1" aria-labelledby="deletePostDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content instagram-comment-modal-content" style="max-width: 400px;">
            <div class="instagram-comment-header">
                <h5 class="instagram-comment-title">Delete Post</h5>
                <button type="button" class="instagram-comment-close" onclick="closeDeletePostDialog();" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            
            <div class="instagram-delete-post-body">
                <p>Are you sure you want to delete this post? This action cannot be undone.</p>
                <div class="instagram-delete-post-actions">
                    <button type="button" class="instagram-delete-post-cancel" onclick="closeDeletePostDialog();">Cancel</button>
                    <button type="button" class="instagram-delete-post-confirm" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Comment Dialog - Instagram Style --}}
<div class="modal fade" id="commentDialog" tabindex="-1" aria-labelledby="commentDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg instagram-comment-modal">
        <div class="modal-content instagram-comment-modal-content">
            <div class="instagram-comment-header">
                <h5 class="instagram-comment-title">Comments</h5>
                <button type="button" class="instagram-comment-close" onclick="closeCommentDialog();" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            
            <div class="instagram-comment-body" id="commentContainer">
                <div class="instagram-comment-loading">
                    <div class="instagram-comment-spinner"></div>
                    <p>Loading comments...</p>
                </div>
            </div>
            
            <div class="instagram-comment-footer" id="commentFooter" style="display: none;">
                <div class="instagram-comment-input-wrapper">
                    @if ($major=='english')
                        <img class="instagram-comment-footer-avatar" src="{{asset('public/img/easyenglish.png')}}" alt="Easy English">
                    @elseif ($major=='korea')
                        <img class="instagram-comment-footer-avatar" src="{{asset('public/img/easykorean.png')}}" alt="Easy Korean">
                    @elseif ($major=='chinese')
                        <img class="instagram-comment-footer-avatar" src="{{asset('public/img/easychineselogo.webp')}}" alt="Easy Chinese">
                    @elseif ($major=='japanese')
                        <img class="instagram-comment-footer-avatar" src="{{asset('public/img/easyjapanese.png')}}" alt="Easy Japanese">
                    @elseif ($major=='russian')
                        <img class="instagram-comment-footer-avatar" src="{{asset('public/img/easyrussian.png')}}" alt="Easy Russian">
                    @endif
                    <input type="text" id="commentInput" class="instagram-comment-input-field" placeholder="Add a comment..." autocomplete="off">
                    <button type="button" class="instagram-comment-post-btn" id="commentPostBtn" onclick="addCommentFromModal();" disabled>Post</button>
                </div>
            </div>
        </div>
    </div>
</div>




<script>

    var clickPostId=0;
    var currentPage="{{$page}}";

    function clickMore(post_id){
        clickPostId=post_id
        
    }

    var loading=true;

    $(window).on("scroll", function() {
        var scrollHeight = $(document).height();
        var scrollPos =$(window).scrollTop();
        var halfWindowPos=$(window).height()/5;
        halfWindowPos=halfWindowPos-(currentPage*1.5);
      
      
        if(scrollPos+halfWindowPos+1000 >scrollHeight && loading){
             currentPage++;
             var url="{{route('fetchMorePost',$major)}}?mCode={{$mCode}}&page="+currentPage;
             console.log(scrollHeight+ " "+scrollPos);
             console.log(url);
             loading=false;
             loadMorePost(url)

            // document.getElementById('nextPage').click();
        }

    }); 


    function loadMorePost(url){


        var ajax=new XMLHttpRequest();
        ajax.onload =function(){
        if(ajax.status==200 || ajax.readyState==4){

            setPostOnScreen(JSON.parse(ajax.responseText))

        }
        }
        ajax.open("GET",url,true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send('');
  
  }


   function setPostOnScreen(posts){
        for(var i=0;i<posts.length;i++){
            var timeAgo = getTimeAgo(posts[i].postId);
            var likeIcon = posts[i].is_liked == 1 ? 'favorite' : 'favorite_border';
            var likedClass = posts[i].is_liked == 1 ? 'liked' : '';
            var likesText = posts[i].postLikes > 0 ? numberFormat(posts[i].postLikes) + ' likes' : '';
            var commentsText = posts[i].comments > 0 ? 'View all ' + numberFormat(posts[i].comments) + ' comments' : '';
            var caption = posts[i].body ? "<div class='instagram-post-caption'><a href='#' class='instagram-caption-username'>"+posts[i].userName+"</a> "+posts[i].body+"</div>" : '';
            
            var defaultAvatar = "{{asset('public/img/default-avatar.png')}}";
            var postHtml = 
                "<div class='instagram-post' id='instagram-post-"+posts[i].postId+"'>" +
                    "<div class='instagram-post-header'>" +
                        "<img class='instagram-post-avatar' src='"+posts[i].userImage+"' alt='"+posts[i].userName+"' onerror=\"this.src='"+defaultAvatar+"'\">" +
                        "<a href='#' class='instagram-post-username'>"+posts[i].userName+"</a>" +
                        "<div class='dropdown' style='margin-left: auto;'>" +
                            "<button class='instagram-post-more' type='button' id='dropdownMenuButton"+posts[i].postId+"' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' onclick='clickMore("+posts[i].postId+");'>" +
                                "<i class='material-icons' style='font-size: 20px;'>more_horiz</i>" +
                            "</button>" +
                            "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton"+posts[i].postId+"'>" +
                                "<a class='dropdown-item' href='#' onclick=\"editPost("+posts[i].postId+", '"+String(posts[i].body || '').replace(/'/g, "\\'").replace(/\n/g, ' ')+"', '"+posts[i].postImage+"'); return false;\"><i class='material-icons me-3' style='font-size: 18px; vertical-align: middle;'>edit</i>Edit Post</a>" +
                                "<a class='dropdown-item' href='#' onclick=\"confirmDeletePost("+posts[i].postId+"); return false;\" style='color: #ed4956;'><i class='material-icons me-3' style='font-size: 18px; color: #ed4956; vertical-align: middle;'>delete</i>Delete Post</a>" +
                            "</div>" +
                        "</div>" +
                    "</div>" +
                    checkPostMedia(posts[i].postImage, posts[i].has_video, posts[i].vimeo) +
                    "<div class='instagram-post-actions' style='padding-left: 16px;'>" +
                        "<button type='button' class='instagram-action-btn "+likedClass+"' id='react"+posts[i].postId+"' onclick='likePost("+posts[i].postId+","+posts[i].is_liked+");'>" +
                            "<i class='material-icons' id='noneReactIcon"+posts[i].postId+"'>"+likeIcon+"</i>" +
                        "</button>" +
                        "<button type='button' class='instagram-action-btn' data-toggle='modal' data-target='#commentDialog' onclick='fetchComment("+posts[i].postId+",\"{{$major}}\");'>" +
                            "<i class='material-icons'>chat_bubble_outline</i>" +
                        "</button>" +
                        "<button type='button' class='instagram-action-btn'>" +
                            "<i class='material-icons'>send</i>" +
                        "</button>" +
                    "</div>" +
                    "<div class='instagram-post-engagement'>" +
                        (posts[i].postLikes > 0 ? "<div class='instagram-likes-count' id='tvLikes"+posts[i].postId+"'>"+likesText+"</div>" : "<div class='instagram-likes-count' id='tvLikes"+posts[i].postId+"' style='display: none;'></div>") +
                        caption +
                        (commentsText ? "<div class='instagram-view-comments' data-toggle='modal' data-target='#commentDialog' onclick='fetchComment("+posts[i].postId+",\"{{$major}}\");'>"+commentsText+"</div>" : "") +
                        "<div class='instagram-post-time'>"+timeAgo+"</div>" +
                    "</div>" +
                    "<div class='instagram-comment-box' data-toggle='modal' data-target='#commentDialog' onclick='fetchComment("+posts[i].postId+",\"{{$major}}\");'>" +
                        checkMajorAvatar() +
                        "<input type='text' class='instagram-comment-input' placeholder='Add a comment...' readonly>" +
                        "<button type='button' class='instagram-comment-post'>Post</button>" +
                    "</div>" +
                "</div>";
            
            $('#postContainer').append(postHtml);
        }
        loading=true;
   }
   
   function getTimeAgo(timestamp) {
       var diff = Math.floor((Date.now() - timestamp) / 1000);
       if (diff < 60) return 'Just now';
       if (diff < 3600) return Math.floor(diff/60) + 'm';
       if (diff < 86400) return Math.floor(diff/3600) + 'h';
       if (diff < 604800) return Math.floor(diff/86400) + 'd';
       if (diff < 2592000) return Math.floor(diff/604800) + 'w';
       if (diff < 31536000) return Math.floor(diff/2592000) + 'mo';
       return Math.floor(diff/31536000) + 'y';
   }
   
   function numberFormat(num) {
       if (num >= 1000000) {
           return (num / 1000000).toFixed(1) + 'M';
       } else if (num >= 1000) {
           return (num / 1000).toFixed(1) + 'k';
       }
       return num.toString();
   }
   
   function checkMajorAvatar(){
       var major = "{{$major}}";
       if(major == 'english'){
           return "<img class='instagram-comment-avatar' src='{{asset('public/img/easyenglish.png')}}' alt='Easy English'>";
       } else if(major == 'korea'){
           return "<img class='instagram-comment-avatar' src='{{asset('public/img/easykorean.png')}}' alt='Easy Korean'>";
       } else if(major == 'chinese'){
           return "<img class='instagram-comment-avatar' src='{{asset('public/img/easychineselogo.webp')}}' alt='Easy Chinese'>";
       } else if(major == 'japanese'){
           return "<img class='instagram-comment-avatar' src='{{asset('public/img/easyjapanese.png')}}' alt='Easy Japanese'>";
       } else if(major == 'russian'){
           return "<img class='instagram-comment-avatar' src='{{asset('public/img/easyrussian.png')}}' alt='Easy Russian'>";
       }
       return "";
   }
   
   function checkMajorAvatarForReply(){
       var major = "{{$major}}";
       if(major == 'english'){
           return "<img class='instagram-comment-reply-avatar' src='{{asset('public/img/easyenglish.png')}}' alt='Easy English'>";
       } else if(major == 'korea'){
           return "<img class='instagram-comment-reply-avatar' src='{{asset('public/img/easykorean.png')}}' alt='Easy Korean'>";
       } else if(major == 'chinese'){
           return "<img class='instagram-comment-reply-avatar' src='{{asset('public/img/easychineselogo.webp')}}' alt='Easy Chinese'>";
       } else if(major == 'japanese'){
           return "<img class='instagram-comment-reply-avatar' src='{{asset('public/img/easyjapanese.png')}}' alt='Easy Japanese'>";
       } else if(major == 'russian'){
           return "<img class='instagram-comment-reply-avatar' src='{{asset('public/img/easyrussian.png')}}' alt='Easy Russian'>";
       }
       return "";
   }
   
   function showReplyForm(commentId){
       $('#replyForm'+commentId).addClass('active');
       $('#replyInput'+commentId).focus();
   }
   
   function hideReplyForm(commentId){
       $('#replyForm'+commentId).removeClass('active');
       $('#replyInput'+commentId).val('');
       $('#replySubmit'+commentId).prop('disabled', true);
   }
   
   function addReply(parentCommentId){
       var replyText = $('#replyInput'+parentCommentId).val().trim();
       
       if(replyText.length < 1){
           return;
       }
       
       var replyBtn = $('#replySubmit'+parentCommentId);
       replyBtn.prop('disabled', true);
       replyBtn.text('Posting...');
       
       var ajax = new XMLHttpRequest();
       ajax.onload = function(){
           if(ajax.status == 200 || ajax.readyState == 4){
               try {
                   var response = JSON.parse(ajax.responseText);
                   if(response.success) {
                       hideReplyForm(parentCommentId);
                       fetchComment(currentPostId, currentMajor);
                   } else {
                       alert('Failed to add reply: ' + (response.message || 'Unknown error'));
                       replyBtn.prop('disabled', false);
                       replyBtn.text('Post');
                   }
               } catch(e) {
                   console.error('Error parsing add reply response:', e);
                   alert('Error adding reply');
                   replyBtn.prop('disabled', false);
                   replyBtn.text('Post');
               }
           } else {
               console.error('Failed to add reply. Status:', ajax.status);
               alert('Failed to add reply');
               replyBtn.prop('disabled', false);
               replyBtn.text('Post');
           }
       }
       ajax.onerror = function(){
           console.error('Network error adding reply');
           alert('Network error. Please try again.');
           replyBtn.prop('disabled', false);
           replyBtn.text('Post');
       }
       ajax.open("POST", "{{url('/api/comments')}}", true);
       ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       ajax.send("writer_id=10000&post_id="+currentPostId+"&body="+encodeURIComponent(replyText)+"&owner_id="+currentOwnerId+"&action="+parentCommentId);
   }
   
   // Store reply counts for each comment
   var replyCounts = {};
   
   function toggleReplies(commentId){
       var hiddenReplies = document.getElementById('hiddenReplies'+commentId);
       var viewReplies = document.getElementById('viewReplies'+commentId);
       
       if(!hiddenReplies || !viewReplies) return;
       
       if(hiddenReplies.style.display !== 'none' && hiddenReplies.offsetHeight > 0){
           // Hide replies
           hiddenReplies.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
           hiddenReplies.style.maxHeight = hiddenReplies.scrollHeight + 'px';
           setTimeout(function(){
               hiddenReplies.style.maxHeight = '0';
               hiddenReplies.style.opacity = '0';
               setTimeout(function(){
                   hiddenReplies.style.display = 'none';
               }, 300);
           }, 10);
           var count = replyCounts[commentId] || hiddenReplies.querySelectorAll('.instagram-comment-reply-item').length;
           viewReplies.textContent = 'View replies ('+count+')';
       } else {
           // Show replies
           hiddenReplies.style.display = 'block';
           hiddenReplies.style.maxHeight = '0';
           hiddenReplies.style.opacity = '0';
           hiddenReplies.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
           setTimeout(function(){
               hiddenReplies.style.maxHeight = hiddenReplies.scrollHeight + 'px';
               hiddenReplies.style.opacity = '1';
           }, 10);
           viewReplies.textContent = 'Hide replies';
       }
   }


    function countFormat(count ,unit){
        if(count==0){
            return "0";
        }else if(count==1){
            return "1";
        }else if(count>=1000&&count<1000000){
            count=count/1000;
            count=count.toFixed(1);
            return count+"k";
        }else if(count>=1000000){
            count=count/1000000;
            count=count.toFixed(1);
            return count+"M";
        }else{
            return count.toString();
        }
    }
  
   


   function checkPostMedia(postImage,has_video,vimeo){
        var str="";
        if(postImage!="" && has_video=="0"){
            str="<img class='instagram-post-media' src='"+postImage+"' alt='Post image' onerror=\"this.style.display='none'\">";
        }else if(has_video=="1"){
            str="<div class='instagram-post-video'>"+
                "<iframe src='"+vimeo+"' frameborder='0' allow='autoplay; fullscreen; picture-in-picture' allowfullscreen></iframe>"+
                "</div>";
        }
        return str;
   }


    var currentPostId = 0;
    var currentOwnerId = 0;
    var currentMajor = "{{$major}}";
    var defaultAvatar = "{{asset('public/img/default-avatar.png')}}";

    function fetchComment(postId, major){
        currentPostId = postId;
        currentMajor = major;
        
        if(major == "korea"){
            major = "korean";
        }
        
        $('#commentContainer').html('<div class="instagram-comment-loading"><div class="instagram-comment-spinner"></div><p>Loading comments...</p></div>');
        $('#commentFooter').hide();
        
        var ajax = new XMLHttpRequest();
        ajax.onload = function(){
            if(ajax.status == 200 || ajax.readyState == 4){
                try {
                    var response = JSON.parse(ajax.responseText);
                    if(!response.success) {
                        $('#commentContainer').html('<div class="instagram-comment-empty"><i class="material-icons">error_outline</i><p>Failed to load comments</p></div>');
                        return;
                    }
                    
                    var comments = response.comments || [];
                    var postData = response.post && response.post.length > 0 ? response.post[0] : null;
                    currentPostId = postData ? postData.postId : postId;
                    currentOwnerId = postData ? postData.userId : 0;
                    
                    $('#commentContainer').empty();
                    
                    if(comments.length === 0) {
                        $('#commentContainer').html(
                            '<div class="instagram-comment-empty">' +
                                '<i class="material-icons">chat_bubble_outline</i>' +
                                '<p>No comments yet.<br>Be the first to comment!</p>' +
                            '</div>'
                        );
                    } else {
                        for(var i = 0; i < comments.length; i++){
                            const milliseconds = comments[i].time;
                            const timeAgo = getTimeAgo(milliseconds);
                            var isLiked = comments[i].is_liked == "1" || comments[i].is_liked == 1;
                            var likeClass = isLiked ? 'liked' : '';
                            var likeIcon = isLiked ? 'favorite' : 'favorite_border';
                            var likesText = comments[i].likes > 0 ? comments[i].likes : '';
                            
                            var userImg = comments[i].userImage || defaultAvatar;
                            var commentHtml = 
                                "<div class=\"instagram-comment-item\">" +
                                    "<img class=\"instagram-comment-avatar\" src=\""+userImg+"\" alt=\""+comments[i].userName+"\" data-default=\""+defaultAvatar+"\" onerror=\"this.src=this.getAttribute('data-default')\">" +
                                    "<div class=\"instagram-comment-content\">" +
                                        "<div>" +
                                            "<a href=\"#\" class=\"instagram-comment-author\">"+comments[i].userName+"</a>" +
                                            "<span class=\"instagram-comment-text\">"+comments[i].body+"</span>" +
                                        "</div>";
                            
                            if(comments[i].commentImage && comments[i].commentImage != ""){
                                commentHtml += "<img class=\"instagram-comment-image\" src=\""+comments[i].commentImage+"\" alt=\"Comment image\">";
                            }
                            
                            var replyCountText = "";
                            if(comments[i].replies && comments[i].replies.length > 0) {
                                replyCountText = "<span class=\"instagram-comment-reply-count\">"+comments[i].replies.length+" "+(comments[i].replies.length == 1 ? "reply" : "replies")+"</span>";
                            }
                            
                            commentHtml += 
                                        "<div class=\"instagram-comment-actions\">" +
                                            "<button type=\"button\" class=\"instagram-comment-like-btn "+likeClass+"\" id=\"react"+milliseconds+"\" onclick=\"likeComment("+currentPostId+","+milliseconds+");\">" +
                                                "<i class=\"material-icons\">"+likeIcon+"</i>" +
                                                (likesText ? "<span id=\"likes"+milliseconds+"\">"+likesText+"</span>" : "<span id=\"likes"+milliseconds+"\" style=\"display:none;\"></span>") +
                                            "</button>" +
                                            "<button type=\"button\" class=\"instagram-comment-reply-btn\" onclick=\"showReplyForm("+milliseconds+");\">Reply</button>" +
                                            "<button type=\"button\" class=\"instagram-comment-delete-btn\" onclick=\"deleteComment("+milliseconds+");\" title=\"Delete comment\">" +
                                                "<i class=\"material-icons\">delete_outline</i>" +
                                            "</button>" +
                                            "<span class=\"instagram-comment-time\">"+timeAgo+"</span>" +
                                        "</div>" +
                                        replyCountText +
                                    "</div>" +
                                "</div>";
                            
                            // Add replies if they exist
                            if(comments[i].replies && comments[i].replies.length > 0) {
                                commentHtml += "<div class=\"instagram-comment-replies\" id=\"replies"+milliseconds+"\">";
                                
                                // Show first 2 replies by default, rest hidden
                                var repliesToShow = comments[i].replies.slice(0, 2);
                                
                                for(var j = 0; j < repliesToShow.length; j++) {
                                    var reply = comments[i].replies[j];
                                    var replyTimeAgo = getTimeAgo(reply.time);
                                    var replyIsLiked = reply.is_liked == "1" || reply.is_liked == 1;
                                    var replyLikeClass = replyIsLiked ? 'liked' : '';
                                    var replyLikeIcon = replyIsLiked ? 'favorite' : 'favorite_border';
                                    var replyLikesText = reply.likes > 0 ? reply.likes : '';
                                    var replyUserImg = reply.userImage || defaultAvatar;
                                    
                                    commentHtml += 
                                        "<div class=\"instagram-comment-reply-item\">" +
                                            "<img class=\"instagram-comment-reply-avatar\" src=\""+replyUserImg+"\" alt=\""+reply.userName+"\" data-default=\""+defaultAvatar+"\" onerror=\"this.src=this.getAttribute('data-default')\">" +
                                            "<div class=\"instagram-comment-reply-content\">" +
                                                "<div>" +
                                                    "<a href=\"#\" class=\"instagram-comment-author\">"+reply.userName+"</a>" +
                                                    "<span class=\"instagram-comment-reply-text\">"+reply.body+"</span>" +
                                                "</div>" +
                                                "<div class=\"instagram-comment-reply-actions\">" +
                                                    "<button type=\"button\" class=\"instagram-comment-like-btn "+replyLikeClass+"\" id=\"react"+reply.time+"\" onclick=\"likeComment("+currentPostId+","+reply.time+");\">" +
                                                        "<i class=\"material-icons\">"+replyLikeIcon+"</i>" +
                                                        (replyLikesText ? "<span id=\"likes"+reply.time+"\">"+replyLikesText+"</span>" : "<span id=\"likes"+reply.time+"\" style=\"display:none;\"></span>") +
                                                    "</button>" +
                                                    "<button type=\"button\" class=\"instagram-comment-delete-btn\" onclick=\"deleteComment("+reply.time+");\" title=\"Delete reply\">" +
                                                        "<i class=\"material-icons\">delete_outline</i>" +
                                                    "</button>" +
                                                    "<span class=\"instagram-comment-time\">"+replyTimeAgo+"</span>" +
                                                "</div>" +
                                            "</div>" +
                                        "</div>";
                                }
                                
                                // Show "View replies" if there are more than 2
                                if(comments[i].replies.length > 2) {
                                    var hiddenCount = comments[i].replies.length - 2;
                                    replyCounts[milliseconds] = hiddenCount;
                                    commentHtml += "<div class=\"instagram-view-replies\" id=\"viewReplies"+milliseconds+"\" onclick=\"toggleReplies("+milliseconds+");\">View replies ("+hiddenCount+")</div>";
                                    commentHtml += "<div id=\"hiddenReplies"+milliseconds+"\" style=\"display:none;\">";
                                    for(var j = 2; j < comments[i].replies.length; j++) {
                                        var reply = comments[i].replies[j];
                                        var replyTimeAgo = getTimeAgo(reply.time);
                                        var replyIsLiked = reply.is_liked == "1" || reply.is_liked == 1;
                                        var replyLikeClass = replyIsLiked ? 'liked' : '';
                                        var replyLikeIcon = replyIsLiked ? 'favorite' : 'favorite_border';
                                        var replyLikesText = reply.likes > 0 ? reply.likes : '';
                                        var replyUserImg = reply.userImage || defaultAvatar;
                                        
                                        commentHtml += 
                                            "<div class=\"instagram-comment-reply-item\">" +
                                                "<img class=\"instagram-comment-reply-avatar\" src=\""+replyUserImg+"\" alt=\""+reply.userName+"\" data-default=\""+defaultAvatar+"\" onerror=\"this.src=this.getAttribute('data-default')\">" +
                                                "<div class=\"instagram-comment-reply-content\">" +
                                                    "<div>" +
                                                        "<a href=\"#\" class=\"instagram-comment-author\">"+reply.userName+"</a>" +
                                                        "<span class=\"instagram-comment-reply-text\">"+reply.body+"</span>" +
                                                    "</div>" +
                                                    "<div class=\"instagram-comment-reply-actions\">" +
                                                        "<button type=\"button\" class=\"instagram-comment-like-btn "+replyLikeClass+"\" id=\"react"+reply.time+"\" onclick=\"likeComment("+currentPostId+","+reply.time+");\">" +
                                                            "<i class=\"material-icons\">"+replyLikeIcon+"</i>" +
                                                            (replyLikesText ? "<span id=\"likes"+reply.time+"\">"+replyLikesText+"</span>" : "<span id=\"likes"+reply.time+"\" style=\"display:none;\"></span>") +
                                                        "</button>" +
                                                        "<button type=\"button\" class=\"instagram-comment-delete-btn\" onclick=\"deleteComment("+reply.time+");\" title=\"Delete reply\">" +
                                                            "<i class=\"material-icons\">delete_outline</i>" +
                                                        "</button>" +
                                                        "<span class=\"instagram-comment-time\">"+replyTimeAgo+"</span>" +
                                                    "</div>" +
                                                "</div>" +
                                            "</div>";
                                    }
                                    commentHtml += "</div>";
                                }
                                
                                commentHtml += "</div>";
                            }
                            
                            // Add reply form
                            commentHtml += 
                                "<div class=\"instagram-comment-reply-form\" id=\"replyForm"+milliseconds+"\">" +
                                    "<div class=\"instagram-comment-reply-input-wrapper\">" +
                                        checkMajorAvatarForReply() +
                                        "<input type=\"text\" class=\"instagram-comment-reply-input\" id=\"replyInput"+milliseconds+"\" placeholder=\"Add a reply...\" autocomplete=\"off\">" +
                                        "<button type=\"button\" class=\"instagram-comment-reply-submit\" id=\"replySubmit"+milliseconds+"\" onclick=\"addReply("+milliseconds+");\" disabled>Post</button>" +
                                        "<button type=\"button\" class=\"instagram-comment-reply-cancel\" onclick=\"hideReplyForm("+milliseconds+");\">Cancel</button>" +
                                    "</div>" +
                                "</div>";
                            
                            $('#commentContainer').append(commentHtml);
                            
                            // Enable/disable reply submit button
                            $(document).on('input', '#replyInput'+milliseconds, function(){
                                var value = $(this).val().trim();
                                $('#replySubmit'+milliseconds).prop('disabled', value.length === 0);
                            });
                            
                            // Submit reply on Enter
                            $(document).on('keypress', '#replyInput'+milliseconds, function(e){
                                if(e.which === 13 && !e.shiftKey) {
                                    e.preventDefault();
                                    if(!$('#replySubmit'+milliseconds).prop('disabled')) {
                                        addReply(milliseconds);
                                    }
                                }
                            });
                        }
                    }
                    
                    $('#commentFooter').show();
                    $('#commentInput').val('');
                    $('#commentPostBtn').prop('disabled', true);
                    
                } catch(e) {
                    console.error('Error parsing comments:', e);
                    $('#commentContainer').html('<div class="instagram-comment-empty"><i class="material-icons">error_outline</i><p>Error loading comments</p></div>');
                }
            } else {
                console.error('Failed to fetch comments. Status:', ajax.status);
                $('#commentContainer').html('<div class="instagram-comment-empty"><i class="material-icons">error_outline</i><p>Failed to load comments</p></div>');
            }
        }
        ajax.onerror = function(){
            console.error('Network error fetching comments');
            $('#commentContainer').html('<div class="instagram-comment-empty"><i class="material-icons">error_outline</i><p>Network error</p></div>');
        }
        ajax.open("GET", "{{url('/api/comments')}}/"+major+"?user_id=10000&post_id="+postId, true);
        ajax.send();
    }
    
    // Enable/disable post button based on input
    $(document).on('input', '#commentInput', function(){
        var value = $(this).val().trim();
        $('#commentPostBtn').prop('disabled', value.length === 0);
    });
    
    // Submit comment on Enter key
    $(document).on('keypress', '#commentInput', function(e){
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            if(!$('#commentPostBtn').prop('disabled')) {
                addCommentFromModal();
            }
        }
    });
    
    // Close comment dialog function
    function closeCommentDialog(){
        $('#commentDialog').modal('hide');
    }
    
    // Focus input when modal opens
    $('#commentDialog').on('shown.bs.modal', function(){
        // Ensure modal is above navbar
        $(this).css('z-index', '1065');
        $('.modal-backdrop').css('z-index', '1064');
        setTimeout(function(){
            $('#commentInput').focus();
        }, 300);
    });
    
    // Clear input when modal closes
    $('#commentDialog').on('hidden.bs.modal', function(){
        $('#commentInput').val('');
        $('#commentPostBtn').prop('disabled', true).text('Post');
        $('#commentContainer').html('<div class="instagram-comment-loading"><div class="instagram-comment-spinner"></div><p>Loading comments...</p></div>');
        $('#commentFooter').hide();
        // Reset z-index
        $(this).css('z-index', '');
        $('.modal-backdrop').css('z-index', '');
    });
    
    // Set z-index when comment dialog is opened via data-toggle
    $(document).on('click', '[data-toggle="modal"][data-target="#commentDialog"]', function(){
        setTimeout(function(){
            $('#commentDialog').css('z-index', '1065');
            $('.modal-backdrop').css('z-index', '1064');
        }, 100);
    });
    
    // Edit Post Functionality - Enhanced
    function editPost(postId, body, image){
        $('#editPostId').val(postId);
        var postBody = (body || '').replace(/\\'/g, "'");
        $('#editPostBody').val(postBody);
        updateCharCount();
        $('#editPostForm').removeData('remove-image');
        
        if(image && image != ''){
            $('#editPostCurrentImage').attr('src', image);
            $('#editPostImageSection').show();
            $('#editImageSectionTitle').text('Replace Image');
        } else {
            $('#editPostImageSection').hide();
            $('#editImageSectionTitle').text('Add Image');
        }
        
        $('#editPostNewImagePreview').hide();
        $('#editPostImageFile').val('');
        $('#editPostUploadArea').show();
        
        // Ensure modal appears above navbar
        $('#editPostDialog').css('z-index', '1065');
        $('.modal-backdrop').css('z-index', '1064');
        $('#editPostDialog').modal('show');
    }
    
    // Close edit post dialog function
    function closeEditPostDialog(){
        $('#editPostDialog').modal('hide');
    }
    
    function removeEditPostImage(){
        if(confirm('Are you sure you want to remove this image?')){
            document.getElementById('editPostCurrentImage').setAttribute('src', '');
            var imageSection = document.getElementById('editPostImageSection');
            if(imageSection){
                imageSection.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
                imageSection.style.maxHeight = imageSection.scrollHeight + 'px';
                setTimeout(function(){
                    imageSection.style.maxHeight = '0';
                    imageSection.style.opacity = '0';
                    setTimeout(function(){
                        imageSection.style.display = 'none';
                    }, 300);
                }, 10);
            }
            $('#editPostForm').data('remove-image', true);
            document.getElementById('editImageSectionTitle').textContent = 'Add Image';
        }
    }
    
    function removeNewEditImage(){
        var preview = document.getElementById('editPostNewImagePreview');
        if(preview){
            preview.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
            preview.style.maxHeight = preview.scrollHeight + 'px';
            setTimeout(function(){
                preview.style.maxHeight = '0';
                preview.style.opacity = '0';
                setTimeout(function(){
                    preview.style.display = 'none';
                    document.getElementById('editPostImageFile').value = '';
                    document.getElementById('editPostUploadArea').style.display = 'block';
                }, 300);
            }, 10);
        }
    }
    
    // Update character count
    function updateCharCount(){
        var length = $('#editPostBody').val().length;
        $('#editPostCharCount').text(length);
    }
    
    $(document).on('input', '#editPostBody', function(){
        updateCharCount();
    });
    
    // Preview new image when file is selected
    $(document).on('change', '#editPostImageFile', function(e){
        var file = e.target.files[0];
        if(file){
            // Validate file size (10MB)
            if(file.size > 10 * 1024 * 1024){
                alert('Image size must be less than 10MB');
                $(this).val('');
                return;
            }
            
            var reader = new FileReader();
            reader.onload = function(e){
                document.getElementById('editPostNewImage').setAttribute('src', e.target.result);
                var uploadArea = document.getElementById('editPostUploadArea');
                var preview = document.getElementById('editPostNewImagePreview');
                if(uploadArea){
                    uploadArea.style.transition = 'max-height 0.2s ease-out, opacity 0.2s ease-out';
                    uploadArea.style.maxHeight = uploadArea.scrollHeight + 'px';
                    setTimeout(function(){
                        uploadArea.style.maxHeight = '0';
                        uploadArea.style.opacity = '0';
                        setTimeout(function(){
                            uploadArea.style.display = 'none';
                        }, 200);
                    }, 10);
                }
                if(preview){
                    preview.style.display = 'block';
                    preview.style.maxHeight = '0';
                    preview.style.opacity = '0';
                    preview.style.transition = 'max-height 0.3s ease-out, opacity 0.3s ease-out';
                    setTimeout(function(){
                        preview.style.maxHeight = preview.scrollHeight + 'px';
                        preview.style.opacity = '1';
                    }, 10);
                }
            };
            reader.readAsDataURL(file);
        } else {
            $('#editPostNewImagePreview').hide();
            $('#editPostUploadArea').show();
        }
    });
    
    // Drag and drop functionality
    var uploadArea = document.getElementById('editPostUploadArea');
    if(uploadArea){
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e){
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e){
            uploadArea.classList.add('drag-over');
        }
        
        function unhighlight(e){
            uploadArea.classList.remove('drag-over');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e){
            var dt = e.dataTransfer;
            var files = dt.files;
            if(files.length > 0){
                $('#editPostImageFile')[0].files = files;
                $('#editPostImageFile').trigger('change');
            }
        }
    }
    
    // Handle edit post form submission
    $('#editPostForm').on('submit', function(e){
        e.preventDefault();
        
        var postId = $('#editPostId').val();
        var body = $('#editPostBody').val().trim();
        var imageFile = $('#editPostImageFile')[0].files[0];
        
        var formData = new FormData();
        formData.append('body', body);
        formData.append('_method', 'PUT');
        if(imageFile){
            formData.append('myfile', imageFile);
        }
        // Check if image should be removed
        if($('#editPostForm').data('remove-image')){
            formData.append('remove_image', '1');
        }
        
        var saveBtn = $('#editPostSaveBtn');
        saveBtn.prop('disabled', true).html('<i class="material-icons" style="animation: spin 1s linear infinite;">sync</i><span>Saving...</span>');
        
        var ajax = new XMLHttpRequest();
        ajax.onload = function(){
            if(ajax.status == 200 || ajax.readyState == 4){
                try {
                    var response = JSON.parse(ajax.responseText);
                    if(response.success) {
                        $('#editPostDialog').modal('hide');
                        // Reload the page to show updated post
                        location.reload();
                    } else {
                        alert('Failed to update post: ' + (response.message || 'Unknown error'));
                        saveBtn.prop('disabled', false).html('<i class="material-icons">check</i><span>Save Changes</span>');
                    }
                } catch(e) {
                    console.error('Error parsing update post response:', e);
                    alert('Error updating post');
                    saveBtn.prop('disabled', false).html('<i class="material-icons">check</i><span>Save Changes</span>');
                }
            } else {
                console.error('Failed to update post. Status:', ajax.status);
                alert('Failed to update post');
                saveBtn.prop('disabled', false).html('<i class="material-icons">check</i><span>Save Changes</span>');
            }
        }
        ajax.onerror = function(){
            console.error('Network error updating post');
            alert('Network error. Please try again.');
            saveBtn.prop('disabled', false).html('<i class="material-icons">check</i><span>Save Changes</span>');
        }
        ajax.open("POST", "{{url('/api/posts')}}/"+postId, true);
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}");
        ajax.send(formData);
    });
    
    // Delete Post Functionality
    var postToDelete = 0;
    
    function confirmDeletePost(postId){
        postToDelete = postId;
        // Ensure modal appears above navbar
        $('#deletePostDialog').css('z-index', '1065');
        $('.modal-backdrop').css('z-index', '1064');
        $('#deletePostDialog').modal('show');
    }
    
    // Close delete post dialog function
    function closeDeletePostDialog(){
        $('#deletePostDialog').modal('hide');
    }
    
    $('#confirmDeleteBtn').on('click', function(){
        if(postToDelete == 0) return;
        
        var deleteBtn = $(this);
        deleteBtn.prop('disabled', true).text('Deleting...');
        
        var ajax = new XMLHttpRequest();
        ajax.onload = function(){
            if(ajax.status == 200 || ajax.readyState == 4){
                try {
                    var response = JSON.parse(ajax.responseText);
                    if(response.success) {
                        $('#deletePostDialog').modal('hide');
                        // Remove post from DOM with fade effect using vanilla JS
                        var postElement = document.getElementById('instagram-post-'+postToDelete);
                        if(postElement){
                            postElement.style.transition = 'opacity 0.3s ease-out';
                            postElement.style.opacity = '0';
                            setTimeout(function(){
                                postElement.remove();
                                // If no posts left, reload page
                                if(document.querySelectorAll('.instagram-post').length === 0){
                                    location.reload();
                                }
                            }, 300);
                        } else {
                            // If element not found, reload page
                            location.reload();
                        }
                    } else {
                        alert('Failed to delete post: ' + (response.message || 'Unknown error'));
                        deleteBtn.prop('disabled', false).text('Delete');
                    }
                } catch(e) {
                    console.error('Error parsing delete post response:', e);
                    alert('Error deleting post');
                    deleteBtn.prop('disabled', false).text('Delete');
                }
            } else {
                console.error('Failed to delete post. Status:', ajax.status);
                alert('Failed to delete post');
                deleteBtn.prop('disabled', false).text('Delete');
            }
        }
        ajax.onerror = function(){
            console.error('Network error deleting post');
            alert('Network error. Please try again.');
            deleteBtn.prop('disabled', false).text('Delete');
        }
        ajax.open("DELETE", "{{url('/api/posts')}}/"+postToDelete, true);
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}");
        ajax.send();
    });
    
    // Reset delete dialog when closed
    $('#deletePostDialog').on('hidden.bs.modal', function(){
        postToDelete = 0;
        $('#confirmDeleteBtn').prop('disabled', false).text('Delete');
        // Reset z-index
        $('#deletePostDialog').css('z-index', '');
        $('.modal-backdrop').css('z-index', '');
    });
    
    // Set z-index when delete dialog opens
    $('#deletePostDialog').on('shown.bs.modal', function(){
        // Ensure modal is above navbar
        $(this).css('z-index', '1065');
        $('.modal-backdrop').css('z-index', '1064');
    });
    
    // Reset edit dialog when closed
    $('#editPostDialog').on('hidden.bs.modal', function(){
        $('#editPostForm')[0].reset();
        $('#editPostForm').removeData('remove-image');
        $('#editPostImageSection').hide();
        $('#editPostNewImagePreview').hide();
        $('#editPostUploadArea').show();
        $('#editPostCharCount').text('0');
        $('#editPostSaveBtn').prop('disabled', false).html('<i class="material-icons">check</i><span>Save Changes</span>');
        $('.instagram-edit-upload-area').removeClass('drag-over');
        // Reset z-index
        $('#editPostDialog').css('z-index', '');
        $('.modal-backdrop').css('z-index', '');
    });
    
    // Focus textarea when modal opens
    $('#editPostDialog').on('shown.bs.modal', function(){
        // Ensure modal is above navbar
        $(this).css('z-index', '1065');
        $('.modal-backdrop').css('z-index', '1064');
        setTimeout(function(){
            $('#editPostBody').focus();
        }, 300);
    });
    
    // Also handle ESC key to close
    $(document).on('keydown', function(e){
        if(e.key === 'Escape' && $('#editPostDialog').hasClass('show')){
            closeEditPostDialog();
        }
    });


    function addCommentFromModal(){
        var cmt = $('#commentInput').val().trim();
        
        if(cmt.length < 1){
            return;
        }
        
        var postBtn = $('#commentPostBtn');
        postBtn.prop('disabled', true);
        postBtn.text('Posting...');
        
        var ajax = new XMLHttpRequest();
        ajax.onload = function(){
            if(ajax.status == 200 || ajax.readyState == 4){
                try {
                    var response = JSON.parse(ajax.responseText);
                    if(response.success) {
                        $('#commentInput').val('');
                        postBtn.text('Post');
                        fetchComment(currentPostId, currentMajor);
                    } else {
                        alert('Failed to add comment: ' + (response.message || 'Unknown error'));
                        postBtn.prop('disabled', false);
                        postBtn.text('Post');
                    }
                } catch(e) {
                    console.error('Error parsing add comment response:', e);
                    alert('Error adding comment');
                    postBtn.prop('disabled', false);
                    postBtn.text('Post');
                }
            } else {
                console.error('Failed to add comment. Status:', ajax.status);
                alert('Failed to add comment');
                postBtn.prop('disabled', false);
                postBtn.text('Post');
            }
        }
        ajax.onerror = function(){
            console.error('Network error adding comment');
            alert('Network error. Please try again.');
            postBtn.prop('disabled', false);
            postBtn.text('Post');
        }
        ajax.open("POST", "{{url('/api/comments')}}", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("writer_id=10000&post_id="+currentPostId+"&body="+encodeURIComponent(cmt)+"&owner_id="+currentOwnerId+"&action=0");
    }


    function likeComment(post_id, comment_id){
        var likeBtn = $('#react'+comment_id);
        var likeIcon = likeBtn.find('i');
        var countSpan = $('#likes'+comment_id);
        
        if(!likeBtn.length) {
            console.error('Comment like button not found');
            return;
        }
        
        // Get current state
        var isCurrentlyLiked = likeBtn.hasClass('liked');
        var currentCount = parseInt(countSpan.text()) || 0;
        
        // Optimistic UI update
        if(isCurrentlyLiked){
            likeIcon.text('favorite_border');
            likeBtn.removeClass('liked');
            if(currentCount > 1) {
                countSpan.text(currentCount - 1).show();
            } else {
                countSpan.hide();
            }
        } else {
            likeIcon.text('favorite');
            likeBtn.addClass('liked');
            countSpan.text(currentCount + 1).show();
        }
        
        // Disable button during request
        likeBtn.prop('disabled', true);
        
        var ajax = new XMLHttpRequest();
        ajax.onload = function(){
            if(ajax.status == 200 || ajax.readyState == 4){
                try {
                    var response = JSON.parse(ajax.responseText);
                    if(!response.success) {
                        console.error('API Error:', response.message);
                        // Revert optimistic update
                        if(isCurrentlyLiked){
                            likeIcon.text('favorite');
                            likeBtn.addClass('liked');
                            countSpan.text(currentCount).show();
                        } else {
                            likeIcon.text('favorite_border');
                            likeBtn.removeClass('liked');
                            countSpan.text(currentCount > 0 ? currentCount : '').show();
                        }
                        likeBtn.prop('disabled', false);
                        return;
                    }
                    
                    var data = response.data || {};
                    var likeCount = data.count || 0;
                    var isLiked = data.isLike;
                    
                    // Update with actual values from server
                    if(likeCount > 0){
                        countSpan.text(likeCount).show();
                    } else {
                        countSpan.hide();
                    }
                    
                    if(isLiked){
                        likeIcon.text('favorite');
                        likeBtn.addClass('liked');
                    } else {
                        likeIcon.text('favorite_border');
                        likeBtn.removeClass('liked');
                    }
                } catch(e) {
                    console.error('Error parsing comment like response:', e);
                    // Revert optimistic update
                    if(isCurrentlyLiked){
                        likeIcon.text('favorite');
                        likeBtn.addClass('liked');
                        countSpan.text(currentCount).show();
                    } else {
                        likeIcon.text('favorite_border');
                        likeBtn.removeClass('liked');
                        countSpan.text(currentCount > 0 ? currentCount : '').show();
                    }
                }
            } else {
                console.error('Error liking comment. Status:', ajax.status);
                // Revert optimistic update
                if(isCurrentlyLiked){
                    likeIcon.text('favorite');
                    likeBtn.addClass('liked');
                    countSpan.text(currentCount).show();
                } else {
                    likeIcon.text('favorite_border');
                    likeBtn.removeClass('liked');
                    countSpan.text(currentCount > 0 ? currentCount : '').show();
                }
            }
            likeBtn.prop('disabled', false);
        }
        ajax.onerror = function(){
            console.error('Network error liking comment');
            // Revert optimistic update
            if(isCurrentlyLiked){
                likeIcon.text('favorite');
                likeBtn.addClass('liked');
                countSpan.text(currentCount).show();
            } else {
                likeIcon.text('favorite_border');
                likeBtn.removeClass('liked');
                countSpan.text(currentCount > 0 ? currentCount : '').show();
            }
            likeBtn.prop('disabled', false);
        }
        ajax.open("POST", "{{url('/api/comments/like')}}", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("user_id=10000&post_id="+post_id+"&comment_id="+comment_id);
    }
    
    // Delete Comment Functionality
    function deleteComment(commentId){
        if(!confirm('Are you sure you want to delete this comment? This action cannot be undone.')){
            return;
        }
        
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                if(ajax.status == 200){
                    try {
                        var response = JSON.parse(ajax.responseText);
                        if(response.success) {
                            // Find and remove comment element
                            var commentElement = null;
                            
                            // Check main comments
                            $('.instagram-comment-item').each(function(){
                                var $item = $(this);
                                if($item.find('[onclick*="deleteComment('+commentId+')"]').length > 0 || 
                                   $item.find('[onclick*="likeComment('+currentPostId+','+commentId+')"]').length > 0){
                                    commentElement = $item;
                                    return false; // break
                                }
                            });
                            
                            // Check reply comments
                            if(!commentElement){
                                $('.instagram-comment-reply-item').each(function(){
                                    var $item = $(this);
                                    if($item.find('[onclick*="deleteComment('+commentId+')"]').length > 0 || 
                                       $item.find('[onclick*="likeComment('+currentPostId+','+commentId+')"]').length > 0){
                                        commentElement = $item;
                                        return false; // break
                                    }
                                });
                            }
                            
                            if(commentElement && commentElement.length > 0){
                                var element = commentElement[0];
                                element.style.transition = 'opacity 0.3s ease-out';
                                element.style.opacity = '0';
                                setTimeout(function(){
                                    element.remove();
                                    // Check if no comments left
                                    if(document.querySelectorAll('#commentContainer .instagram-comment-item').length === 0){
                                        document.getElementById('commentContainer').innerHTML = 
                                            '<div class="instagram-comment-empty">' +
                                                '<i class="material-icons">chat_bubble_outline</i>' +
                                                '<p>No comments yet.<br>Be the first to comment!</p>' +
                                            '</div>';
                                    }
                                    // Reload comments to update counts
                                    fetchComment(currentPostId, currentMajor);
                                }, 300);
                            } else {
                                // If element not found, reload comments
                                fetchComment(currentPostId, currentMajor);
                            }
                        } else {
                            alert('Failed to delete comment: ' + (response.message || 'Unknown error'));
                        }
                    } catch(e) {
                        console.error('Error parsing delete comment response:', e, ajax.responseText);
                        alert('Error deleting comment');
                    }
                } else {
                    console.error('Failed to delete comment. Status:', ajax.status, ajax.responseText);
                    alert('Failed to delete comment');
                }
            }
        }
        ajax.onerror = function(){
            console.error('Network error deleting comment');
            alert('Network error. Please try again.');
        }
        ajax.open("DELETE", "{{url('/api/comments')}}/"+commentId, true);
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}");
        ajax.send();
    }

    function likePost(postId, isLiked){
        var noneReactIcon = document.getElementById('noneReactIcon'+postId);
        var tvLikes = document.getElementById('tvLikes'+postId);
        var reactBtn = document.getElementById('react'+postId);
        
        if(!noneReactIcon || !tvLikes || !reactBtn) {
            console.error('Post like elements not found for post:', postId);
            return;
        }
        
        // Optimistic UI update
        var isCurrentlyLiked = reactBtn.classList.contains('liked');
        if(isCurrentlyLiked){
            noneReactIcon.textContent = "favorite_border";
            reactBtn.classList.remove('liked');
            if(tvLikes) {
                var currentText = tvLikes.textContent;
                var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                if(currentCount > 1) {
                    tvLikes.textContent = numberFormat(currentCount - 1) + ' likes';
                } else {
                    tvLikes.style.display = 'none';
                }
            }
        } else {
            noneReactIcon.textContent = "favorite";
            reactBtn.classList.add('liked');
            if(tvLikes) {
                var currentText = tvLikes.textContent;
                var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                tvLikes.textContent = numberFormat(currentCount + 1) + ' likes';
                tvLikes.style.display = 'block';
            }
        }
        
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4){
                if(ajax.status == 200){
                    try {
                        var response = JSON.parse(ajax.responseText);
                        if(!response.success) {
                            console.error('API Error:', response.message);
                            // Revert optimistic update
                            if(isCurrentlyLiked){
                                noneReactIcon.textContent = "favorite";
                                reactBtn.classList.add('liked');
                                if(tvLikes) {
                                    var currentText = tvLikes.textContent;
                                    var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                                    if(currentCount > 0) {
                                        tvLikes.textContent = numberFormat(currentCount) + ' likes';
                                        tvLikes.style.display = 'block';
                                    } else {
                                        tvLikes.style.display = 'none';
                                    }
                                }
                            } else {
                                noneReactIcon.textContent = "favorite_border";
                                reactBtn.classList.remove('liked');
                                if(tvLikes) {
                                    var currentText = tvLikes.textContent;
                                    var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                                    if(currentCount > 1) {
                                        tvLikes.textContent = numberFormat(currentCount - 1) + ' likes';
                                        tvLikes.style.display = 'block';
                                    } else {
                                        tvLikes.style.display = 'none';
                                    }
                                }
                            }
                            return;
                        }
                        
                        var data = response.data || {};
                        var likeCount = data.count || 0;
                        var isLiked = data.isLike;
                        
                        if(likeCount > 0){
                            tvLikes.textContent = numberFormat(likeCount) + ' likes';
                            tvLikes.style.display = 'block';
                        } else {
                            tvLikes.style.display = 'none';
                        }
                        
                        if(isLiked){
                            noneReactIcon.textContent = "favorite";
                            reactBtn.classList.add('liked');
                        } else {
                            noneReactIcon.textContent = "favorite_border";
                            reactBtn.classList.remove('liked');
                        }
                    } catch(e) {
                        console.error('Error parsing post like response:', e, ajax.responseText);
                        // Revert optimistic update
                        if(isCurrentlyLiked){
                            noneReactIcon.textContent = "favorite";
                            reactBtn.classList.add('liked');
                            if(tvLikes) {
                                var currentText = tvLikes.textContent;
                                var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                                if(currentCount > 0) {
                                    tvLikes.textContent = numberFormat(currentCount) + ' likes';
                                    tvLikes.style.display = 'block';
                                } else {
                                    tvLikes.style.display = 'none';
                                }
                            }
                        } else {
                            noneReactIcon.textContent = "favorite_border";
                            reactBtn.classList.remove('liked');
                            if(tvLikes) {
                                var currentText = tvLikes.textContent;
                                var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                                if(currentCount > 1) {
                                    tvLikes.textContent = numberFormat(currentCount - 1) + ' likes';
                                    tvLikes.style.display = 'block';
                                } else {
                                    tvLikes.style.display = 'none';
                                }
                            }
                        }
                    }
                } else {
                    console.error('Failed to like post. Status:', ajax.status, ajax.responseText);
                    // Revert optimistic update
                    if(isCurrentlyLiked){
                        noneReactIcon.textContent = "favorite";
                        reactBtn.classList.add('liked');
                        if(tvLikes) {
                            var currentText = tvLikes.textContent;
                            var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                            if(currentCount > 0) {
                                tvLikes.textContent = numberFormat(currentCount) + ' likes';
                                tvLikes.style.display = 'block';
                            } else {
                                tvLikes.style.display = 'none';
                            }
                        }
                    } else {
                        noneReactIcon.textContent = "favorite_border";
                        reactBtn.classList.remove('liked');
                        if(tvLikes) {
                            var currentText = tvLikes.textContent;
                            var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                            if(currentCount > 1) {
                                tvLikes.textContent = numberFormat(currentCount - 1) + ' likes';
                                tvLikes.style.display = 'block';
                            } else {
                                tvLikes.style.display = 'none';
                            }
                        }
                    }
                }
            }
        }
        ajax.onerror = function(){
            console.error('Network error liking post');
            // Revert optimistic update
            if(isCurrentlyLiked){
                noneReactIcon.textContent = "favorite";
                reactBtn.classList.add('liked');
                if(tvLikes) {
                    var currentText = tvLikes.textContent;
                    var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                    if(currentCount > 0) {
                        tvLikes.textContent = numberFormat(currentCount) + ' likes';
                        tvLikes.style.display = 'block';
                    } else {
                        tvLikes.style.display = 'none';
                    }
                }
            } else {
                noneReactIcon.textContent = "favorite_border";
                reactBtn.classList.remove('liked');
                if(tvLikes) {
                    var currentText = tvLikes.textContent;
                    var currentCount = parseInt(currentText.replace(/[^0-9]/g, '')) || 0;
                    if(currentCount > 1) {
                        tvLikes.textContent = numberFormat(currentCount - 1) + ' likes';
                        tvLikes.style.display = 'block';
                    } else {
                        tvLikes.style.display = 'none';
                    }
                }
            }
        }
        ajax.open("POST", "{{url('/api/posts/like')}}", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{csrf_token()}}");
        // Ensure postId is sent as a string to handle large bigint values
        ajax.send("user_id=10000&post_id="+String(postId));
    }
       
</script>

@endsection
<script
src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
crossorigin="anonymous"
></script>
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
crossorigin="anonymous"
></script>
<script src="https://player.vimeo.com/api/player.js"></script>
