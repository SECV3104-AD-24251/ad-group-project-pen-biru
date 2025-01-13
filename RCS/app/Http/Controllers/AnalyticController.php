<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function index()
    {
        return view('analytic'); // This will load the `analytic.blade.php` template
    }
}
