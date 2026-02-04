<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Đây là nơi đăng ký các routes cho API của ứng dụng.
| Các routes này được load bởi RouteServiceProvider và
| tất cả sẽ được gán prefix "api".
|
*/

// Routes cho Project module
Route::apiResource('projects', ProjectController::class);


// Routes bổ sung cho Project
Route::prefix('projects')->group(function () {
    Route::get('active/list', [ProjectController::class, 'getActiveProjects']);
    Route::get('featured/list', [ProjectController::class, 'getFeaturedProjects']);
});

// Routes cho Contact module (form liên hệ)
Route::prefix('contacts')->group(function () {
    Route::post('store', [ContactController::class, 'store']);
    Route::get('index', [ContactController::class, 'index']);
    Route::put('update-status/{id}', [ContactController::class, 'updateStatus']);
    Route::delete('destroy/{id}', [ContactController::class, 'destroy']);
});
