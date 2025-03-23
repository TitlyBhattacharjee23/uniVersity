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
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\StudentAuthMiddleware;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\TeacherAuthMiddleware;

Route::get('/', function () {
    return view('welcome'); // You can replace 'welcome' with your actual homepage view
});

Auth::routes();

// Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
 });


 // Protected Admin Routes
 Route::middleware([AdminAuthMiddleware::class])->group(function () {
    Route::get('/admin/{id}', [AdminController::class, 'homepage'])->name('admin.dashboard');
 });


 // Protected Teacher Routes
 Route::middleware([TeacherAuthMiddleware::class])->group(function () {
    // Teacher Profile/Dashboard
    Route::get('/teacher/{id}', [TeacherController::class, 'homepage'])
        ->name('teacher.dashboard');
 });


 // Protected Student Routes
 Route::middleware([StudentAuthMiddleware::class])->group(function () {
    Route::get('/student/{id}', [StudentController::class, 'homepage'])->name('student.dashboard');
 });

 // Admin Session Management Routes
Route::middleware([AdminAuthMiddleware::class])->group(function () {
    // Admin Profile Route
    Route::get('/admin/{admin_id}', [AdminController::class, 'homepage'])
        ->name('admin.profile');


    // Session Management Routes
    Route::get('/admin/{admin_id}/sessions', [SessionController::class, 'index'])
        ->name('admin.sessions.index');


    Route::get('/admin/{admin_id}/sessions/create', [SessionController::class, 'create'])
        ->name('admin.sessions.create');


    Route::post('/admin/{admin_id}/sessions', [SessionController::class, 'store'])
        ->name('admin.sessions.store');


    Route::get('/admin/{admin_id}/sessions/{session_id}/edit', [SessionController::class, 'edit'])
        ->name('admin.sessions.edit');


    Route::put('/admin/{admin_id}/sessions/{session_id}', [SessionController::class, 'update'])
        ->name('admin.sessions.update');
 });


Route::middleware([StudentAuthMiddleware::class])->group(function () {
    // Student Profile Route
    // Student Homepage/Profile Route
    Route::get('/student/{id}', [StudentController::class, 'homepage'])
        ->name('student.profile');

    Route::put('/student/{id}/profile', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');
 });
 // Admin Semester Management Routes
Route::middleware([AdminAuthMiddleware::class])->group(function () {
    // Admin Profile Route
    Route::get('/admin/{admin_id}', [AdminController::class, 'homepage'])
        ->name('admin.profile');


    // Semester Management Routes
    Route::get('/admin/{admin_id}/semesters', [SemesterController::class, 'index'])
        ->name('admin.semesters.index');


    Route::get('/admin/{admin_id}/semesters/create', [SemesterController::class, 'create'])
        ->name('admin.semesters.create');


    Route::post('/admin/{admin_id}/semesters', [SemesterController::class, 'store'])
        ->name('admin.semesters.store');


    Route::get('/admin/{admin_id}/semesters/{semester_id}/edit', [SemesterController::class, 'edit'])
        ->name('admin.semesters.edit');


    Route::put('/admin/{admin_id}/semesters/{semester_id}', [SemesterController::class, 'update'])
        ->name('admin.semesters.update');


    // Course Management Routes (within semesters)
    Route::post('/admin/{admin_id}/semesters/{semester_id}/courses', [CourseController::class, 'store'])
        ->name('admin.semester.courses.store');


    Route::put('/admin/{admin_id}/semesters/{semester_id}/courses/{course_id}', [CourseController::class, 'update'])
        ->name('admin.semester.courses.update');

 });
 // Student Enrollment Routes
Route::middleware([StudentAuthMiddleware::class])->group(function () {
    // Student Profile Route
    // Student Homepage/Profile Route
    Route::get('/student/{id}', [StudentController::class, 'homepage'])
        ->name('student.profile');


    // Show enrollment form
    Route::get('/student/{student_id}/enrollments/create', [EnrollmentController::class, 'create'])
        ->name('student.enrollments.create');


    // Store new enrollment
    Route::post('/student/{student_id}/enrollments', [EnrollmentController::class, 'store'])
        ->name('student.enrollments.store');


    Route::put('/student/{id}/profile', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');
 });


 Route::middleware([TeacherAuthMiddleware::class])->group(function () {
    Route::put(
        '/teacher/enrollments/{enrollment_id}/update-status',
        [TeacherController::class, 'updateEnrollmentStatus']
    )->name('teacher.enrollments.update-status');


    // Result Management
    Route::post('/teacher/results/store', [TeacherController::class, 'storeResult'])
    ->name('teacher.results.store');
    Route::post('/teacher/results/update', [TeacherController::class, 'updateResult'])
    ->name('teacher.results.update');
    Route::get('/teacher/{id}/results', [TeacherController::class, 'showResults'])
    ->name('teacher.results');
 });


