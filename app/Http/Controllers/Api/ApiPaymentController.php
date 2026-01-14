<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class ApiPaymentController extends Controller
{
    /**
     * Get pending payments filtered by major
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingPayment(Request $request)
    {
        try {
            $major = $request->get('major', 'korea');
            
            $payments = DB::table('payments')
                ->selectRaw("
                    payments.id,
                    payments.user_id,
                    learners.learner_name as username,
                    payments.date,
                    payments.amount,
                    payments.screenshot
                ")
                ->join('learners', 'payments.user_id', '=', 'learners.learner_phone')
                ->where('payments.approve', 0)
                ->where('payments.major', $major)
                ->orderBy('payments.date', 'desc')
                ->get();
            
            // Format the response to match API documentation
            $formattedPayments = $payments->map(function ($payment) {
                return [
                    'id' => (string) $payment->id,
                    'user_id' => (string) $payment->user_id,
                    'username' => $payment->username,
                    'amount' => (string) $payment->amount,
                    'screenshot' => $payment->screenshot ?? '',
                    'date' => $payment->date
                ];
            });
            
            return response()->json($formattedPayments);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error occurred'], 500);
        }
    }
}
