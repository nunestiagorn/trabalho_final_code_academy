<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'image',
        'curriculum'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
