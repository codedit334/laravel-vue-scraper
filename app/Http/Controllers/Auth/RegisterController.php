<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{   
    public function geocode($address)
    {
        $apiKey = 'j6a6-fVxn_9InNCkWf_Y0M8n8GI6ovON9tiUxxhgd0U';
    
        $response = Http::get('https://geocode.search.hereapi.com/v1/geocode', [
            'q' => $address,
            'apiKey' => $apiKey,
        ]);
    
        return $response->json();
    }
    public function register(Request $request)
    {
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

        // Get latitude and longitude from HERE API
        $geocodeResponse = $this->geocode($request->address);

        // Check if the geocoding API returned valid results
        if (isset($geocodeResponse['items']) && count($geocodeResponse['items']) > 0) {
            
            $latitude = $geocodeResponse['items'][0]['position']['lat'];
            $longitude = $geocodeResponse['items'][0]['position']['lng'];
        } else {
            return response()->json(['error' => 'Unable to retrieve location data.'], 422);
        }
        
        
        // return response()->json(['message' => 'Successfully registered and logged in.', 'addressResult' => $adressResult], 200);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'interests' => json_encode($request->interests), // Store interests as JSON
            'address' => $request->address,
            'latitude' => $latitude,
            'longitude' => $longitude,
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