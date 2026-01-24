<?php

use App\Http\Controllers\Api\ProjectController;
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
Route::get('projects/active/list', [ProjectController::class, 'getActiveProjects']);
Route::get('projects/featured/list', [ProjectController::class, 'getFeaturedProjects']);
