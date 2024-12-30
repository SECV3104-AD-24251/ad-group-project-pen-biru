<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Models\Complaint;
use App\Models\MaintenanceBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TimetableSlot;


// Default route to the welcome page
Route::get('/', function () {
    return view('welcome');
});

// Routes for creating and storing complaints
Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

// Staff Dashboard Route
Route::get('/staff-dashboard', [ComplaintController::class, 'index'])->name('staff.dashboard');

// Route to assign a priority level to a complaint
Route::post('/complaints/{id}/assign-priority', [ComplaintController::class, 'assignPriority'])->name('complaints.assignPriority');


Route::get('/complaints', function () {
    $query = Complaint::where('status', 'pending'); // Only show pending complaints

    // Apply filtering by priority (if requested)
    if (request()->has('priority') && request()->priority) {
        $query->where('priority', request()->priority);
    }

    // Apply sorting by priority
    if (request()->has('sort')) {
        $sortOrder = request()->sort === 'asc' ? 'asc' : 'desc';
        $query->orderByRaw("FIELD(LOWER(priority), 'low', 'medium', 'high') $sortOrder");
    }

    // Fetch the complaints
    $complaints = $query->get();

    // Define priority levels for the dropdown
    $priorityLevels = ['Low', 'Medium', 'High'];

    return view('complaints', compact('complaints', 'priorityLevels'));
})->name('complaints.index');


// Route to mark a complaint as resolved
Route::post('/complaints/{id}/resolve', function ($id) {
    $complaint = Complaint::findOrFail($id);
    $complaint->status = 'resolved';
    $complaint->save();

    return redirect()->route('staff.dashboard')->with('success', 'Complaint marked as resolved!');
})->name('complaints.resolve');

// Route to complaint status and history
Route::get('/complaints/{id}/history', [ComplaintController::class, 'showHistory'])->name('complaints.history');

//route to delete the complaint
Route::delete('/complaints/{id}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
//Route to get resolved complaint
Route::get('/complaints/resolved', [ComplaintController::class, 'getResolvedComplaints']);
//Route to get details
Route::get('/resource/details', [ComplaintController::class, 'fetchDetails'])->name('resource.details');

//Route to make priotity suggestion
Route::get('/complaints/show-suggest', [ComplaintController::class, 'showSuggest'])->name('complaints.showSuggest');

Route::resource('maintenance-bookings', MaintenanceBookingController::class);
Route::get('maintenance-bookings', function () {
    $bookings = MaintenanceBooking::all();
    $complaints = Complaint::where('status', 'pending')->get(); // Fetch pending complaints
    return view('maintenance-bookings', compact('bookings', 'complaints'));
});

Route::post('maintenance-bookings', function (Request $request) {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'task' => 'required', // Store task as a complaint ID
    ]);

    MaintenanceBooking::create([
        'date' => $request->date,
        'time' => $request->time,
        'task' => Complaint::find($request->task)->description, // Save task description
    ]);

    return redirect('maintenance-bookings');
});

Route::get('/timetable/rooms', [TimetableController::class, 'showRooms'])->name('timetable.rooms');
Route::get('/timetable/weekly', [TimetableController::class, 'showTimetable'])->name('timetable.weekly');
Route::post('/timetable/book', [TimetableController::class, 'bookSlot'])->name('timetable.book');
