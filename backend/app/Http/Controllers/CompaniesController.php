<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    //
    public function index()
    {
        return Companies::all();
    }

    public function store(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:20|unique:companies',
            'description' => 'required|string|max:500',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('cnpj')) {
                return response()->json([
                    'status' => false,
                    'message' => 'cnpj já está cadastrado no sistema.',
                ], 400);
            }

            return response()->json($validator->errors(), 400);
        }

        $imagePath = null;

        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('companies', 'public');
        }

        $company = Companies::create([
            'name' => $req->name,
            'cnpj' => $req->cnpj,
            'password' => Hash::make($req->password),
            'description' => $req->description,
            'recruiter_name' => $req->recruiter_name ?? 'Recrutador',
            'image' => $imagePath
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registration Success",
            'company' => $company,
        ]);
    }



    public function update(Request $req)
    {
        $company = Companies::find($req->id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        $company->name = $req->name ?? $company->name;
        $company->cnpj = $req->cnpj ?? $company->cnpj;
        $company->description = $req->description ?? $company->description;
        $company->recruiter_name = $req->recruiter_name ?? $company->recruiter_name;


        if ($req->has('password') && !empty($req->password)) {
            $company->password = Hash::make($req->password);
        }


        if ($req->hasFile('image')) {
            if ($company->image && Storage::disk('public')->exists($company->image)) {
                Storage::disk('public')->delete($company->image);
            }

            $company->image = $req->file('image')->store('companies', 'public');
        }

        $company->save();

        return response()->json([
            'status' => true,
            'message' => 'Company updated successfully',
            'company' => $company,
        ]);
    }

    public function check(Request $request)
    {

        $credentials = $request->validate([
            'cnpj' => ['required', 'string', 'max:20'],
            'password' => ['required'],
        ]);


        $company = Companies::where('cnpj', $credentials['cnpj'])->first();

        if ($company && Hash::check($credentials['password'], $company->password)) {

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


        return response()->json([
            'status' => false,
            'message' => "Empresa não encontrada."
        ], 404);
    }


    public function show($id)
    {
        $company = Companies::find($id);

        if (!$company) {
            return response()->json(['message' => 'Compania não encontrado'], 404);
        }

        return response()->json($company, 200);
    }

    public function delete(Request $req)
    {
        $company = Companies::find($req->id);

        if (!$company) {
            return response()->json(['message' => 'Compania não encontrada'], 404);
        }

        $company->delete();

        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

    public function showImage($id)
    {
        $company = Companies::find($id);

        if (!$company || !$company->image) {
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        return response()->file(storage_path('app/public/' . $company->image));
    }

    public function updateImage(Request $req, $id)
    {
        $company = Companies::find($id);

        if (!$company) {
            return response()->json(['message' => 'Empresa não encontrada'], 404);
        }

        $validator = Validator::make($req->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($company->image) {
            Storage::disk('public')->delete($company->image);
        }

        $imagePath = $req->file('image')->store('companies', 'public');
        $company->image = $imagePath;
        $company->save();

        return response()->json([
            'message' => 'Imagem atualizada com sucesso!',
            'image_url' => asset('storage/' . $imagePath),
        ], 200);
    }
}
