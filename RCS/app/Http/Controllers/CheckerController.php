<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceBooking;
use App\Models\TimetableSlot;

class CheckerController extends Controller
{
    public function checkSuitability()
    {
        $pendingBookings = MaintenanceBooking::where('booking_status', 'pending')->get();

        foreach ($pendingBookings as $booking) {
            $dayOfWeek = $booking->date->format('l'); // Convert date to weekday

            $conflict = TimetableSlot::where('block', $booking->block_name)
                ->where('room_name', $booking->room)
                ->where('day', $dayOfWeek)
                ->where(function ($query) use ($booking) {
                    $query->where(function ($q) use ($booking) {
                        $q->where('start_time', '<=', $booking->time->format('H:i'))
                            ->where('end_time', '>', $booking->time->format('H:i'));
                    })->orWhere(function ($q) use ($booking) {
                        $endTime = $booking->time->copy()->addMinutes(90)->format('H:i');
                        $q->where('start_time', '<', $endTime)
                            ->where('end_time', '>=', $endTime);
                    });
                })
                ->exists();

            $booking->is_suitable = !$conflict; // Add a temporary attribute for display
        }

        $history = MaintenanceBooking::whereIn('booking_status', ['approved', 'disapproved'])->get();

        // Fetch distinct dropdown data
        $blocks = TimetableSlot::distinct()->pluck('block');
        $classrooms = TimetableSlot::distinct()->pluck('room_name');

        return view('booking-status', compact('pendingBookings', 'history', 'blocks', 'classrooms'));
    }
    
    // Function to retrieve classroom based on block
    // public function getClassroomsByBlock(Request $request)
    // {
    //     $block = $request->block;

    //     // Fetch classrooms for the selected block
    //     $classrooms = TimetableSlot::where('block', $block)->distinct()->pluck('room_name');

    //     // Return the data as a JSON response
    //     return response()->json($classrooms);
    // }

    // public function getBookingTimetable(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'block' => 'required|string',
    //         'room_name' => 'required|string',
    //     ]);

    //     $block = $request->input('block');
    //     $roomName = $request->input('room_name');

    //     // Fetch timetable data based on block and classroom
    //     $timetable = TimetableSlot::where('block', $block)
    //         ->where('room_name', $roomName)
    //         ->get();

    //     return response()->json($timetable);
    // }
}
