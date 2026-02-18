<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\AdminAuthController;

class AdminRememberMe
{
    /**
     * If admin session is missing but a valid remember cookie exists (encoded credentials),
     * verify and restore the session.
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('admin_phone') == 10000) {
            return $next($request);
        }

        $payload = $request->cookie(AdminAuthController::REMEMBER_COOKIE);
        if (!$payload) {
            return $next($request);
        }

        try {
            $decoded = json_decode(Crypt::decryptString($payload), true);
            if (empty($decoded['id_number']) || empty($decoded['password'])) {
                return $next($request);
            }
        } catch (\Throwable $e) {
            return $next($request);
        }

        if ($decoded['id_number'] != '10000') {
            return $next($request);
        }

        $admin = DB::table('learners')->where('learner_phone', 10000)->first();
        if (!$admin || !Hash::check($decoded['password'], $admin->password)) {
            return $next($request);
        }

        session(['admin_phone' => 10000]);
        session(['admin_name' => $admin->learner_name ?? 'Admin']);
        session(['admin_image' => $admin->learner_image ?? '']);

        return $next($request);
    }
}
