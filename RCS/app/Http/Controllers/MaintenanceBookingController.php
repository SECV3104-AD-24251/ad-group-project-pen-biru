<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
