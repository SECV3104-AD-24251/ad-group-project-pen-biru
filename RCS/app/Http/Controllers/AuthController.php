<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user' => $user]); // Store user in session

            // Redirect based on user role
            switch ($user->role) {
                case 'staff':
                    return redirect()->route('staff.dashboard');
                case 'technician':
                    return redirect()->route('complaints.index');
                case 'student':
                    return redirect()->route('student.dashboard'); // Redirect students to their dashboard
                default:
                    return redirect()->route('login')->withErrors(['role' => 'Role not recognized.']);
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    // Logout user
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
