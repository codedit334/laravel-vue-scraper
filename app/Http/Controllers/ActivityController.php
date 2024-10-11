<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
                'price' => "200DH",
                'tags' => ['Cycling'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/8r2X6MuJk2hcB73TA1Y8fLxN2ZTnQljig8VBW5UH.jpg",
                'title' => "Bolt Fitness",
                'price' => "50.00 DH",
                'tags' => ['Fitness'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/0I513iWxjeeTrq0sxZxo8uYxjA27wLkamCPb1rRk.jpg",
                'title' => "K Boxing Club",
                'price' => "25.00 DH",
                'tags' => ['Boxing'],
            ],
            [
                'imageSrc' => "https://brandingo.net/storage/images/B8y0CCIPRtumfQyoIhyCcF81hgBdsf60tRXP6Ycs.jpg",
                'title' => "WeFoot Terrain 5vs5 ( T4 )",
                'price' => "300.00 DH",
                'tags' => ['Football'],
            ],
        ];

        $user = Auth::user(); // Assuming the user is authenticated

        if ($user) {
            // User is logged in, score and sort activities based on interests
            $userInterests = json_decode($user->interests);

            // Score and sort activities
            $scoredActivities = [];
            foreach ($activities as $activity) {
                $score = 0;
                foreach ($userInterests as $interest) {
                    if (in_array($interest->name, $activity['tags'])) {
                        $score++;
                    }
                }
                $scoredActivities[] = [
                    'activity' => $activity,
                    'score' => $score,
                ];
            }

            usort($scoredActivities, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            $sortedActivities = array_column($scoredActivities, 'activity');

            return response()->json(['activities' => $sortedActivities]);
        }

        // User is not logged in, return standard activities
        return response()->json(['activities' => $activities]);
    }
}