<?php

namespace App\Http\Controllers;

use App\Models\Applications;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    //
    public function index(){
        return Applications::all();
    }
}
