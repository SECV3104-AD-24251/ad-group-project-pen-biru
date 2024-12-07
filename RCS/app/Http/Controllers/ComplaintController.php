<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function create()
    {
        // Example blocks and resources data
        $blocks = ['Block A', 'Block B', 'Block C'];
        $resources = ['Projector', 'Chair', 'Table'];

        // Fetch the latest statuses for display
        $statuses = ComplaintStatus::latest()->get();

        return view('complaints.create', compact('blocks', 'resources', 'statuses'));
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
        
        // Create the complaint
        $complaint = Complaint::create($validated);

        // Add an initial status record
        ComplaintStatus::create([
            'complaint_id' => $complaint->id,
            'status' => 'pending', // Initial status
        ]);

        return redirect()->route('complaints.create')->with('success', 'Complaint submitted successfully!');
    }

    public function showHistory($id)
    {
        // Retrieve the complaint and its status history
        $complaint = Complaint::findOrFail($id);
        $statuses = ComplaintStatus::where('complaint_id', $id)->get();

        // Return the correct view path
        return view('history', compact('complaint', 'statuses'));
    }
}
