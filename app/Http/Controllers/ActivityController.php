<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
     // New method to sort by proximity and interests
     public function getOrderedActivitiesByProximity(Request $request)
     {
        $activities = [
            [
                'imageSrc' => "https://brandingo.net/storage/images/FLUlmnMHkeFtXjDZAVuFMd82O9BxiNKrcGEo4D0L.jpg",
                'title' => "Allo Bike: Cours d'apprentissage",
                'address' => 'MOSQUÉ HASSAN II Casablanca',
                'latitude' => '33.60629',
                'longitude' => '-7.63353',
                'price' => "200DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/obJbflRT4u4tuIOmxxYavNGyNkTYfUZmKdKTaipA.png",
                'title' => "Tanger BelVelo : Séance d'apprentissage",
                'address' => 'Tanger, Maroc',
                'latitude' => '35.7642313',
                'longitude' => '-5.8429614',
                'price' => "150DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/7UYu7HyRSL2ZN8g4WfXx1VNIZM8yWUofNUsgktoO.png",
                'title' => "Tanger BelVelo : Cycling in the Forest 100% women",
                'address' => 'Tanger, Maroc',
                'latitude' => '35.7642313',
                'longitude' => '-5.8429614',
                'price' => "130DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/8r2X6MuJk2hcB73TA1Y8fLxN2ZTnQljig8VBW5UH.jpg",
                'title' => "Bolt Fitness",
                'address' => 'Sid Al Khadir, Casablanca',
                'latitude' => '33.57035',
                'longitude' => '-7.68165',
                'price' => "50.00 DH",
                'tags' => ['Fitness'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/0I513iWxjeeTrq0sxZxo8uYxjA27wLkamCPb1rRk.jpg",
                'title' => "K Boxing Club",
                'address' => 'Sidi Maarouf, Casablanca',
                'latitude' => '33.52482',
                'longitude' => '-7.65049',
                'price' => "25.00 DH",
                'tags' => ['Boxing'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/B8y0CCIPRtumfQyoIhyCcF81hgBdsf60tRXP6Ycs.jpg",
                'title' => "WeFoot Terrain 5vs5 ( T4 )",
                'address' => 'Hay Al Inara, Casablanca',
                'latitude' => '33.5478',
                'longitude' => '-7.60228',
                'price' => "300.00 DH",
                'tags' => ['Football'],
            ],
        ];
        
         $user = Auth::user(); // Assuming the user is authenticated
     
         if ($user) {
             // User is logged in, retrieve interests and location (latitude and longitude)
             $userLatitude = $user->latitude;
             $userLongitude = $user->longitude;
             $userInterests = json_decode($user->interests);
             $userInterestNames = array_map(function($interest) {
                 return $interest->name;
             }, $userInterests);
     
             // Score, calculate distance, and sort activities
             $scoredActivities = [];
             foreach ($activities as $activity) {
                 // Step 1: Score based on interests
                 $score = 0;
                 foreach ($userInterests as $interest) {
                     if (in_array($interest->name, $activity['tags'])) {
                         $score++;
                     }
                 }
     
                 // Step 2: Calculate proximity using Haversine formula
                 $distance = $this->calculateDistance(
                     $userLatitude,
                     $userLongitude,
                     $activity['latitude'],
                     $activity['longitude']
                 );
     
                 // Step 3: Secondary sorting based on user's interest
                 $firstInterestIndex = count($userInterestNames); // Default to a high number
                 foreach ($activity['tags'] as $tag) {
                     $interestIndex = array_search($tag, $userInterestNames);
                     if ($interestIndex !== false) {
                         $firstInterestIndex = $interestIndex; // Find the first matching interest index
                         break;
                     }
                 }
     
                 $scoredActivities[] = [
                     'activity' => $activity,
                     'score' => $score,
                     'first_interest_index' => $firstInterestIndex,
                     'distance' => $distance,
                 ];
             }
     
             usort($scoredActivities, function ($a, $b) {
                $scoreComparison = $b['score'] <=> $a['score'];
                
                // If scores are equal, sort by the position of the first interest
                if ($scoreComparison === 0) {
                    $interestComparison = $a['first_interest_index'] <=> $b['first_interest_index'];
                    
                    // If the first interest indices are also equal, sort by distance
                    if ($interestComparison === 0) {
                        return $a['distance'] <=> $b['distance']; // Lower distance is better
                    }
                    
                    return $interestComparison; // Return interest index comparison
                }
                
                return $scoreComparison; // Return score comparison
            });
     
             $sortedActivities = array_column($scoredActivities, 'activity');
     
             return response()->json(['activities' => $sortedActivities]);
         }
     
         // User is not logged in, return standard activities
         return response()->json(['activities' => $activities]);
     }
     
 
     // Helper function to calculate distance using the Haversine formula
     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
     {
         $earthRadius = 6371; // Radius of the earth in km
 
         $latDistance = deg2rad($lat2 - $lat1);
         $lonDistance = deg2rad($lon2 - $lon1);
 
         $a = sin($latDistance / 2) * sin($latDistance / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDistance / 2) * sin($lonDistance / 2);
 
         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
 
         $distance = $earthRadius * $c; // Distance in km
 
         return $distance;
     }
}