<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\CourseController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/videos', [VideosController::class, 'index'])->name('videos');
Route::get('/photos', [PhotosController::class, 'index'])->name('photos');
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
