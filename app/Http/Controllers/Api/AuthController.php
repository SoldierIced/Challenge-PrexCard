<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validateLogin($request);
        try {

            if (!Auth::guard("web")->attempt($request->only('email', 'password'))) {
                return $this->sendResponse(null, 'Incorrect data', 'error', null, 401);
            }

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return $this->sendResponse(['token' => $token], 'Login successful');
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 500);
        }
    }

    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function register(Request $request)
    {
        $this->validateRegister($request);
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return $this->sendResponse([
                'user' => $user,
                'token' => $token,
            ], 'Registration successful', 'success');
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 500);
        }
    }

    public function validateRegister(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    }
}
