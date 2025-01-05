<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimetableSlot;
use Illuminate\Support\Facades\DB;

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

    public function getFilteredTimetable(Request $request)
    {
        // Validate the input
        $request->validate([
            'block' => 'required|string',
            'room_name' => 'required|string',
        ]);

        $block = $request->input('block');
        $roomName = $request->input('room_name');

        // Fetch timetable data based on the selected block and classroom
        $timetable = TimetableSlot::where('block', $block)
            ->where('room_name', $roomName)
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        return response()->json($timetable);
    }

    public function getClassroomsByBlock(Request $request)
    {
        $block = $request->input('block');

        if (!$block) {
            return response()->json(['error' => 'Block is required'], 400);
        }

        $classrooms = TimetableSlot::where('block', $block)
            ->distinct()
            ->pluck('room_name');

        return response()->json($classrooms);
    }
}
