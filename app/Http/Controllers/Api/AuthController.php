<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
     {
        $validated = $request->validate ([
            'username'=> ['required','string', 'max:255'],
            'email'=> ['required', 'string' , 'lowercase', 'email' , 'max:255', 'unique:users,email'],
            'password'=>['required', 'confirmed', Password::default()],
        ]);

        $user = User::create([
            'username'=> $validated['username'],
            'email'=> $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message'=>'Registration successful.',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email'=> $user->email,
            ],
        ],201);
    }

    public function login(Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('email', $validated['email'])->first();

        if(!$user|| !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message'=> "Email or password is incorrect",
            ], 401);
        }

        $token = $user->createToken('journal')->plainTextToken;

         return response()->json([
        'message' => 'Login successful.',
        'token' => $token,
        'user'=>[
            'id'=> $user->id,
            'username'=> $user->username,
            'email'=> $user->email
        ],
    ],200);
    }
}
