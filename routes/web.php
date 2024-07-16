<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Livewire\CourseCrud;
use App\Livewire\StudentTable;
use App\Livewire\TeacherTable;
use App\Livewire\Course\Show as CourseShow;
use App\Livewire\Attendance\Index as AttendanceIndex;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');

    Route::get('/course', CourseCrud::class)->name('course');
    Route::get('/course/{course}', CourseShow::class)->name('course.show');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/student', StudentTable::class)->name('student');
        Route::get('/teacher', TeacherTable::class)->name('teacher');
    });

    Route::group(['middleware' => ['role:teacher']], function () {
        Route::get('/attendance/{course}', AttendanceIndex::class)->name('attendance');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'welcome')->name('home');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
});