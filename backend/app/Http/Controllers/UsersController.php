<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function index(){
        return Users::all();
    }

    public function store(Request $req){
        Users::create([
            "name" => $req->name
        ]);

        return response(["OK"], 200);
    }

    public function update(Request $req){
        $users = Users::find($req->id);

        $users->name = $req->name;

        $users->save();

        return response("Tudo certo", 200);
    }
}
