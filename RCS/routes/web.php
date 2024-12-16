<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Models\Complaint;

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

//Route to view resolved complaint
Route::get('/complaints/resolved', [ComplaintController::class, 'getResolvedComplaints']);

//Route to upload schedule
Route::get('/upload', [ComplaintController::class, 'showUploadPage'])->name('upload.page');
Route::post('/upload', [ComplaintController::class, 'importSchedule'])->name('upload.schedule');