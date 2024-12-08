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

// Route to display complaints list (only pending complaints are shown)
Route::get('/complaints', function () {
    $query = Complaint::query()->where('status', 'pending'); // Show only pending complaints

    // Apply filtering by priority
    if (request()->has('priority') && request()->priority) {
        $query->where('priority', request()->priority);
    }

    // Apply sorting by priority
    if (request()->has('sort') && request()->sort === 'asc') {
        $query->orderBy('priority', 'asc');
    } elseif (request()->has('sort') && request()->sort === 'desc') {
        $query->orderBy('priority', 'desc');
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
