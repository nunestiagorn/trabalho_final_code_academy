<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobOpeningsController;
use App\Http\Controllers\ApplicationsController;
use Illuminate\Support\Facades\Route;

//rotas de usuários
Route::get('users', [UsersController::class, "index"]);
Route::post('users', [UsersController::class, "store"]);
Route::put('users/{id}', [UsersController::class, "update"]);
Route::get('users/{id}', [UsersController::class, "show"]);
Route::delete('users/{id}', [UsersController::class, "delete"]);
Route::post('users/login', [UsersController::class, "check"]);

//rotas de imagens de usuários
Route::get('/users/{id}/image', [UsersController::class, 'showImage']);
Route::post('/users/{id}/image', [UsersController::class, 'updateImage']);

//rotas de currículo de usuários
Route::get('/users/{id}/curriculum', [UsersController::class, 'showCurriculum']);
Route::post('/users/{id}/curriculum', [UsersController::class, 'updateCurriculum']);


//rotas de empresas
Route::get('companies', [CompaniesController::class, "index"]);
Route::post('companies', [CompaniesController::class, "store"]);
Route::put('companies/{id}', [CompaniesController::class, "update"]);
Route::get('companies/{id}', [CompaniesController::class, "show"]);
Route::delete('companies/{id}', [CompaniesController::class, "delete"]);
Route::post('companies/login', [CompaniesController::class, "check"]);

//rotas de imagens de empresas
Route::get('/users/{id}/image', [UsersController::class, 'showImage']);
Route::post('/users/{id}/image', [UsersController::class, 'updateImage']);


//rotas de vagas
Route::get('job_openings', [JobOpeningsController::class, "index"]);
Route::post('job_openings', [JobOpeningsController::class, "store"]);
Route::put('job_openings/{id}', [JobOpeningsController::class, "update"]);
Route::get('job_openings/{id}', [JobOpeningsController::class, 'show']);
Route::delete('job_openings/{id}', [JobOpeningsController::class, "delete"]);


//rotas de aplicações
Route::get('applications', [ApplicationsController::class, "index"]);
Route::post('applications', [ApplicationsController::class, "store"]);
Route::put('applications/{id}', [ApplicationsController::class, "update"]);
Route::get('applications/{id}', [ApplicationsController::class, "show"]);
Route::delete('applications/{id}', [ApplicationsController::class, "delete"]);
Route::post('applications/login', [ApplicationsController::class, "check"]);


// Rotas de usuários
Route::middleware('auth')->group(function () {
    Route::get('users', [UsersController::class, "index"]);
    Route::post('users', [UsersController::class, "store"]);
    Route::put('users/{id}', [UsersController::class, "update"]);
    Route::get('users/{id}', [UsersController::class, "show"]);
    Route::delete('users/{id}', [UsersController::class, "delete"]);
});

// Rota de login de usuário
Route::post('users/login', [UsersController::class, "check"]);

// Rotas de imagens de usuários
Route::middleware('auth')->group(function () {
    Route::get('/users/{id}/image', [UsersController::class, 'showImage']);
    Route::post('/users/{id}/image', [UsersController::class, 'updateImage']);
});

// Rotas de currículo de usuários
Route::middleware('auth')->group(function () {
    Route::get('/users/{id}/curriculum', [UsersController::class, 'showCurriculum']);
    Route::post('/users/{id}/curriculum', [UsersController::class, 'updateCurriculum']);
});

// Rotas de empresas
Route::middleware('auth:company')->group(function () {
    Route::get('companies', [CompaniesController::class, "index"]);
    Route::post('companies', [CompaniesController::class, "store"]);
    Route::put('companies/{id}', [CompaniesController::class, "update"]);
    Route::get('companies/{id}', [CompaniesController::class, "show"]);
    Route::delete('companies/{id}', [CompaniesController::class, "delete"]);
});

// Rota de login de empresa
Route::post('companies/login', [CompaniesController::class, "check"]);

// Rotas de imagens de empresas
Route::middleware('auth:company')->group(function () {
    Route::get('/companies/{id}/image', [CompaniesController::class, 'showImage']);
    Route::post('/companies/{id}/image', [CompaniesController::class, 'updateImage']);
});

// Rotas de vagas
Route::middleware('auth')->group(function () {
    Route::get('job_openings', [JobOpeningsController::class, "index"]);
    Route::post('job_openings', [JobOpeningsController::class, "store"]);
    Route::put('job_openings/{id}', [JobOpeningsController::class, "update"]);
    Route::get('job_openings/{id}', [JobOpeningsController::class, 'show']);
    Route::delete('job_openings/{id}', [JobOpeningsController::class, "delete"]);
});

// Rotas de aplicações
Route::middleware('auth')->group(function () {
    Route::get('applications', [ApplicationsController::class, "index"]);
    Route::post('applications', [ApplicationsController::class, "store"]);
    Route::put('applications/{id}', [ApplicationsController::class, "update"]);
    Route::get('applications/{id}', [ApplicationsController::class, "show"]);
    Route::delete('applications/{id}', [ApplicationsController::class, "delete"]);
});

// Rota de login de aplicação
Route::post('applications/login', [ApplicationsController::class, "check"]);
