<?php

namespace App\Http\Controllers;

use App\Models\Applications;
use App\Models\Job_openings;
use Illuminate\Http\Request;


class ApplicationsController extends Controller
{
    //
    public function index(Request $req)
    {

        $applications = Applications::where('opening_id', $req->opening_id)->get();

        $applicationsWithJobDetails = $applications->map(function($application) {
            $jobOpening = Job_openings::find($application->opening_id);
            if ($jobOpening) {
                $application->job_name = $jobOpening->name;
                $application->job_description = $jobOpening->description;
            }
            return $application;
        });

        return response()->json($applicationsWithJobDetails, 200);
    }


    //^ estudar melhor o código pra refatoração

    public function store(Request $req){
        $application = new Applications;
        $application->user_id = $req->user_id;
        $application->company_id = $req->company_id;
        $application->recruiter_name = $req->recruiter_name;
        $application->opening_id = $req->opening_id;
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
