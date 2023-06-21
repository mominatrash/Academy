<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\VideoController;

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
Route::post('verify_acc', [Usercontroller::class, 'verify_acc']);
Route::post('verify_accept', [Usercontroller::class, 'verify_accept']);
Route::post('verify_decline', [Usercontroller::class, 'verify_decline']);


// Banners

Route::get('welcome', [BannerController::class, 'welcome']);
Route::get('banner', [BannerController::class, 'banner']);
Route::get('privacy', [BannerController::class, 'privacy']);
Route::get('about_us', [BannerController::class, 'about_us']);
Route::get('ad_details', [BannerController::class, 'ad_details']);



//subjects
Route::get('show_subjects', [SubjectController::class, 'show_subjects']);
Route::post('get_courses_from_subject', [SubjectController::class, 'get_courses_from_subject']);


//levels
Route::post('subject_levels', [LevelController::class, 'subject_levels']);



//courses
Route::post('my_Courses', [CourseController::class, 'my_Courses']);
Route::get('latest_courses', [CourseController::class, 'latest_courses']);
Route::post('course_by_id', [CourseController::class, 'course_by_id']);



//sections
Route::post('section_by_id_from_purchased_course', [SectionController::class, 'section_by_id_from_purchased_course']);




//lessons
Route::post('add_attachment_lesson', [LessonController::class, 'add_attachment_lesson']);
Route::post('show_download_attachment', [LessonController::class, 'show_download_attachment']);
Route::post('show_attachments_for_lesson', [LessonController::class, 'show_attachments_for_lesson']);
Route::post('lesson_by_id', [LessonController::class, 'lesson_by_id']);




//Codes
Route::post('generate_codes_for_course', [CodeController::class, 'generate_codes_for_course']);
Route::post('subscribe', [CodeController::class, 'subscribe']);



//comments
Route::post('add_comment', [CommentController::class, 'add_comment']);
Route::post('show_comments', [CommentController::class, 'show_comments']);
Route::post('add_reply', [CommentController::class, 'add_reply']);
Route::post('show_replies', [CommentController::class, 'show_replies']);
Route::post('comment_reply_like', [CommentController::class, 'comment_reply_like']);




//video
Route::post('add_video', [VideoController::class, 'add_video']);
Route::get('videos', [VideoController::class, 'videos']);



//articles
Route::get('show_articles', [BannerController::class, 'show_articles']);
Route::post('article_by_id', [BannerController::class, 'article_by_id']);




//quizzes
Route::post('quiz_by_id', [QuizController::class, 'quiz_by_id']);
Route::post('start_quiz', [QuizController::class, 'start_quiz']);
Route::post('end_quiz', [QuizController::class, 'end_quiz']);



//student
Route::get('my_group', [StudentController::class, 'my_group']);
Route::get('my_exams', [StudentController::class, 'my_exams']);
Route::get('my_lectures', [StudentController::class, 'my_lectures']);
Route::get('installments', [StudentController::class, 'installments']);
Route::get('student_statistics', [StudentController::class, 'student_statistics']);








