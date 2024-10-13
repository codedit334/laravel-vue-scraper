<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{   
    public function register(Request $request)
    {
        $geocoder = new \OpenCage\Geocoder\Geocoder('4cf772a35564449eb67f3673c61f1e6b');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'gender' => 'required|string|max:255',
            'interests' => 'required|array', // Add interests validation
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $adressResult = $geocoder->geocode($request->address);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'interests' => json_encode($request->interests), // Store interests as JSON
            'address' => $request->address,
            'latitude' => $request->latitude = $adressResult[0]['geometry']['lat'],
            'longitude' => $request->longitude = $adressResult[0]['geometry']['lng'],
            
        ]);
        
        Auth::login($user);

            // Create a new token for the user
        $token = $user->createToken('Sportma')->plainTextToken;

        // Return the token and redirect the user
        return response()->json([
            'message' => 'Successfully registered and logged in.',
            'token' => $token,
            'user' => $user,
        ]);
    }
}