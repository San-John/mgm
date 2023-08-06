<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->sendError('Email or password is incorrect!');
        }
        return $this->respondWithToken($token);
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return $this->respondWithToken($token);
    }
    public function logout()
    {
        Auth::logout();
        return $this->sendResponse(null, 'Logout success!', 0, 200);
    }
    public function userProfile() {
        return response()->json(auth()->user());
    }
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
    protected function respondWithToken($token) {
        $data = [
            'Authorization' => [
                'token' => $token,
                'type' => auth()->user()->role,
                'expires_in' => auth()->factory()->getTTL() * 30, //todo: 1month
            ]
        ];
        return $this->sendResponse($data, 0, 201);
    }
}
