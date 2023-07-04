<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
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
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);

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
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
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
        // $user = $request->user();
        $user = Auth::user();

        // Validasi data yang dikirimkan oleh pengguna
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        // Memeriksa apakah password saat ini sesuai dengan yang ada di database
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password Salah.'],
            ]);
        }

        // Mengganti password sesuai dengan peran (role) yang sedang login
        if ($user->is_admin == true) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        } elseif ($user->is_admin == false) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return back()->with('password-success', 'Password telah berhasil diubah!');
    }

    // Mengubah data profil pengguna
    public function ubahProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'gender' => 'required|in:L,P',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->birth_year = $request->birth_year;
        $user->save();

        return redirect()->back()->with('profile-success', 'Profile has been updated successfully.');
    }

}
