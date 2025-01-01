<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceBooking;

class MaintenanceBookingController extends Controller
{
        public function index()
    {
        $bookings = MaintenanceBooking::all();
        return view('maintenance-bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('maintenance-bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'task' => 'required|string|max:255',
        ]);

        MaintenanceBooking::create($request->all());

        return redirect()->route('maintenance-bookings.index')
                        ->with('success', 'Booking created successfully.');
    }

    //Approval or Disapproval Controller
    public function approve($id)
    {
        $booking = MaintenanceBooking::findOrFail($id);
        $booking->update(['booking_status' => 'approved']); // Update booking_status

        return redirect()->route('maintenance-bookings.status')->with('success', 'Booking approved successfully!');
    }

    public function disapprove($id)
    {
        $booking = MaintenanceBooking::findOrFail($id);
        $booking->update(['booking_status' => 'disapproved']); // Update booking_status

        return redirect()->route('maintenance-bookings.status')->with('success', 'Booking disapproved successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'booking_status' => 'required|in:approved,disapproved,pending',
        ]);

        $booking = MaintenanceBooking::findOrFail($id);
        $booking->update(['booking_status' => $request->booking_status]);

        return redirect()->route('maintenance-bookings.status')->with('success', 'Booking status updated successfully.');
    }

    public function showBookingForm()
{
    $complaints = Complaint::whereNotNull('priority')->get(); // Fetch complaints with priority set
    $bookings = MaintenanceBooking::all(); // Fetch existing bookings
    
    return view('maintenance.bookings', compact('complaints', 'bookings'));
}

}
