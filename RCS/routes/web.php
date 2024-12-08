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

// Route to display pending complaints
Route::get('/complaints', function () {
    $complaints = Complaint::where('status', 'pending')->get();
    return view('complaints', compact('complaints'));
})->name('complaints.pending');

// Route for filtering and sorting
Route::get('/complaints/filter', function () {
    $query = Complaint::where('status', 'pending');
    if (request()->has('priority') && request()->priority) {
        $query->where('priority', request()->priority);
    }
    if (request()->has('sort') && request()->sort === 'asc') {
        $query->orderBy('priority', 'asc');
    } elseif (request()->has('sort') && request()->sort === 'desc') {
        $query->orderBy('priority', 'desc');
    }
    $complaints = $query->get();
    return view('complaints', compact('complaints'));
})->name('complaints.filter');

// Route to mark a complaint as resolved
Route::post('/complaints/{id}/resolve', function ($id) {
    $complaint = Complaint::findOrFail($id);
    $complaint->status = 'resolved';
    $complaint->save();

    return redirect()->route('staff.dashboard')->with('success', 'Complaint marked as resolved!');
})->name('complaints.resolve');

// Route to complaint status and history
Route::get('/complaints/{id}/history', [ComplaintController::class, 'showHistory'])->name('complaints.history');
