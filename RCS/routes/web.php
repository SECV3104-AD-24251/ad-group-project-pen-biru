<?php

//use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
use App\Http\Controllers\ComplaintController;
use App\Models\Complaint;

Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
// Staff Dashboard Route
Route::get('/staff-dashboard', [ComplaintController::class, 'index'])->name('staff.dashboard');
// Route to assign a priority level to a complaint
Route::post('/complaints/{id}/assign-priority', [ComplaintController::class, 'assignPriority'])->name('complaints.assignPriority');
Route::get('/priority', [ComplaintController::class, 'index'])->name('complaints.index');

Route::get('/complaints', function () {
    $query = Complaint::query();

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
});