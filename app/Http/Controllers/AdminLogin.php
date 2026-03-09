<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;

class AdminLogin extends Controller
{
    
// Display the admin login view.

    public function create()
    {
        return view('/admin_LOGIN/adminLogin'); 
    }

//Handle an incoming admin authentication request.
 
    public function store(LoginRequest $request)
    {
        // 1. Authenticate the user using the default 'web' guard
        $request->authenticate();
        
         // 2. After authentication, check if the authenticated user is an admin
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (! Auth::user()->isAdmin()) {
                // If not admin: log them out immediately
                Auth::logout();

                // Redirect back with an error message
                return back()->withErrors([
                'email' => 'These credentials do not have administrator privileges.',
            ]);
        }

        // 4. Redirect to the admin dashboard (or intended URL)
        return redirect()->route('admin.dashboard');
    }
    
//Destroy an authenticated session (logout).
 
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
