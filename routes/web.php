<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSectionController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Placeholders for Sidebar Items (The Band-Aid Fix) -> REMOVED
// The Real Routes (Reclaiming the Castle)
Route::get('/videos', function () {
    $videos = [
        (object) ['title' => 'Safety Video 1 – Introduction', 'url' => 'https://youtube.com/watch?v=123'],
        (object) ['title' => 'Safety Video 2 – Equipment Checklist', 'url' => 'https://youtube.com/watch?v=456'],
        (object) ['title' => 'Safety Video 3 – Emergency Procedures', 'url' => 'https://youtube.com/watch?v=789'],
    ];
    return view('videos', ['videos' => $videos]);
})->name('videos');
Route::get('/photos', function () {
    $photos = [
        (object) ['title' => 'Site Inspection', 'url' => 'https://smaller-pictures.appspot.com/images/dreamstime_xxl_65780868_small.jpg'],
        (object) ['title' => 'Safety Gear', 'url' => 'https://placehold.co/600x400?text=Safety+Gear'],
        (object) ['title' => 'Team Meeting', 'url' => 'https://placehold.co/600x400?text=Team+Meeting'],
    ];
    return view('photos', ['photos' => $photos]);
})->name('photos');
Route::get('/courses', [CourseController::class, 'index'])->name('courses');

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
    Route::get('/courses/{course}/sections', [CourseSectionController::class, 'index'])->name('courses.sections.index');
    Route::get('/courses/{course}/sections/create', [CourseSectionController::class, 'create'])->name('courses.sections.create');
    Route::post('/courses/{course}/sections', [CourseSectionController::class, 'store'])->name('courses.sections.store');
});

/*
Route::middleware(['auth', CheckRole::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
*/

// Test Route for RBAC
Route::get('/secret', function () {
    return 'Only Admins can see this!';
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';


