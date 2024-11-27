<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobOpeningsController;
use App\Http\Controllers\ApplicationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


//rotas de usuários
Route::get('users', [UsersController::class, "index"]);
Route::post('users', [UsersController::class, "store"]);
Route::put('users/{id}', [UsersController::class, "update"]);
Route::get('users/{id}', [UsersController::class, "show"]);
Route::delete('users/{id}', [UsersController::class, "delete"]);
Route::post('users/login', [UsersController::class, "check"]);

Route::post('/users/{id}/image', [UsersController::class, 'updateImage']);
Route::get('/users/{id}/image', [UsersController::class, 'showImage']);



//rotas de empresas
Route::get('companies', [CompaniesController::class, "index"]);
Route::post('companies', [CompaniesController::class, "store"]);
Route::put('companies/{id}', [CompaniesController::class, "update"]);
Route::get('companies/{id}', [CompaniesController::class, "show"]);
Route::delete('companies/{id}', [CompaniesController::class, "delete"]);
Route::post('companies/login', [CompaniesController::class, "check"]);

Route::get('/companies/{id}/image', [CompaniesController::class, 'showImage']);
Route::post('/companies/{id}/image', [CompaniesController::class, 'updateImage']);


//rotas de vagas
Route::get('job_openings', [JobOpeningsController::class, "index"]);
Route::post('job_openings', [JobOpeningsController::class, "store"]);
Route::get('job_openings/{id}', [JobOpeningsController::class, 'show']);
Route::put('job_openings/{id}', [JobOpeningsController::class, "update"]);
Route::delete('job_openings/{id}', [JobOpeningsController::class, "delete"]);
Route::post('job_openings/login', [JobOpeningsController::class, "check"]);



//rotas de aplicações
Route::get('applications', [ApplicationsController::class, "index"]);
Route::post('applications', [ApplicationsController::class, "store"]);
Route::put('applications/{id}', [ApplicationsController::class, "update"]);
Route::get('applications/{id}', [ApplicationsController::class, "show"]);
Route::delete('applications/{id}', [ApplicationsController::class, "delete"]);
Route::post('applications/login', [ApplicationsController::class, "check"]);


