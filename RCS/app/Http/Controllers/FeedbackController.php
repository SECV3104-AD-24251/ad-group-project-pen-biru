<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Store feedback
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'resource_availability' => 'required|integer|min:1|max:5',
            'resource_quality' => 'required|integer|min:1|max:5',
            'ease_of_reporting' => 'required|integer|min:1|max:5',
            'ease_of_use' => 'required|integer|min:1|max:5',
            'response_time' => 'required|integer|min:1|max:5',
            'clarity_of_process' => 'required|integer|min:1|max:5',
            'overall_experience' => 'required|integer|min:1|max:5',
            'suggestions' => 'nullable|string|max:1000',
        ]);

        // Store feedback in the database
        Feedback::create($validated);

        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }

    public function statistics()
    {
        // Calculate average ratings for each feedback category
        $metrics = [
            'Resource Availability' => Feedback::avg('resource_availability'),
            'Resource Quality' => Feedback::avg('resource_quality'),
            'Ease of Reporting' => Feedback::avg('ease_of_reporting'),
            'Ease of Use' => Feedback::avg('ease_of_use'),
            'Response Time' => Feedback::avg('response_time'),
            'Clarity of Process' => Feedback::avg('clarity_of_process'),
            'Overall Experience' => Feedback::avg('overall_experience'),
        ];

        // Fetch a random suggestion
        $randomSuggestion = Feedback::inRandomOrder()->value('suggestions');

        return response()->json([
            'metrics' => $metrics,
            'random_suggestion' => $randomSuggestion,
        ]);
    }

    
}
