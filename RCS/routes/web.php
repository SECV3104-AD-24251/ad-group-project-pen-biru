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
Route::get('/priority', [ComplaintController::class, 'index'])->name('complaints.index');


// Route to display complaints list (only pending complaints are shown)
Route::get('/complaints', function () {
    $complaints = Complaint::where('status', 'pending')->get();
    return view('complaints', compact('complaints'));
})->name('complaints.index');

Route::post('/complaints/{id}/resolve', function ($id) {
    $complaint = Complaint::findOrFail($id);
    $complaint->status = 'resolved';
    $complaint->save();

    return redirect()->route('complaints.index')->with('success', 'Complaint marked as resolved!');
})->name('complaints.resolve');

/* sorting and filtering Features */

Route::get('/complaints', function () {
    $query = Complaint::where('status', 'pending'); // Show only pending complaints

    // Apply filtering by priority
    if (request()->has('priority') && request()->priority) {
        $query->where('priority', request()->priority);
    }

    // Apply sorting by priority
    if (request()->has('sort') && request()->sort === 'asc') {
        $query->orderBy('priority', 'asc'); // Sort priority from low to high
    } elseif (request()->has('sort') && request()->sort === 'desc') {
        $query->orderBy('priority', 'desc'); // Sort priority from high to low
    }

    $complaints = $query->get();

    return view('complaints', compact('complaints'));
})->name('complaints.index');


// Route to mark a complaint as resolved
Route::post('/complaints/{id}/resolve', function ($id) {
    $complaint = Complaint::findOrFail($id);
    $complaint->status = 'resolved';
    $complaint->save();

    return redirect()->route('complaints.index')->with('success', 'Complaint marked as resolved!');
})->name('complaints.resolve');

// Route to complaint status and history
Route::get('/complaints/{id}/history', [ComplaintController::class, 'showHistory'])->name('complaints.history');
