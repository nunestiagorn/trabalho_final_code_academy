<?php

namespace App\Http\Controllers;

use App\Models\Job_openings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobOpeningsController extends Controller
{
    //'
    public function index(){
        return Job_openings::all();
    }

    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:300',
            'salary' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $opening = Job_openings::create([
            'name' => $req->name,
            'description' => $req->description,
            'salary' => $req->salary,
            'company_id' => $req->company_id,
            'recruiter_name' => $req->recruiter_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registrado com sucesso",
        ]);
    }

    public function update(Request $req){
        $opening = Job_openings::find($req->id);

        $opening->name = $req->name ?? $opening->name;
        $opening->description = $req->description ?? $opening->description;
        $opening->salary = $req->salary ?? $opening->salary;

        $opening->save();

        return response("Success", 200);
    }

    public function show($companyId) {
        $jobs = Job_openings::where('company_id', $companyId)->get();

        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'Nenhuma vaga encontrada para essa empresa'], 404);
        }

        return response()->json($jobs, 200);
    }

    public function delete(Request $req){
        $opening = Job_openings::find($req->id);

        if (!$opening) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }

        $opening->delete();

        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

}
