<?php

namespace App\Http\Controllers;

use App\Models\Conflict;
use Illuminate\Http\Request;

class ConflictController extends Controller
{
    public function index()
    {
        // Fetch all conflicts from the database to display them
        $conflicts = Conflict::all();
        return view('conflict', compact('conflicts'));
    }

    public function create()
    {
        // Return the view for creating a new conflict
        return view('createConflict');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'room' => 'required|string',
            'description' => 'required|string|max:255',
        ]);

        // Store the new conflict in the database
        Conflict::create($request->all());

        // Redirect back with success message
        return redirect()->route('conflict.index')->with('success', 'Conflict recorded successfully!');
    }
}
