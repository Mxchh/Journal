<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Admin access granted'
        ]);
    }

    public function show(Request $request, User $user)
    {
        abort_unless($request->user()->id === $user->id, 403);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'profile_photo' => $user->profile_photo,
            ],
        ], 200);
    }

    public function updateProfile(Request $request, User $user)
    {
        abort_unless($request->user()->id === $user->id, 403);

        $data = $request->validate([
            'username' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['sometimes','required', 'confirmed', Password::default()],
            'profile_photo'=> ['sometimes', 'image', 'max:2048'],
        ]);
        $user->fill(collect($data)->except('password')->all());
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
                if($request->hasFile('profile_photo')) {
            if($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $request
            ->file('profile_photo')
            ->store('profile_photo', 'public');
        }

        $user->save();
        return response()->json([
            'message' => 'User profile successfully updated!',
            'user' => $user->only('id', 'username', 'email', 'role', 'profile_photo'),
        ], 200);
    }
}
