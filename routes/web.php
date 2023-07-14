<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Models\Lesson;

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


//subjects

Route::get('show_subjects', [SubjectController::class, 'show_subjects'])->name('show_subjects');
Route::get('get_subjects_data', [SubjectController::class, 'get_subjects_data'])->name('get_subjects_data');
Route::post('store_subject',  [SubjectController::class , 'store_subject'])->name('store_subject');
Route::post('update_subject',  [SubjectController::class , 'update_subject'])->name('update_subject');
Route::post('delete_subject',  [SubjectController::class , 'delete_subject'])->name('delete_subject');


//levels

Route::get('/show_levels/{id?}',  [LevelController::class , 'show_levels'])->name('show_levels');
Route::get('get_levels_data/{id?}', [LevelController::class , 'get_levels_data'])->name('get_levels_data');
Route::get('subject_levels_data/{id}', [LevelController::class , 'subject_levels_data'])->name('subject_levels_data');
Route::post('store_level', [LevelController::class , 'store_level'])->name('store_level');
Route::post('update_level',  [LevelController::class , 'update_level'])->name('update_level');
Route::post('delete_level',  [LevelController::class , 'delete_level'])->name('delete_level');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//courses

Route::get('/show_courses',  [CourseController::class , 'show_courses'])->name('show_courses');
Route::get('/show_courses/{id}',  [CourseController::class , 'show_courses'])->name('show_courses');
Route::get('get_courses_data', [CourseController::class , 'get_courses_data'])->name('get_courses_data');

Route::get('level_courses_data/{id}', [CourseController::class , 'level_courses_data'])->name('level_courses_data');
Route::post('store_course', [CourseController::class , 'store_course'])->name('store_course');
Route::post('update_course',  [CourseController::class , 'update_course'])->name('update_course');
Route::post('delete_course',  [CourseController::class , 'delete_course'])->name('delete_course');



//sections

Route::get('/show_sections/{id?}',  [SectionController::class , 'show_sections'])->name('show_sections');
Route::get('get_sections_data/{id?}', [SectionController::class , 'get_sections_data'])->name('get_sections_data');
Route::get('subject_sections_data/{id}', [SectionController::class , 'subject_sections_data'])->name('subject_sections_data');
Route::post('store_section', [SectionController::class , 'store_section'])->name('store_section');
Route::post('update_section',  [SectionController::class , 'update_section'])->name('update_section');
Route::post('delete_section',  [SectionController::class , 'delete_section'])->name('delete_section');




//lessons

Route::get('/show_lessons/{id?}',  [LessonController::class , 'show_lessons'])->name('show_lessons');
Route::get('get_lessons_data/{id?}', [LessonController::class , 'get_lessons_data'])->name('get_lessons_data');
Route::get('subject_lessons_data/{id}', [LessonController::class , 'subject_lessons_data'])->name('subject_lessons_data');
Route::post('store_lesson', [LessonController::class , 'store_lesson'])->name('store_lesson');
Route::post('update_lesson',  [LessonController::class , 'update_lesson'])->name('update_lesson');
Route::post('delete_lesson',  [LessonController::class , 'delete_lesson'])->name('delete_lesson');



//attachments
Route::get('show_lesson_attachments/{id}',  [LessonController::class , 'show_lesson_attachments'])->name('show_lesson_attachments');
Route::get('get_lesson_attachments_data/{id}',  [LessonController::class , 'get_lesson_attachments_data'])->name('get_lesson_attachments_data');
Route::post('store_lesson_attachment', [LessonController::class , 'store_lesson_attachment'])->name('store_lesson_attachment');
Route::post('update_lesson_attachment',  [LessonController::class , 'update_lesson_attachment'])->name('update_lesson_attachment');
Route::post('delete_lesson_attachment',  [LessonController::class , 'delete_lesson_attachment'])->name('delete_lesson_attachment');




//quizzes
Route::get('/show_quizzes/{id?}',  [QuizController::class , 'show_quizzes'])->name('show_quizzes');
Route::get('get_quizzes_data/{id?}', [QuizController::class , 'get_quizzes_data'])->name('get_quizzes_data');
Route::get('subject_quizzes_data/{id}', [QuizController::class , 'subject_quizzes_data'])->name('subject_quizzes_data');
Route::post('store_quiz', [QuizController::class , 'store_quiz'])->name('store_quiz');
Route::post('update_quiz',  [QuizController::class , 'update_quiz'])->name('update_quiz');
Route::post('delete_quiz',  [QuizController::class , 'delete_quiz'])->name('delete_quiz');



//questions
Route::get('/show_questions/{id?}',  [QuestionController::class , 'show_questions'])->name('show_questions');
Route::get('get_questions_data/{id?}', [QuestionController::class , 'get_questions_data'])->name('get_questions_data');
Route::get('subject_questions_data/{id}', [QuestionController::class , 'subject_questions_data'])->name('subject_questions_data');
Route::post('store_question/{id}', [QuestionController::class , 'store_question'])->name('store_question');
Route::post('update_question',  [QuestionController::class , 'update_question'])->name('update_question');
Route::post('delete_question',  [QuestionController::class , 'delete_question'])->name('delete_question');



//answers
Route::get('/show_answers/{id?}',  [AnswerController::class , 'show_answers'])->name('show_answers');
Route::get('get_answers_data/{id?}', [AnswerController::class , 'get_answers_data'])->name('get_answers_data');
Route::get('subject_answers_data/{id}', [AnswerController::class , 'subject_answers_data'])->name('subject_answers_data');
Route::post('store_answer/{id}', [AnswerController::class , 'store_answer'])->name('store_answer');
Route::post('update_answer',  [AnswerController::class , 'update_answer'])->name('update_answer');
Route::post('delete_answer',  [AnswerController::class , 'delete_answer'])->name('delete_answer');

});

Auth::routes();


