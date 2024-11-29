<?php

use Illuminate\Support\Facades\Route;
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

    if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        return abort(403, 'Invalid hash');
    }

    if (!$user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
    }

    return redirect(env('FRONTEND_URL') . '/login');

    
})->name('verification.verify');
