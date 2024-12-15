<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ComplaintHistory;


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
                $query->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low') $sortOrder");
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
        // Fetch all complaints (or apply any necessary filtering)
        $complaints = Complaint::all(); // Fetching all complaints to display in the table
        // Pass options for dropdowns if necessary
        $blocks = ['Block A', 'Block B', 'Block C']; // Example blocks
        $resources = ['Projector', 'Chair', 'Table']; // Example resources

        return view('complaints.create', compact('blocks', 'resources', 'complaints'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'block_name' => 'required|string',
            'room' => 'required|string',
            'resource_type' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle the image upload if it exists
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Create the complaint and assign it to a variable
        $complaint = Complaint::create($validated);
        
        // Create a history entry for the newly created complaint
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,   // Use the newly created complaint's ID
            'status' => 'Pending',               // Set the initial status
            'remarks' => 'Complaint submitted',  // Set initial remarks
            'changed_at' => now(),               // Timestamp of when the status was changed
        ]);

        // Redirect back with a success message
        return redirect()->route('complaints.create')->with('success', 'Complaint submitted successfully!');
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
        return view('partials.history', compact('complaint'));
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

}

