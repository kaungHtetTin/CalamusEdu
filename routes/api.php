<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

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

//User controlling
Route::get('/users/vip/{id}',[UserController::class,'showVipsetting'])->name('showVipsetting');
