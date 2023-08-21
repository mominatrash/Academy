<?php

use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;

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



Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('welcome');
    });



//admins
 Route::get('show_admins', [AdminController::class, 'show_admins'])->name('show_admins')->middleware('permission:المساعدين');
 Route::get('/create_user', [AdminController::class, 'create_user'])->name('create_user')->middleware('permission:اضافة المساعدين');
 Route::post('/store_user', [AdminController::class, 'store_user'])->name('store_user')->middleware('permission:اضافة المساعدين');
 Route::get('/edit_user/{id}', [AdminController::class, 'edit_user'])->name('edit_user')->middleware('permission:تعديل المساعدين');
 Route::post('user_delete', [AdminController::class, 'user_delete'])->name('user_delete')->middleware('permission:حذف المساعدين');
 Route::post('/update_user/{id}', [AdminController::class, 'update_user'])->name('update_user')->middleware('permission:تعديل المساعدين');

//  ->middleware('permission:');
 
 //roles
 Route::get('show_roles', [RoleController::class, 'show_roles'])->name('show_roles')->middleware('permission:الصلاحيات');

 Route::get('/create_role', [RoleController::class, 'create_role'])->name('create_role')->middleware('permission:اضافة الصلاحيات');
 Route::post('/store_role', [RoleController::class, 'store_role'])->name('store_role')->middleware('permission:اضافة الصلاحيات');
 Route::post('/edit_role', [RoleController::class, 'edit_role'])->name('edit_role')->middleware('permission:تعديل الصلاحيات');
 Route::get('/delete_role/{id}', [RoleController::class, 'delete_role'])->name('delete_role')->middleware('permission:حذف الصلاحيات');
 Route::get('/show_details/{id}', [RoleController::class, 'show_details'])->name('show_details')->middleware('permission:عرض الصلاحيات');
 Route::get('/edit_role/{id}', [RoleController::class, 'edit_role'])->name('edit_role')->middleware('permission:تعديل الصلاحيات');
 Route::post('/roles_update', [RoleController::class, 'roles_update'])->name('roles_update')->middleware('permission:تعديل الصلاحيات');
 Route::post('/delete_role/{id}', [RoleController::class, 'delete_role'])->name('delete_role')->middleware('permission:حذف الصلاحيات');



//subjects

Route::get('show_subjects', [SubjectController::class, 'show_subjects'])->name('show_subjects')->middleware('permission:المواد');
Route::get('get_subjects_data', [SubjectController::class, 'get_subjects_data'])->name('get_subjects_data')->middleware('permission:المواد');
Route::post('store_subject',  [SubjectController::class , 'store_subject'])->name('store_subject')->middleware('permission:اضافة المواد');
Route::post('update_subject',  [SubjectController::class , 'update_subject'])->name('update_subject')->middleware('permission:تعديل المواد');
Route::post('delete_subject',  [SubjectController::class , 'delete_subject'])->name('delete_subject')->middleware('permission:حذف المواد');


//levels

Route::get('/show_levels/{id?}',  [LevelController::class , 'show_levels'])->name('show_levels')->middleware('permission:المراحل');
Route::get('get_levels_data/{id?}', [LevelController::class , 'get_levels_data'])->name('get_levels_data')->middleware('permission:المراحل');
Route::get('subject_levels_data/{id}', [LevelController::class , 'subject_levels_data'])->name('subject_levels_data')->middleware('permission:عرض مواد المراحل');
Route::post('store_level', [LevelController::class , 'store_level'])->name('store_level')->middleware('permission:اضافة المراحل');
Route::post('update_level',  [LevelController::class , 'update_level'])->name('update_level')->middleware('permission:تعديل المراحل');
Route::post('delete_level',  [LevelController::class , 'delete_level'])->name('delete_level')->middleware('permission:حذف المراحل');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//courses

Route::get('/show_courses',  [CourseController::class , 'show_courses'])->name('show_courses')->middleware('permission:الدورات');
Route::get('/show_courses/{id}',  [CourseController::class , 'show_courses'])->name('show_courses')->middleware('permission:الدورات');
Route::get('/show_student_courses/{user_id}',  [CourseController::class , 'show_student_courses'])->name('show_student_courses')->middleware('permission:الدورات');
Route::get('/student_courses_data/{user_id}',  [CourseController::class , 'student_courses_data'])->name('student_courses_data')->middleware('permission:الدورات');
Route::get('get_courses_data', [CourseController::class , 'get_courses_data'])->name('get_courses_data')->middleware('permission:الدورات');

Route::get('level_courses_data/{id}', [CourseController::class , 'level_courses_data'])->name('level_courses_data')->middleware('permission:عرض دورات المراحل');
Route::post('store_course', [CourseController::class , 'store_course'])->name('store_course')->middleware('permission:اضافة الدورات');
Route::post('update_course',  [CourseController::class , 'update_course'])->name('update_course')->middleware('permission:تعديل الدورات');
Route::post('delete_course',  [CourseController::class , 'delete_course'])->name('delete_course')->middleware('permission:حذف الدورات');



//sections

Route::get('/show_sections/{id?}',  [SectionController::class , 'show_sections'])->name('show_sections')->middleware('permission:الاقسام');
Route::get('get_sections_data/{id?}', [SectionController::class , 'get_sections_data'])->name('get_sections_data')->middleware('permission:الاقسام');
Route::get('subject_sections_data/{id}', [SectionController::class , 'subject_sections_data'])->name('subject_sections_data')->middleware('permission:عرض اقسام الدورات');
Route::post('store_section', [SectionController::class , 'store_section'])->name('store_section')->middleware('permission:اضافة الاقسام');
Route::post('update_section',  [SectionController::class , 'update_section'])->name('update_section')->middleware('permission:تعديل الاقسام');
Route::post('delete_section',  [SectionController::class , 'delete_section'])->name('delete_section')->middleware('permission:حذف الاقسام');




//lessons

Route::get('/show_lessons/{id?}',  [LessonController::class , 'show_lessons'])->name('show_lessons')->middleware('permission:الدروس');
Route::get('get_lessons_data/{id?}', [LessonController::class , 'get_lessons_data'])->name('get_lessons_data')->middleware('permission:الدروس');
Route::get('subject_lessons_data/{id}', [LessonController::class , 'subject_lessons_data'])->name('subject_lessons_data')->middleware('permission:عرض دروس الاقسام');
Route::post('store_lesson', [LessonController::class , 'store_lesson'])->name('store_lesson')->middleware('permission:اضافة الدروس');
Route::post('update_lesson',  [LessonController::class , 'update_lesson'])->name('update_lesson')->middleware('permission:تعديل الدروس');
Route::post('delete_lesson',  [LessonController::class , 'delete_lesson'])->name('delete_lesson')->middleware('permission:حذف الدروس');



//attachments
Route::get('show_lesson_attachments/{id}',  [LessonController::class , 'show_lesson_attachments'])->name('show_lesson_attachments')->middleware('permission:المرفقات');
Route::get('get_lesson_attachments_data/{id}',  [LessonController::class , 'get_lesson_attachments_data'])->name('get_lesson_attachments_data')->middleware('permission:المرفقات');
Route::post('store_lesson_attachment', [LessonController::class , 'store_lesson_attachment'])->name('store_lesson_attachment')->middleware('permission:اضافة المرفقات');
Route::post('update_lesson_attachment',  [LessonController::class , 'update_lesson_attachment'])->name('update_lesson_attachment')->middleware('permission:تعديل المرفقات');
Route::post('delete_lesson_attachment',  [LessonController::class , 'delete_lesson_attachment'])->name('delete_lesson_attachment')->middleware('permission:حذف المرفقات');




//quizzes
Route::get('/show_quizzes/{id?}',  [QuizController::class , 'show_quizzes'])->name('show_quizzes')->middleware('permission:الاختبارات');
Route::get('get_quizzes_data/{id?}', [QuizController::class , 'get_quizzes_data'])->name('get_quizzes_data')->middleware('permission:الاختبارات');
Route::get('subject_quizzes_data/{id}', [QuizController::class , 'subject_quizzes_data'])->name('subject_quizzes_data')->middleware('permission:عرض اختبارات الدروس');
Route::get('show_student_quizzes/{user_id}', [QuizController::class , 'show_student_quizzes'])->name('show_student_quizzes')->middleware('permission:عرض اختبارات الدروس');
Route::get('student_quizzes_data/{user_id}', [QuizController::class , 'student_quizzes_data'])->name('student_quizzes_data')->middleware('permission:عرض اختبارات الدروس');
Route::post('store_quiz', [QuizController::class , 'store_quiz'])->name('store_quiz')->middleware('permission:اضافة الاختبارات');
Route::post('update_quiz',  [QuizController::class , 'update_quiz'])->name('update_quiz')->middleware('permission:تعديل الاختبارات');
Route::post('delete_quiz',  [QuizController::class , 'delete_quiz'])->name('delete_quiz')->middleware('permission:حذف الاختبارات');



//questions
Route::get('/show_questions/{id?}',  [QuestionController::class , 'show_questions'])->name('show_questions')->middleware('permission:اسئلة الاختبارات');
Route::get('get_questions_data/{id?}', [QuestionController::class , 'get_questions_data'])->name('get_questions_data')->middleware('permission:اسئلة الاختبارات');
Route::get('subject_questions_data/{id}', [QuestionController::class , 'subject_questions_data'])->name('subject_questions_data')->middleware('permission:اسئلة الاختبارات');
Route::post('store_question/{id}', [QuestionController::class , 'store_question'])->name('store_question')->middleware('permission:اضافة الاسئلة');
Route::post('update_question',  [QuestionController::class , 'update_question'])->name('update_question')->middleware('permission:تعديل الاسئلة');
Route::post('delete_question',  [QuestionController::class , 'delete_question'])->name('delete_question')->middleware('permission:حذف الاسئلة');



//answers
Route::get('/show_answers/{id?}',  [AnswerController::class , 'show_answers'])->name('show_answers')->middleware('permission:اجابات الاسئلة');
Route::get('get_answers_data/{id?}', [AnswerController::class , 'get_answers_data'])->name('get_answers_data')->middleware('permission:اجابات الاسئلة');
Route::get('subject_answers_data/{id}', [AnswerController::class , 'subject_answers_data'])->name('subject_answers_data')->middleware('permission:اجابات الاسئلة');
Route::post('store_answer/{id}', [AnswerController::class , 'store_answer'])->name('store_answer')->middleware('permission:اضافة الاجابات');
Route::post('update_answer',  [AnswerController::class , 'update_answer'])->name('update_answer')->middleware('permission:تعديل الاجابات');
Route::post('delete_answer',  [AnswerController::class , 'delete_answer'])->name('delete_answer')->middleware('permission:حذف الاجابات');


//students

Route::get('/show_students/{id?}',  [StudentController::class , 'show_students'])->name('show_students')->middleware('permission:الطلاب');
Route::get('get_students_data/{id?}', [StudentController::class , 'get_students_data'])->name('get_students_data')->middleware('permission:الطلاب');
Route::get('get_student_data/{id}', [StudentController::class , 'get_student_data'])->name('get_student_data')->middleware('permission:الطلاب');
// Route::get('subject_students_data/{id}', [StudentController::class , 'subject_students_data'])->name('subject_students_data')->middleware('permission:عرض دورات الطالب');
// Route::post('store_student', [StudentController::class , 'store_student'])->name('store_student')->middleware('permission:اضافة الاقسام');
Route::get('/change_student_status/{user_id}',  [StudentController::class , 'change_student_status'])->name('change_student_status')->middleware('permission:الطلاب');
Route::post('update_student',  [StudentController::class , 'update_student'])->name('update_student')->middleware('permission:تعديل الطلاب');
Route::post('delete_student',  [StudentController::class , 'delete_student'])->name('delete_student')->middleware('permission:حذف الطلاب');


});

Auth::routes();


