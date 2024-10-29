<?php

namespace App\Http\Controllers;

use App\Models\Job_openings;
use Illuminate\Http\Request;


class JobOpeningsController extends Controller
{
    //
    public function index(){
        return Job_openings::all();
    }

    public function store(Request $req){
        Job_openings::create([
            "name" => $req->name
        ]);

        return response(["OK"], 200);
    }

    public function update(Request $req){
        $users = Job_openings::find($req->id);

        $users->name = $req->name;

        $users->save();

        return response("Tudo certo", 200);
    }

}
