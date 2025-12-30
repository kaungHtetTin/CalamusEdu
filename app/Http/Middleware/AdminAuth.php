<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is logged in (learner_phone 10000)
        $adminPhone = session('admin_phone');
        
        if ($adminPhone != 10000) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
        }
        
        // Verify the admin user exists in database
        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();
            
        if (!$admin) {
            session()->forget('admin_phone');
            return redirect()->route('admin.login')->with('error', 'Admin user not found.');
        }
        
        return $next($request);
    }
}

