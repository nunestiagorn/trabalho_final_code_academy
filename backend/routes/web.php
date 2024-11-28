<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::find($id);

    if (!$user) {
        return abort(404, 'User not found');
    }

    // Validar o hash do e-mail
    if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        return abort(403, 'Invalid hash');
    }

    // Atualizar o campo email_verified_at
    if (!$user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
    }

    // Redirecionar ao frontend
    return redirect(env('FRONTEND_URL') . '/login');

    
})->name('verification.verify');
