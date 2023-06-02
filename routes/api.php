<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SubjectController;

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


Route::post('register', [UserController::class, 'register']);
Route::post('login', [Usercontroller::class, 'login']);
Route::post('logout', [Usercontroller::class, 'logout']);
Route::post('forgot_password', [Usercontroller::class, 'forgot_password']);
Route::post('verify_pass_code', [Usercontroller::class, 'verify_pass_code']);
Route::post('change_forgotten_password', [Usercontroller::class, 'change_forgotten_password']);


// Banners

Route::get('welcome', [BannerController::class, 'welcome']);
Route::get('banner', [BannerController::class, 'banner']);
Route::get('privacy', [BannerController::class, 'privacy']);
Route::get('about_us', [BannerController::class, 'about_us']);



//subjects
Route::get('show_subjects', [SubjectController::class, 'show_subjects']);
Route::post('get_courses_from_subject', [SubjectController::class, 'get_courses_from_subject']);


//levels
Route::post('subject_levels', [LevelController::class, 'subject_levels']);
Route::post('levels', [SubjectController::class, 'levels']);


//courses
Route::post('course_by_id', [CourseController::class, 'course_by_id']);

