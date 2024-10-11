<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function getOrderedActivities(Request $request)
    {
        // Fetch user interests
        $user = $request->user(); // Assuming the user is authenticated
        $userInterests = json_decode($user->interests);

        // Define activity cards
        $activities = [
            // Your activity data goes here
        ];

        // Score and sort activities (as explained earlier)
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
}