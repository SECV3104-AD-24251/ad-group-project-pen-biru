<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimetableSlot; // Import the model

class TimetableController extends Controller
{
        public function showRooms()
    {
        $rooms = TimetableSlot::select('room_name')->distinct()->get();
        return view('timetable.rooms', compact('rooms'));
    }

        public function showTimetable(Request $request)
    {
        $room = $request->room;
        $week = $request->week;

        // Calculate start and end date of the selected week
        $startOfWeek = now()->startOfWeek()->addWeeks($week - 1);
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $timetable = TimetableSlot::where('room_name', $room)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date')
            ->get();

        return view('timetable.weekly', compact('room', 'timetable'));
    }

        public function bookSlot(Request $request)
    {
        $validated = $request->validate([
            'room' => 'required|string',
            'date' => 'required|date',
            'slot' => 'required|in:morning,evening',
            'description' => 'nullable|string',
        ]);

        $slot = TimetableSlot::where('room_name', $validated['room'])
            ->where('date', $validated['date'])
            ->where('slot', $validated['slot'])
            ->first();

        if (!$slot || $slot->status == 'booked') {
            return back()->with('error', 'Slot is already booked.');
        }

        $slot->update([
            'description' => $validated['description'],
            'status' => 'booked',
        ]);

        return back()->with('success', 'Slot booked successfully.');
    }



}
