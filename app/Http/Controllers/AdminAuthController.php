<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (session('admin_phone') == 10000) {
            return redirect()->route('overviewIndex');
        }
        
        return view('admin.login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string',
            'password' => 'required|string',
        ]);
        
        // Verify ID number is 10000 (admin only)
        $idNumber = $request->input('id_number');
        if ($idNumber != '10000') {
            return back()->withErrors(['id_number' => 'Invalid admin ID.'])->withInput();
        }

        // Get admin user from database (learner_phone 10000)
        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();
            
        if (!$admin) {
            return back()->withErrors(['password' => 'Admin user not found in database.'])->withInput();
        }
        
        // Use password hash from database
        $hashedPassword = $admin->password;
        
        // Verify password
        if (Hash::check($request->password, $hashedPassword)) {
            // Set admin session
            session(['admin_phone' => 10000]);
            session(['admin_name' => $admin->learner_name ?? 'Admin']);
            session(['admin_image' => $admin->learner_image ?? '']);
            
            return redirect()->intended(route('overviewIndex'))->with('success', 'Welcome back, Admin!');
        }

        return back()->withErrors(['password' => 'Invalid password.'])->withInput();
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        session()->forget('admin_phone');
        session()->forget('admin_name');
        session()->forget('admin_image');
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}

