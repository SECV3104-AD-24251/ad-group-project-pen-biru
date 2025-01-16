<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function index()
    {
        return view('analytic'); // This will load the `analytic.blade.php` template

        // Fetch all feedback
        $feedbacks = Feedback::all();

        // Calculate average ratings
        $averageRatings = [
            'resource_availability' => round($feedbacks->avg('resource_availability'), 2),
            'resource_quality' => round($feedbacks->avg('resource_quality'), 2),
            'ease_of_reporting' => round($feedbacks->avg('ease_of_reporting'), 2),
            'ease_of_use' => round($feedbacks->avg('ease_of_use'), 2),
            'response_time' => round($feedbacks->avg('response_time'), 2),
            'clarity_of_process' => round($feedbacks->avg('clarity_of_process'), 2),
            'overall_experience' => round($feedbacks->avg('overall_experience'), 2),
        ];

        // Fetch a random suggestion
        $randomSuggestion = $feedbacks->whereNotNull('suggestions')->random()->suggestions ?? 'No suggestions available';

        return view('analytic', compact('averageRatings', 'randomSuggestion'));
    }
}
