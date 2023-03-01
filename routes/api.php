<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\{ProfileController, JobController, CategoryController, TypeController, SalaryController, HomeController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get ('/get/homecategories', [HomeController::class,   'get']);


Route::get ('/get/categories',     [CategoryController::class,            'get']);
Route::get ('/category/{token}',   [CategoryController::class,   'categoryJobs']);


Route::get ('/getjob/{token}',     [JobController::class,     'getjob']);
Route::post('/jobs/new',           [JobController::class,        'new'])->middleware('auth:sanctum');


Route::post('/profile/edit',       [ProfileController::class,     'edit'])->middleware('auth:sanctum');
Route::get ('/profile/{token}',    [ProfileController::class, 'userinfo']);


Route::get ('/get/types',          [TypeController::class,     'get']);


Route::get ('/get/salaries',       [SalaryController::class,   'get']);



// Auth
Route::controller(AuthController::class)->group(function() {
    Route::post('/auth/register',  'register');
    Route::post('/auth/login',        'login');
    Route::get ('/auth/logout',      'logout')->middleware('auth:sanctum');
    Route::get ('/auth/user',          'user')->middleware('auth:sanctum');
});