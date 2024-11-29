<?php

namespace App\Services;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function getAllUsers()
    {
        return Users::all();
    }

    public function storeUser($data)
    {
    
        $validator = Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,recruiter,candidate',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'curriculum' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('email')) {
                return [
                    'status' => false,
                    'message' => 'email já está cadastrado no sistema.',
                    'code' => 400,
                ];
            }

            return [
                'status' => false,
                'message' => $validator->errors(),
                'code' => 400,
            ];
        }

        $imagePath = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $data['image']->store('users', 'public');
        }

        
        $user = Users::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'image' => $imagePath,
        ]);

        event(new Registered($user));

        return [
            'status' => true,
            'message' => "Registration Success",
            'user' => $user,
            'code' => 201,
        ];
    }
}
