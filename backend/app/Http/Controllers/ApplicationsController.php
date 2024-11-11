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

    public function store(Request $req){
        $application = new Applications;
        $application->recruiter_name = $req->recruiter_name;
        $application->save();

        return response("Success", 200);

    }

    public function update(Request $req){
        $application = Applications::find($req->id);
        $application->recruiter_name = $req->recruiter_name ?? $application->recruiter_name;

        $application->save();

        return response("Success", 200);
    }

    public function show(Request $req){
        $application = Applications::find($req->id);

        if (!$application) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }

        return response()->json($application, 200);
    }

    public function check(Request $req){
        $application = Applications::where('recruiter_name', $req->recruiter_name)->first();

        if (!$application) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }

        return response()->json($application, 200);
    }

    public function delete(Request $req){
        $application = Applications::find($req->id);

        if (!$application) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }

        $application->delete();

        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

}
