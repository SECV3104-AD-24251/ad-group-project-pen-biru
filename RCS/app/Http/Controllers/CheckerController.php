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

        return view('booking-status', compact('pendingBookings', 'history'));
    }
}
