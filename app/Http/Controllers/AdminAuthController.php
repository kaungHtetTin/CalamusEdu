<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AdminAuthController extends Controller
{
    /** Remember me cookie name */
    public const REMEMBER_COOKIE = 'admin_remember';

    /** Remember me duration in days */
    public const REMEMBER_DAYS = 30;

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

        $idNumber = $request->input('id_number');
        if ($idNumber != '10000') {
            return back()->withErrors(['id_number' => 'Invalid admin ID.'])->withInput();
        }

        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();

        if (!$admin) {
            return back()->withErrors(['password' => 'Admin user not found in database.'])->withInput();
        }

        if (Hash::check($request->password, $admin->password)) {
            session(['admin_phone' => 10000]);
            session(['admin_name' => $admin->learner_name ?? 'Admin']);
            session(['admin_image' => $admin->learner_image ?? '']);

            $response = redirect()->intended(route('overviewIndex'))->with('success', 'Welcome back, Admin!');

            if ($request->boolean('remember_me')) {
                $payload = Crypt::encryptString(json_encode([
                    'id_number' => $idNumber,
                    'password' => $request->password,
                ]));
                $response->cookie(
                    self::REMEMBER_COOKIE,
                    $payload,
                    self::REMEMBER_DAYS * 24 * 60,
                    '/',
                    null,
                    $request->secure(),
                    true,
                    false,
                    'lax'
                );
            }

            return $response;
        }

        return back()->withErrors(['password' => 'Invalid password.'])->withInput();
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        session()->forget(['admin_phone', 'admin_name', 'admin_image']);

        $response = redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
        $response->cookie(self::REMEMBER_COOKIE, '', -1, '/');

        return $response;
    }
}

