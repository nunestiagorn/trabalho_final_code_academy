<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobOpeningsController;
use App\Http\Controllers\ApplicationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('users', [UsersController::class, "index"]);
Route::post('users', [UsersController::class, "store"]);
Route::put('users/{id}', [UsersController::class, "update"]);
Route::get('users/{id}', [UsersController::class, "show"]);
Route::delete('users/{id}', [UsersController::class, "delete"]);
Route::post('users/login', [UsersController::class, "check"]);


Route::get('companies', [CompaniesController::class, "index"]);
Route::post('companies', [CompaniesController::class, "store"]);
Route::put('companies/{id}', [CompaniesController::class, "update"]);

Route::get('job_openings', [JobOpeningsController::class, "index"]);
Route::post('job_openings', [JobOpeningsController::class, "store"]);
Route::put('job_openings/{id}', [JobOpeningsController::class, "update"]);

Route::get('applications', [ApplicationsController::class, "index"]);
