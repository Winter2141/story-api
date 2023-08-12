<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\Interfaces\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->service->doCreate($request->all());
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = $this->service->findByEmail($request->get('email'));
        $token = $user->createToken('authToken')->plainTextToken;
        $users = null;
        if($user->role === 1) {
            $users = $this->service->getUserList();
        }
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user, "users" => $users]);
    }

    /**
     * Log the user out (revoke the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
