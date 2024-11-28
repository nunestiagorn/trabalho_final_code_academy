<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        return Users::all();
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,recruiter,candidate',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('email')) {
                return response()->json([
                    'status' => false,
                    'message' => 'email já está cadastrado no sistema.',
                ], 400);
            }

            return response()->json($validator->errors(), 400);
        }


        $imagePath = null;
        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('users', 'public');
        }

        $user = Users::create([
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->role,
            'password' => Hash::make($req->password),
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registration Success",
            'user' => $user,
        ]);
    }


    public function check(Request $req)
    {
        $credentials = $req->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'message' => 'Credenciais inválidas'], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Login realizado com sucesso',
            'user' => $user,
        ]);
    }

    public function update(Request $req)
    {
        $user = Users::find($req->id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $validator = Validator::make($req->all(), [
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($req->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $req->file('image')->store('users', 'public');
        }

        $user->name = $req->name ?? $user->name;
        $user->email = $req->email ?? $user->email;
        $user->image = $req->image ?? $user->image;
        if ($req->filled('password')) {
            $user->password = Hash::make($req->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user,
        ], 200);
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

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

    public function showImage($id)
    {
        $user = Users::find($id);

        if (!$user || !$user->image) {
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        $filePath = $user->image;

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['message' => 'Arquivo não encontrado no servidor'], 404);
        }

        return response()->file(storage_path('app/public/' . $filePath));
    }

    public function updateImage(Request $req, $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $validator = Validator::make($req->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($user->image) {

            Storage::disk('public')->delete($user->image);
        }

        $imagePath = $req->file('image')->store('users', 'public');
        $user->image = $imagePath;
        $user->save();

        return response()->json([
            'message' => 'Imagem atualizada com sucesso!',
            'image_url' => asset('storage/' . $imagePath),
        ], 200);
    }
}
