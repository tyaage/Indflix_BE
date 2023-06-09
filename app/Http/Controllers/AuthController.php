<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:L,P',
            'birth_year' => 'required|date_format:Y',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buat user baru
        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);

        return response()->json(['message' => 'Registration successful', 'user' => $user], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_admin) {
                return response()->json(['message' => 'Admin login successful'], 200);
            } else {
                return response()->json(['message' => 'User login successful'], 200);
            }
        } else {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }
    }

}
