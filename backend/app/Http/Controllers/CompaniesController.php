<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    //
    public function index(){
        return Companies::all();
    }

    public function store(Request $req)
    {
        // Validação dos dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            //'cnpj' => 'required|string|max:20|unique:companies',
            'description' => 'required|string|max:500',
            //'password' => 'required|string|min:8|confirmed',
        ]);

        // Retorna erro caso a validação falhe
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Criação do registro
        $company = Companies::create([
            'name' => $req->name,
            'cnpj' => $req->cnpj,
            'password' => Hash::make($req->password),
            'description' => $req->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registration Success",
        ]);
    }



    public function update(Request $req){
        $company = Companies::find($req->id);

        $company->name = $req->name;
        $company->cnpj = $req->cnpj;
        $company->password = $req->password;
        $company->description = $req->description;

        $company->save();

        return response("Tudo certo", 200);
    }

    public function check(Request $request)
    {
            // Valida o campo `cnpj` recebido na requisição
            $credentials = $request->validate([
                'cnpj' => ['required', 'string', 'max:20'],
                'password' => ['required'],
            ]);
    
            // Procura por uma empresa com o CNPJ especificado
            $company = Companies::where('cnpj', $credentials['cnpj'])->first();
    
            if ($company) {
                // Caso a empresa exista, retorna informações sobre ela
                return response()->json([
                    'status' => true,
                    'message' => "Empresa encontrada.",
                    'company' => [
                        'id' => $company->id,
                        'name' => $company->name,
                        'cnpj' => $company->cnpj,
                        'description' => $company->description,
                    ]
                ], 200);
            }
    
            // Caso a empresa não seja encontrada
            return response()->json([
                'status' => false,
                'message' => "Empresa não encontrada."
        ], 404);
    }
    
    
       


    public function show($id)
    {
        $user = Companies::find($id);

        if (!$user) {
            return response()->json(['message' => 'Compania não encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function delete(Request $req)
    {
        $user = Companies::find($req->id);

        $user->delete();
        return response("Compania apagada", 200);
    }


}
