<?php

namespace App\Http\Controllers;

use App\Models\ConditionAudit;
use Illuminate\Http\Request;

class ConditionAuditController extends Controller
{
    // Display the condition audit form
    public function index()
    {
        return view('condition');
    }

    // Handle the update condition request
    public function updateCondition(Request $request)
    {
        $validated = $request->validate([
            'room' => 'required|string',
            'resource' => 'required|string',
            'condition' => 'required|in:USABLE,UNUSABLE',
        ]);

        $resource = ConditionAudit::where('room', $validated['room'])
            ->where('resource', $validated['resource'])
            ->first();

        if ($resource) {
            $resource->update(['condition' => $validated['condition']]);
        } else {
            ConditionAudit::create($validated);
        }

        return response()->json(['message' => 'Resource condition updated successfully!']);
    }

    // Fetch the current condition of resources in a room
    public function getRoomResources(Request $request)
    {
        $validated = $request->validate([
            'room' => 'required|string',
        ]);

        $resources = ConditionAudit::where('room', $validated['room'])->get();

        return response()->json($resources);
    }
}
