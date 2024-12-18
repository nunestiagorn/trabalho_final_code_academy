<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'password',
        'description',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
