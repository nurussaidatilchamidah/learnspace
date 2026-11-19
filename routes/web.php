<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoStreamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\CourseController as StudentCourseController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.courses.index')
        : redirect()->route('student.courses.index');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Streaming video: harus login, role dicek di controller
    Route::get('videos/{video}/stream', VideoStreamController::class)->name('videos.stream');
});

// Area admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('courses', AdminCourseController::class)->except('show');

    Route::prefix('courses/{course}')->name('courses.')->group(function () {
        Route::get('lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::get('lessons/create', [LessonController::class, 'create'])->name('lessons.create');
        Route::post('lessons', [LessonController::class, 'store'])->name('lessons.store');
    });

    Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::post('lessons/{lesson}/move/{direction}', [LessonController::class, 'move'])
        ->whereIn('direction', ['up', 'down'])->name('lessons.move');

    Route::post('lessons/{lesson}/video', [VideoController::class, 'store'])->name('lessons.video.store');
});

// Area student (placeholder, diganti di langkah berikutnya)
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('courses/{course}/lessons/{lesson}', [StudentCourseController::class, 'lesson'])->name('courses.lesson');
});

require __DIR__.'/auth.php';