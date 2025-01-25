<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{    
    /**
     * Endpoint for create new user
     *
     * @param  mixed $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);
        
        return response()->json([
            'message' => 'Registration is successfully!',
            'user' => $user
        ], Response::HTTP_CREATED);
    }
}
