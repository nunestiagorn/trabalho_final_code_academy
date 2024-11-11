<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_openings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_id',
        'recruiter_name',
    ];
}
