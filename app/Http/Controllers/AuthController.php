<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'oldInput' => $request->all(),
                'message' => 'Username atau password salah!'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function indexRegister()
    {
        return view('auth.register');
    }

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
            return response()->json([
                'oldInput' => $request->all(),
                'message' => $validator->errors()
            ], 422);
        }

        // Buat user baru
        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);

        return response()->json([
            'user' => $user,
            'message' => 'Registration successful'
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function pengaturan() {
        $user = Auth::user();
        return view('pengaturan', compact('user'));
    }

    public function pengaturanAdmin() {
        $user = Auth::user();
        return view('admin.pengaturan', compact('user'));
    }

    public function ubahPassword(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password_confirmation' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'oldInput' => $request->all(),
                'message' => $validator->errors()
            ], 422);
        } elseif (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'oldInput' => $request->all(),
                'message' => ['current_password' => ['Password saat ini salah.']]
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password telah berhasil diubah!'], 200);
    }


    public function ubahProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'gender' => 'required|in:L,P',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'user' => $user,
                'oldInput' => $request->all(),
                'errors' => $validator->errors()
            ], 422);
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->birth_year = $request->birth_year;
        $user->save();

        return response()->json([
            'message' => 'Profile telah berhasil diubah!',
            'user' => $user
        ], 200);
    }

}
