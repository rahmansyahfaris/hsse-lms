<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\PhotosController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/videos', [VideosController::class, 'index'])->name('videos');
Route::get('/photos', [PhotosController::class, 'index'])->name('photos');
