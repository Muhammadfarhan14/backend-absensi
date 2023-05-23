<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    #logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Token Berhasil Dihapus"
        ]);
    }

    public function logout_web(Request $request)
    {
        $request->session()->flush();
        Auth::user()->tokens()->delete();
        Auth::logout();
        return redirect()->route('login.web');
    }
    #endlogout

    #auth admin web
    public function login(Request $request)
    {
       $krendensil = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        $user->createToken($user->username)->plainTextToken;
        Auth::attempt($krendensil);
        Auth::user();
        return redirect()->route('dashboard');
    }
    #end auth admin web


    #auth app SiMor
    public function login_app(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan salah'],
            ]);
        }

        return $user->createToken($user->username)->plainTextToken;
    }
    #end auth app SiMor

    public function me()
    {
        $user = Auth::user();
        return response()->json([
            "message" => "data user yang login",
            "data" => $user
        ]);
    }

}
