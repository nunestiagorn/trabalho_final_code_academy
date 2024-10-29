<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    //
    public function index(){
        return Companies::all();
    }

    public function store(Request $req){
        Companies::create([
            "name" => $req->name
        ]);

        return response(["OK"], 200);
    }

    public function update(Request $req){
        $users = Companies::find($req->id);

        $users->name = $req->name;

        $users->save();

        return response("Tudo certo", 200);
    }

}
