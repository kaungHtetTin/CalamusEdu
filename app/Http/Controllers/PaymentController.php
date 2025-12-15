<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $req,$major){
        
        if(isset($req->month)){
            $month=$req->month;
        }else{
            $month=date('m');
        }
        
        if(isset($req->year)){
            $year=$req->year;
        }else{
            $year=date('Y');
        }
        
        $payments=DB::table('payments')
        ->selectRaw("
        learner_name,
        learner_phone,
        amount,
        date
        ")
        ->join('learners','payments.user_id','=','learners.learner_phone')
        ->whereMonth('payments.date', $month)
        ->whereYear('payments.date', $year)
        ->where('payments.major',$major)
        ->simplepaginate(1000);
        
        $sum=DB::table('payments')
            ->where('major',$major)
            ->whereMonth('payments.date', $month)
            ->whereYear('payments.date', $year)
            ->sum('payments.amount');
            
            
        $costs=DB::table('costs')
        ->selectRaw("*")
        ->where('major',$major)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get();
        
        $totalCost=DB::table('costs')
        ->where('major',$major)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->sum('amount');
        
        return view('layouts.payment',[
                'major'=>$major,
                'payments'=>$payments,
                'total'=>$sum,
                'costs'=>$costs,
                'totalCost'=>$totalCost,
                'period'=>$month.'/'.$year
                
            ]);
    }
    
    function getPendingPayment(Request $req){
        if(isset($req->major)){
            $major=$req->major;
        }else{
            $major="korea";
        }
        $payments=DB::table('payments')
            ->selectRaw("
                payments.id,
                payments.user_id,
                learners.learner_name as username,
                payments.date,
                payments.amount,
                payments.screenshot
            ")
            ->join('learners','payments.user_id','=','learners.learner_phone')
            ->where('approve',0)
            ->where('major',$major)
            ->get();
        return $payments;
       
    }

}
