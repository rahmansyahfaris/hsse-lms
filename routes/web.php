<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Placeholders for Sidebar Items (The Band-Aid Fix) -> REMOVED
// The Real Routes (Reclaiming the Castle)
Route::get('/videos', function () { return view('videos'); })->name('videos');
Route::get('/photos', function () { return view('photos'); })->name('photos');
Route::get('/courses', function () { return view('courses'); })->name('courses');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:instructor,admin'])->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
});

/*
Route::middleware(['auth', CheckRole::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
*/

require __DIR__.'/auth.php';


