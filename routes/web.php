<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome'); // You can replace 'welcome' with your actual homepage view
});

Route::get('/student/[id]', [StudentController::class,'homepage']);
Route ::get('/studentView',[StudentController::class,'index']);
Route::get('/admin/[id]', [AdminController::class,'homepage']);
Route ::get('/adminView',[AdminController::class,'index']);
Route::get('/advisor/[id]', [AdvisorController::class,'homepage']);
Route ::get('/advisorView',[AdvisorController::class,'index']);
Route::get('/course/[id]', [CourseController::class,'homepage']);
Route ::get('/courseView',[CourseController::class,'index']);
Route::get('/enrollment/[id]', [EnrollmentController::class,'homepage']);
Route ::get('/enrollmentView',[EnrollmentController::class,'index']);
Route::get('/result/[id]', [ResultController::class,'homepage']);
Route ::get('/resultView',[ResultController::class,'index']);
Route::get('/session/[id]', [SessionController::class,'homepage']);
Route ::get('/sessionView',[SessionController::class,'index']);
Route::get('/teacher/[id]', [TeacherController::class,'homepage']);
Route ::get('/teacherView',[TeacherController::class,'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'usercheck'])->middleware('auth', 'admin');
// Route::get('/advisor', [App\Http\Controllers\AdvisorController::class, 'usercheck'])->middleware('auth', 'advisor');
