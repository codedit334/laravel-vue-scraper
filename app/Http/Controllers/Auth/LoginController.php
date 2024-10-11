<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $request->input('token'); 
        
        // If a token is provided, attempt to retrieve the user based on the token
    if (empty($credentials['password']) && !empty($token)) {
        try {
            // Attempt to authenticate using the token
            // $user = Auth::user(); 
            $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)->tokenable;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }
    }
    
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('Sportma')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Invalid login credentials.'], 401);
    }

    public function logout(Request $request)
    {
        // Revoke the user's current session
        $request->user()->tokens()->delete();
    
        // Store the message in the session
        $request->session()->flash('message', 'Successfully logged out.');
    
        // Redirect to the home page
        return redirect('/');
    }
}