<?php

//use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
use App\Http\Controllers\ComplaintController;

Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

