<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {


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




});

Auth::routes();


