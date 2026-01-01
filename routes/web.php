<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordOfTheDayController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\GameWordController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\CloudMessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProjectOverviewController;
use App\Http\Controllers\SpeakingTrainerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//   $2y$10$LBUfbqygLh.9g00bN1fZ1ulP5bok5lIJl212Fn6f7b9tusi8IB0/G   @$calamus5241$@

// Admin Authentication Routes (Public)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Protected Routes - Only learner_phone 10000 can access
Route::middleware(['admin.auth'])->group(function () {
    
//users controlling routes
Route::get('/users',[UserController::class,'getUser'])->name('getUser');
Route::get('/users/get',[UserController::class,'detail'])->name('detail');
Route::get('/users/search',[UserController::class,'searchUser'])->name('searchUser');
Route::get('/users/passwordreset/{phone}',[UserController::class,'showPasswordReset'])->name('showPasswordReset');
Route::post('/users/passwordreset',[UserController::class,'resetPassword'])->name('resetPassword');
Route::get('/users/easykorean',[UserController::class,'easyKoreanUserDatas'])->name('easyKoreanUserDatas');
Route::get('/users/easyenglish',[UserController::class,'easyEnglishUserDatas'])->name('easyEnglishUserDatas');
Route::get('/users/easychinese',[UserController::class,'easyChineseUserDatas'])->name('easyChineseUserDatas');
Route::get('/users/easyjapanese',[UserController::class,'easyJapaneseUserDatas'])->name('easyJapaneseUserDatas');
Route::get('/users/easyrussian',[UserController::class,'easyRussianUserDatas'])->name('easyRussianUserDatas');
Route::get('/users/email/{id}',[UserController::class,'showSendEmail'])->name('showSendEmail');
Route::post('/users/email/send',[UserController::class,'sendEmail'])->name('sendEmail');
Route::get('/users/pushnotification/{id}',[UserController::class,'showPushNotification'])->name('showPushNotification');
Route::post('/users/pushnotification/send',[UserController::class,'pushNotification'])->name('pushNotification');
Route::get('/users/vip/{phone}/{language}',[UserController::class,'showLanguageVipManagement'])->name('languageVipManagement');
Route::post('/users/vip/{phone}/{language}',[UserController::class,'updateLanguageVip'])->name('updateLanguageVip');
Route::get('/users/performance/{phone}/{language}',[UserController::class,'showUserPerformance'])->name('userPerformance');

//word of the days routes

Route::get('/wordsofday',[WordOfTheDayController::class,'showWordOfTheDayMain'])->name('showWordOfTheDayMain');
Route::get('/wordsofday/major/{major}',[WordOfTheDayController::class,'showWordOfTheDay'])->name('showWordOfTheDay');
Route::get('/wordsofday/edit/{id}',[WordOfTheDayController::class,'showDetailWordDay'])->name('showDetailWordDay');
Route::post('/wordsofday/update',[WordOfTheDayController::class,'updateWordDay'])->name('updateWordDay');
Route::get('/wordsofday/add/{major}',[WordOfTheDayController::class,'showWordDayAdding'])->name('showWordDayAdding');
Route::post('/wordsofday/add/{major}',[WordOfTheDayController::class,'addWordDay'])->name('addWordDay');

//lessons controlling routes
Route::get('/lessons/main',[LessonController::class,'showLessonMain'])->name('lessons.main');
Route::get('/lessons/{language}',[LessonController::class,'showLessonCategory'])->name('lessons.byLanguage');
Route::get('/lessons/{language}/add-course',[LessonController::class,'showAddCourse'])->name('lessons.addCourse');
Route::post('/lessons/{language}/add-course',[LessonController::class,'addCourse'])->name('lessons.storeCourse');
Route::get('/lessons/{language}/add-category/{course}',[LessonController::class,'showAddCategory'])->name('lessons.addCategory');
Route::post('/lessons/{language}/add-category/{course}',[LessonController::class,'addCategory'])->name('lessons.storeCategory');
Route::get('/lessons/showlists/{code}',[LessonController::class,'showLessonList'])->name('lessons.list');
Route::get('/lessons/video/{id}',[LessonController::class,'viewVideoLesson'])->name('viewVideoLesson');
Route::get('/lessons/blog/{id}',[LessonController::class,'viewBlogLesson'])->name('viewBlogLesson');
Route::get('/lessons/add/{course}',[LessonController::class,'showAddLesson'])->name('showAddLesson');
Route::post('/lessons/add/{course}',[LessonController::class,'addLesson'])->name('addLesson');
Route::post('/lessons/video/add',[LessonController::class,'uploadVideoForLessonDownload'])->name('uploadVideoForLessonDownload');
Route::post('/lessons/video/add-lecture-note',[LessonController::class,'updateLectureNote'])->name('lessons.add-lecture-note');

Route::post('/lessons/add-studyplan',[LessonController::class,'addLessonToStudyPlan'])->name('addLessonToStudyPlan');
Route::post('/lessons/add-vimeo',[PostController::class,'uploadVimeo'])->name('uploadVimeo');

//game controlling routes
Route::get('/gameword',[GameWordController::class,'showGameWordMain'])->name('showGameWordMain');
Route::get('/gameword/main/{major}',[GameWordController::class,'showGameWord'])->name('showGameWord');
Route::get('/gameword/add/{major}',[GameWordController::class,'showGameWordAdding'])->name('showGameWordAdding');
Route::post('/gameword/add/{major}',[GameWordController::class,'addGameWord'])->name('addGameWord');

Route::get('/gameword/edit/{id}',[GameWordController::class,'editGameWord'])->name('editGameWord');
Route::post('/gameword/delete',[GameWordController::class,'deleteGameWord'])->name('deleteGameWord');
// song controlling routes
Route::get('/song',[SongController::class,'showSongMain'])->name('showSongMain');
Route::get('/song/list/{major}',[SongController::class,'showSongs'])->name('showSongs');
Route::get('/song/add/{major}',[SongController::class,'showAddSong'])->name('showAddSong');
Route::post('/song/add/{major}',[SongController::class,'addSong'])->name('addSong');
Route::get('/song/artists/show/{major}',[SongController::class,'showArtist'])->name('showArtist');
Route::get('/song/artists/addform/{major}',[SongController::class,'showAddArtist'])->name('showAddArtist');
Route::post('/song/artists/add',[SongController::class,'addArtist'])->name('addArtist');
Route::post('/song/artists/delete',[SongController::class,'deleteArtist'])->name('deleteArtist');

//courses controlling routes
Route::get('/courses',[CourseController::class,'showCoursesMain'])->name('showCoursesMain');
Route::get('/courses/{language}',[CourseController::class,'showCoursesByLanguage'])->name('courses.byLanguage');

//posts controlling routes
Route::get('/posts',[PostController::class,'showMainPostControllerView'])->name('showMainPostControllerView');
Route::get('/posts/{major}',[PostController::class,'showTimeline'])->name('showTimeline');
Route::get('/posts/create/{major}',[PostController::class,'showCreatePost'])->name('showCreatePost');
Route::post('/posts/create/{major}',[PostController::class,'addPost'])->name('addPost');
Route::post('/posts/delete/{postId}',[PostController::class,'deletePost'])->name('deletePost');

Route::get('/posts/loadmore/{major}',[PostController::class,'fetchMorePost'])->name('fetchMorePost');


//requested songs
Route::get('/requestedsong/list/{major}',[SongController::class,'showRequestedSong'])->name('showRequestedSong');
Route::get('/requestedsong/listbyartist/{artist}',[SongController::class,'showRequestedSongByArtist'])->name('showRequestedSongByArtist');
Route::post('/requestedsong/delete/',[SongController::class,'deleteRequestedSong'])->name('deleteRequestedSong');

// cloud messageing
Route::get('/cloudmessage',[CloudMessageController::class,'showCloudMessage'])->name('showCloudMessage');
Route::post('/cloudmessage/send',[CloudMessageController::class,'sendCloudMessage'])->name('sendCloudMessage');

//speaking trainning
Route::get('/addspeakingdialogue',[SpeakingTrainerController::class,'index'])->name('showDialogueAdder');
Route::post('/addnewsaturation',[SpeakingTrainerController::class,'addNewSaturation'])->name('addNewSaturation');
Route::post('/adddialogue',[SpeakingTrainerController::class,'addDialogue'])->name('addDialogue');

//Project Overview
Route::get('/projectoverview',[ProjectOverviewController::class,'index'])->name('overviewIndex');

//payment
Route::get('/payments/{major}',[PaymentController::class,'index']);

//teachers controlling routes
Route::get('/teachers',[TeacherController::class,'index'])->name('teachers.index');
Route::get('/teachers/create',[TeacherController::class,'create'])->name('teachers.create');
Route::post('/teachers',[TeacherController::class,'store'])->name('teachers.store');
Route::get('/teachers/{id}',[TeacherController::class,'show'])->name('teachers.show');
Route::get('/teachers/{id}/edit',[TeacherController::class,'edit'])->name('teachers.edit');
Route::put('/teachers/{id}',[TeacherController::class,'update'])->name('teachers.update');
Route::delete('/teachers/{id}',[TeacherController::class,'destroy'])->name('teachers.destroy');

Route::get('/demo',function(){
    return view('layouts.demo');
});

}); // End of admin.auth middleware group