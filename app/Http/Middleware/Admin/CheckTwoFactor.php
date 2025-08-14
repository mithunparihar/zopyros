<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        

        $verificationCode   = \App\Models\VerificationCode::where(['user_id'=>\Content::adminInfo()->id,'role'=>'admin'])->latest()->first();
        $now = \Carbon\Carbon::now();
        if(!in_array(request()->segment(2),['check-two-steps-verification','two-steps-verification','resend-two-steps-verification']) && !empty($verificationCode)){
            if($now->isAfter($verificationCode->expire_at)==true && $verificationCode->attempt==0){
                \Auth::guard('admin')->logout();
                flash()->addsuccess('Logout! Verification Expired');
                return redirect()->route('admin.login');
            }
            if(($verificationCode->attempt==0  || $verificationCode->attempt==null) && $now->isAfter($verificationCode->expire_at)==false){
                return redirect()->route('admin.twostepsverification');
            } 
        }
        return $next($request);
    }
}
