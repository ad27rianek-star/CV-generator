<?php

use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CvController::class, 'create'])->name('cv.create');

Route::post('/cv/download', [CvController::class, 'download'])->name('cv.download');
