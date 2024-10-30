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
        $company = Companies::find($req->id);

        $company->name = $req->name;

        $company->save();

        return response("Tudo certo", 200);
    }

}
