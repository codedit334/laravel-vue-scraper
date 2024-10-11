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
        $user = Auth::user();
        
        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();
            // Optional: Log out the user if using session authentication
            Auth::logout();
            $user = Auth::user();
            return response()->json(['message' =>'Successfully logged out.', 'user' => $user]);
            
        }
        // Store the message in the session
        $request->session()->flash('message', 'Successfully logged out.');
    
        // Redirect to the home page
        return redirect('/');
    }
}