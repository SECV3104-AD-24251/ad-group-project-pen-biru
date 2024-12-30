<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimetableSlot;

class TimetableController extends Controller
{
    public function showTimetable(Request $request)
    {
        // Start the query for timetable slots
        $query = TimetableSlot::query();

        // Apply filter by block if specified in the request
        if ($request->has('block') && !empty($request->block)) {
            $query->where('block', $request->block);
        }

        // Fetch the filtered timetable slots
        $timetable = $query->get();

        // Return the view with the filtered data
        return view('timetable.index', compact('timetable'));
    }
}
