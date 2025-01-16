<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Models\Complaint;
use App\Models\MaintenanceBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TimetableSlot;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MaintenanceBookingController;
use App\Http\Controllers\ConflictController;
use App\Http\Controllers\CheckerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\ConditionAuditController;
use App\Http\Controllers\FeedbackController;
// Default route to the welcome page
Route::get('/', function () {
    return view('welcome');
});

//Route for login page
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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

//get rooms for drop down menu
Route::post('/fetch-rooms', [ComplaintController::class, 'fetchRooms'])->name('fetch.rooms');



//Route::resource('maintenance-bookings', MaintenanceBookingController::class);
Route::get('maintenance-bookings', function () {
    $bookings = MaintenanceBooking::orderBy('created_at', 'desc')->get(); // Fetch latest first
    $complaints = Complaint::where('status', 'pending')->get();
    return view('maintenance-bookings', compact('bookings', 'complaints'));
})->name('maintenance.bookings');


Route::post('maintenance-bookings', function (Request $request) {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'task' => 'required', // Resource Type
        'block_name' => 'required',
        'room' => 'required',
        'priority' => 'required',
    ]);

    MaintenanceBooking::create([
        'date' => $request->date,
        'time' => $request->time,
        'task' => $request->task, // Save resource_type as the task
        'block_name' => $request->block_name,
        'room' => $request->room,
        'priority' => $request->priority,
    ]);

    return redirect('maintenance-bookings');
});


// Route for viewing the booking status page
// Route::get('/maintenance-bookings/status', function () {
//     $pendingBookings = \App\Models\MaintenanceBooking::where('booking_status', 'pending')->get();
//     $history = \App\Models\MaintenanceBooking::whereIn('booking_status', ['approved', 'disapproved'])->get();

//     return view('booking-status', compact('pendingBookings', 'history'));
// })->name('maintenance-bookings.status');

// Route to approve a booking
Route::get('/maintenance-bookings/{id}/approve', [MaintenanceBookingController::class, 'approve'])
    ->name('maintenance-bookings.approve');

// Route to disapprove a booking
Route::get('/maintenance-bookings/{id}/disapprove', [MaintenanceBookingController::class, 'disapprove'])
    ->name('maintenance-bookings.disapprove');

// Route to update the booking status (from dropdown)
Route::post('/maintenance-bookings/{id}/update-status', [MaintenanceBookingController::class, 'updateStatus'])
    ->name('maintenance-bookings.updateStatus');


    // Default route to the timetable page with filtering
    Route::get('/timetable', [TimetableController::class, 'showTimetable'])->name('timetable.show');
    
    // Timetable Routes
    Route::get('/timetable/rooms', [TimetableController::class, 'showRooms'])->name('timetable.rooms');
    Route::get('/timetable/weekly', [TimetableController::class, 'showTimetable'])->name('timetable.weekly');
    Route::post('/timetable/book', [TimetableController::class, 'bookSlot'])->name('timetable.book');
    Route::post('/timetable/import', [TimetableController::class, 'import'])->name('timetable.import');
    
    Route::get('/conflict', [ConflictController::class, 'index'])->name('conflict.index');
    Route::get('/conflict/create', [ConflictController::class, 'create'])->name('conflict.create');

    Route::post('/conflict', [ConflictController::class, 'store'])->name('conflict.store');
    Route::delete('/conflict/{id}', [ConflictController::class, 'destroy'])->name('conflict.destroy');


    // Route to check suitability and display booking-status
    Route::get('/maintenance-bookings/status', [CheckerController::class, 'checkSuitability'])->name('maintenance-bookings.status');

    // Route for dropdown menu in booking-status
    Route::get('/get-classrooms-by-block', [TimetableController::class, 'getClassroomsByBlock']);
    Route::get('/get-filtered-timetable', [TimetableController::class, 'getFilteredTimetable'])->name('get.filtered.timetable');
    Route::get('/get-booking-timetable', [CheckerController::class, 'getBookingTimetable'])->name('get.booking.timetable');
    
    Route::get('/analytics', [AnalyticController::class, 'index'])->name('analytics.index');
    Route::get('/complaints/statistics', [ComplaintController::class, 'getComplaintStatistics']);


   /* Route::prefix('conflict')->name('conflict.')->group(function() {
        Route::get('/', [ConflictController::class, 'index'])->name('index');
        Route::get('/create', [ConflictController::class, 'create'])->name('create');
        Route::post('/', [ConflictController::class, 'store'])->name('store');
    });

Route::get('timetable', [TimetableController::class, 'index'])->name('timetable.index');
Route::get('timetable/edit/{id}', [TimetableController::class, 'edit'])->name('timetable.edit');
Route::put('timetable/update/{id}', [TimetableController::class, 'update'])->name('timetable.update');
*/


Route::get('/condition', [ConditionAuditController::class, 'index'])->name('conditionAudit');
Route::post('/update-condition', [ConditionAuditController::class, 'updateCondition'])->name('updateCondition');


Route::view('/feedback', 'feedback'); // Renders the feedback form page
Route::post('/submit-feedback', [FeedbackController::class, 'store']); // Handles form submission
Route::get('/feedback/statistics', [FeedbackController::class, 'statistics'])->name('feedback.statistics');

