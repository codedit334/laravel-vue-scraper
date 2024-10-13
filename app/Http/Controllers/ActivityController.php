<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function getOrderedActivities(Request $request)
    {
        // Define standard activity cards
        $activities = [
            [
                'imageSrc' => "https://brandingo.net/storage/images/FLUlmnMHkeFtXjDZAVuFMd82O9BxiNKrcGEo4D0L.jpg",
                'title' => "Allo Bike: Cours d'apprentissage",
                'address' => 'MOSQUÉ HASSAN II Casablanca',
                'latitude' => '33.6082243',
                'longitude' => '-7.6324728',
                'price' => "200DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/obJbflRT4u4tuIOmxxYavNGyNkTYfUZmKdKTaipA.png",
                'title' => "Tanger BelVelo : Séance d'apprentissage",
                'address' => 'Tanger ,Maroc',
                'latitude' => '35.7642313',
                'longitude' => '-5.8429614',
                'price' => "150DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/7UYu7HyRSL2ZN8g4WfXx1VNIZM8yWUofNUsgktoO.png",
                'title' => "Tanger BelVelo : Cycling in the Forest 100% women",
                'address' => 'Tanger ,Maroc',
                'latitude' => '35.7642313',
                'longitude' => '-5.8429614',
                'price' => "130DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/8r2X6MuJk2hcB73TA1Y8fLxN2ZTnQljig8VBW5UH.jpg",
                'title' => "Bolt Fitness",
                'address' => 'Sidi maarouf , Casablanca',
                'latitude' => '33.5329119',
                'longitude' => '-7.6512693',
                'price' => "50.00 DH",
                'tags' => ['Fitness'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/0I513iWxjeeTrq0sxZxo8uYxjA27wLkamCPb1rRk.jpg",
                'title' => "K Boxing Club",
                'address' => 'Sidi Maarouf ,Casablanca',
                'latitude' => '33.5329119',
                'longitude' => '-7.6512693',
                'price' => "25.00 DH",
                'tags' => ['Boxing'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/B8y0CCIPRtumfQyoIhyCcF81hgBdsf60tRXP6Ycs.jpg",
                'title' => "WeFoot Terrain 5vs5 ( T4 )",
                'address' => 'Bouskoura , Casablanca',
                'latitude' => '33.456443',
                'longitude' => '-7.650666',
                'price' => "300.00 DH",
                'tags' => ['Football'],
            ],
        ];

        $user = Auth::user(); // Assuming the user is authenticated

        if ($user) {
            // User is logged in, score and sort activities based on interests
            $userInterests = json_decode($user->interests);
            $userInterestNames = array_map(function($interest) {
                return $interest->name;
            }, $userInterests);

            // Score and sort activities
            $scoredActivities = [];
            foreach ($activities as $activity) {
                $score = 0;
                foreach ($userInterests as $interest) {
                    if (in_array($interest->name, $activity['tags'])) {
                        $score++;
                    }
                }
                // Add score and index of the first matched interest for secondary sorting
                $firstInterestIndex = count($userInterestNames); // Default to a high number if no match is found
                foreach ($activity['tags'] as $tag) {
                    $interestIndex = array_search($tag, $userInterestNames);
                    if ($interestIndex !== false) {
                        $firstInterestIndex = $interestIndex;
                        break;
                    }
                }

                $scoredActivities[] = [
                    'activity' => $activity,
                    'score' => $score,
                    'first_interest_index' => $firstInterestIndex,
                ];
            }

            // Sort by score first, then by the order of the user's interests
            usort($scoredActivities, function ($a, $b) {
                // First sort by score
                $scoreComparison = $b['score'] <=> $a['score'];
                
                // If scores are equal, sort by the position of the first interest
                if ($scoreComparison === 0) {
                    return $a['first_interest_index'] <=> $b['first_interest_index'];
                }
                
                return $scoreComparison;
            });

            $sortedActivities = array_column($scoredActivities, 'activity');

            return response()->json(['activities' => $sortedActivities]);
        }

        // User is not logged in, return standard activities
        return response()->json(['activities' => $activities]);
    }
}