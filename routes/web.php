<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\CvTemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CvController::class, 'create'])->name('cv.create');

Route::post('/cv/download', [CvController::class, 'download'])->name('cv.download');

Route::post('/cv/templates', [CvTemplateController::class, 'store'])->name('cv.templates.store');
Route::get('/cv/templates/{cvTemplate}/edit', [CvTemplateController::class, 'edit'])->name('cv.templates.edit');
Route::post('/cv/templates/{cvTemplate}', [CvTemplateController::class, 'update'])->name('cv.templates.update');
