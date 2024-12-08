<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function create()
    {
        // Pass options for dropdowns if necessary
        $blocks = ['Block A', 'Block B', 'Block C']; // Example blocks
        $resources = ['Projector', 'Chair', 'Table']; // Example resources

        return view('complaints.create', compact('blocks', 'resources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_name' => 'required|string',
            'room' => 'required|string',
            'resource_type' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Complaint::create($validated);

        return redirect()->route('complaints.create')->with('success', 'Complaint submitted successfully!');
    }
}

