<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ComplaintHistory;
use App\Models\ResourceDetail;
use App\Models\TimetableSlot;

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
        $query->where('priority', $request->priority);
    }

    // Sort by priority
    if ($request->has('sort')) {
        $sortOrder = $request->sort === 'asc' ? 'asc' : 'desc';
        // Use FIELD to sort by the custom priority order
        $query->orderByRaw("FIELD(LOWER(priority), 'low', 'medium', 'high') $sortOrder");

    }

    // Fetch complaints based on the filters and sorting
    $complaints = $query->get();

    // Define priority levels for dropdown filter in the view
    $priorityLevels = ['Low', 'Medium', 'High'];

    return view('complaints.index', compact('complaints', 'priorityLevels'));
}


    /**
     * Assign a priority level to a complaint.
     */
    public function assignPriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|string|in:High,Medium,Low', // Validate priority level
        ]);

        $complaint = Complaint::findOrFail($id);
        $oldPriority = $complaint->priority;

        // Update the complaint's priority
        $complaint->priority = $request->priority;
        $complaint->save();

        // Log the change in history
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $complaint->status,
            'remarks' => "Priority updated from $oldPriority to {$complaint->priority}",
            'changed_at' => now(),
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Priority updated successfully.');
    }



    public function create()
    {
        $blocks = TimetableSlot::distinct()->pluck('block');
        $resources = ['Projector', 'Chair', 'Table', 'PC', 'Monitor', 'Network'];
        $complaints = Complaint::all();
        $details = ResourceDetail::all(); // Fetch all possible resource details

        return view('complaints.create', compact('blocks', 'resources', 'complaints', 'details'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'block_name' => 'required|string',
            'room' => 'required|string',
            'resource_type' => 'required|string',
            'details' => 'required|integer', // This will be the ID from resource_details table
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Fetch severity from ResourceDetail based on the selected 'details' ID
        $resourceDetail = ResourceDetail::find($validated['details']);
        if (!$resourceDetail) {
            return back()->withErrors('Invalid resource details selection.');
        }

        // Add severity to the validated data
        $validated['severity'] = $resourceDetail->severity;

        // Handle the image upload if it exists
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Create the complaint
        $complaint = Complaint::create([
            'block_name' => $validated['block_name'],
            'room' => $validated['room'],
            'resource_type' => $validated['resource_type'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? null,
            'severity' => $validated['severity'],
            'details' => $validated['details'], // Save the detail ID as a reference
        ]);

        // Create a history entry for the newly created complaint
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => 'Pending',
            'remarks' => 'Complaint submitted',
            'changed_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->route('complaints.create')->with('success', 'Complaint submitted successfully!');
    }

    public function fetchRooms(Request $request)
    {
        $block = $request->input('block');
    
        // Fetch rooms for the selected block
        $rooms = TimetableSlot::where('block', $block)->distinct()->pluck('room_name');
    
        return response()->json($rooms);
    }

    
    public function showSubmitForm()
{
    return view('submit');
}

/*-------------------------------------------------------------------*/
    // Update status and add history
    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|string',  // Validate the new status
            'remarks' => 'nullable|string', // Optional remarks
        ]);

        // Find the complaint by ID
        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;

        // Update the status of the complaint
        $complaint->status = $request->input('status');
        $complaint->save();

        // Create history
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,  // Link the history to the complaint
            'status' => $request->input('status'),
            'remarks' => $request->input('remarks', "Updated from $oldStatus to " . $request->input('status')),
            'changed_at' => now(), // Store the time of the change
        ]);

        return redirect()->back()->with('success', 'Status updated and history recorded.');
    }
    
    //show history
    public function showHistory($id)
    {
        $complaint = Complaint::with('histories')->findOrFail($id);
        return view('partials.history_table', compact('complaint'))->render();
    }


    //delete button
    public function destroy($id)
    {
        // Find the complaint
        $complaint = Complaint::findOrFail($id);

        // Delete associated histories
        ComplaintHistory::where('complaint_id', $complaint->id)->delete();

        // Delete the complaint itself
        $complaint->delete();

        return redirect()->route('complaints.create')->with('success', 'Complaint deleted successfully.');
    }

    public function getResolvedComplaints()
    {
        $resolvedComplaints = Complaint::where('status', 'resolved')->get();

        return response()->json($resolvedComplaints);

        // Ensure priority defaults to 'Low' if it's not set
        $complaints = Complaint::where('status', 'resolved')
        ->get()
        ->map(function ($complaint) {
            $complaint->priority = $complaint->priority ?? 'N/A';
            return $complaint;
        });

        return response()->json($complaints);

    }

    /*-------------------------------------------------------------------*/
    //Fetch details for severity level
    public function fetchDetails(Request $request)
    {
        $resourceType = $request->input('resource_type');
        
        // Fetch the relevant resource details
        $details = ResourceDetail::where('resource_type', $resourceType)->get(['id', 'detail', 'severity']);
        
        return response()->json($details);
    }
    
    //Pass Data to View to vbe process and display priority suggestion
    // Controller
    public function showSuggest()
    {
        $complaints = Complaint::with('resourceDetail')->get(); // Eager load the related resourceDetail

        // Define priority levels based on severity
        foreach ($complaints as $complaint) {
            $severity = $complaint->resourceDetail->severity ?? null; // Fetch severity from the related resourceDetail
            
            if ($severity == 1) {
                $complaint->suggested_priority = 'Low';
            } elseif ($severity == 2) {
                $complaint->suggested_priority = 'Medium';
            } elseif ($severity == 3) {
                $complaint->suggested_priority = 'High';
            } else {
                $complaint->suggested_priority = 'Not Available';
            }
        }

        $priorityLevels = ['Low', 'Medium', 'High']; // Define priority levels

        return view('staff-dashboard.index', compact('complaints', 'priorityLevels'));
    }

    public function getComplaintStatistics()
    {
        $resolvedCount = Complaint::where('status', 'resolved')->count();
        $unresolvedCount = Complaint::where('status', '!=', 'resolved')->count();
    
        return response()->json([
            'resolved' => $resolvedCount,
            'unresolved' => $unresolvedCount,
        ]);
    }
    
}



