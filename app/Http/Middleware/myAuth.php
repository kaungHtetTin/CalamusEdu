<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Hash;
use App\Models\learner;
class myAuth
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
        $check=session('kaunghtettin5241');
        // $pw='$2y$10$LBUfbqygLh.9g00bN1fZ1ulP5bok5lIJl212Fn6f7b9tusi8IB0/G';
        // if(!Hash::check($check, $pw)){
        //     return redirect('/');
        // }
        
        $user=learner::where('learner_phone',$check)->first();
        if(!$user){
            return redirect('/');
        }
        return $next($request);
    }
}
