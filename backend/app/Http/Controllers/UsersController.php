<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        return Users::all();
    }

    public function store(Request $req)
    {
        // Validação dos dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,recruiter,candidate',
            //'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Criação do usuário
        $user = Users::create([
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->role,
            'password' => Hash::make($req->password),

        ]);

        return response()->json([
            'status' => true,
            'message' => "Registation Success",
        ]);
    }

    public function update(Request $req)
    {
        $user = Users::find($req->id);

        $user->name = $req->name;

        $user->save();

        return response("Tudo certo", 200);
    }

    public function check(Request $req)
    {

        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            return response()->json([
                'status' => true,
                'message' => "Success",
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Fail"

        ]);
    }

    public function show($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function delete(Request $req)
    {
        $user = Users::find($req->id);

        $user->delete();
        return response("Usuário apagado", 200);
    }
}
