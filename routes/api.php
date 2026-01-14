<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaveReplyController;
use App\Http\Controllers\Api\ApiPaymentController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiSaveReplyController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/lessons/updatevideoduration',[LessonController::class,'updateVideoDuration']);
Route::get('/notifications/{major}',[NotificationController::class,'fetchNotification']);

// ==================== ANDROID APP API ROUTES ====================
// These routes are specifically for the Android Customer Service app

// Payments API
Route::get('/payments/pending', [ApiPaymentController::class, 'getPendingPayment']);

// Users API
Route::get('/users/vip/{id}', [ApiUserController::class, 'showVipsetting']);
Route::post('/users/passwordreset', [ApiUserController::class, 'resetPassword']);
Route::post('/users/vipadding/{id}', [ApiUserController::class, 'addVip']);
Route::post('/users/transfer-vip-access', [ApiUserController::class, 'transferVipAccess']);

// Save Replies API
Route::get('/save-replies', [ApiSaveReplyController::class, 'index']);
Route::post('/save-replies', [ApiSaveReplyController::class, 'store']);
Route::get('/save-replies/{id}', [ApiSaveReplyController::class, 'show']);
Route::put('/save-replies/{id}', [ApiSaveReplyController::class, 'update']);
Route::delete('/save-replies/{id}', [ApiSaveReplyController::class, 'destroy']);

// ==================== OTHER API ROUTES ====================
// Keep existing routes for backward compatibility
Route::get('/users/enroll', [UserController::class, 'getEnroll']);

// ==================== POST API ROUTES ====================
Route::post('/posts', [PostController::class, 'createPost']);
Route::post('/posts/like', [PostController::class, 'likePost']);
Route::get('/posts/{postId}', [PostController::class, 'getPost']);
Route::put('/posts/{postId}', [PostController::class, 'updatePost']);
Route::post('/posts/{postId}', [PostController::class, 'updatePost']); // For FormData support
Route::delete('/posts/{postId}', [PostController::class, 'deletePostApi']);


// ==================== COMMENT API ROUTES ====================
Route::post('/comments/like', [PostController::class, 'likeComment']);
Route::get('/comments/{major}', [PostController::class, 'getComments']);
Route::post('/comments', [PostController::class, 'createComment']);
Route::put('/comments/{commentId}', [PostController::class, 'updateComment']);
Route::delete('/comments/{commentId}', [PostController::class, 'deleteComment']);

// ==================== REPORT API ROUTES ====================
Route::post('/reports/approve', [PostController::class, 'approveReport']);
Route::post('/reports/delete-post', [PostController::class, 'deleteReportedPost']);

// ==================== NOTIFICATION API ROUTES ====================
Route::post('/notifications/mark-read', [PostController::class, 'markNotificationAsRead']);


