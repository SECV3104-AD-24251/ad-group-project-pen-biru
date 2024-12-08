<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
     /**
     * Display a listing of the complaints.
     */
    public function index(Request $request)
{
    $query = Complaint::query();

    // Filter by priority (if requested)
    if ($request->has('priority') && $request->priority) {
        $query->where('priority_level', $request->priority);
    }

    // Sort by priority
    if ($request->has('sort')) {
        $sortOrder = $request->sort === 'asc' ? 'asc' : 'desc';
        $query->orderByRaw("FIELD(priority_level, 'High', 'Medium', 'Low') $sortOrder");
    }

    $complaints = $query->get();
    $priorityLevels = ['High', 'Medium', 'Low'];

    return view('complaints.index', compact('complaints', 'priorityLevels'));
}

    /**
     * Assign a priority level to a complaint.
     */
    public function assignPriority(Request $request, $id)
    {
        $request->validate([
            'priority_level' => 'required|string|in:High,Medium,Low', // Validate priority level
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->priority_level = $request->priority_level;
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'Priority assigned successfully.');
    }












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
    
    public function showSubmitForm()
{
    return view('submit');
}

}

