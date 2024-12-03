<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Wrong email or password.'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token
        ],200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $request->bearerToken();

        if ($user) {
            $pisah = explode("|", $token);
            $tokens = PersonalAccessToken::find($pisah[0]);

            if(!is_null($tokens)) {
                $tokens->delete();
                return response()->json(['message' => "logout success"], 200);
            }
        }

        return response()->json(['message' => "Unauthenticated"], 401);
    }
    
}
