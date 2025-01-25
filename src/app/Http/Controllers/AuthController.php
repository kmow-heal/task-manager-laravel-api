<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }

    /**
     * Endpoint for get access token.
     *
     * @param  mixed $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'Logged in successfully',
                'token' => $token,
            ]);
    }
    
    /**
     * Endpoint for delete all access tokens
     *
     * @param  mixed $request
     * @return void
     * @authenticated
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out!'
        ], Response::HTTP_OK);
    }
}
