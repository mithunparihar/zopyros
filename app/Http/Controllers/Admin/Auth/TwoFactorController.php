<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function twostepsverification(){
        return view('admin.auth.two-steps-verification');
    }
    public function checktwostepsverification(Request $request){
        $otp = request('otp');
        $request->validate([
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode   = \App\Models\VerificationCode::where(['role'=>'admin','user_id'=>\Content::adminInfo()->id,'otp'=>(int)$request->otp])->latest()->first();
        $now = \Carbon\Carbon::now();
        if (!$verificationCode) {
            flash()->adderror('Your OTP is not correct');
            return redirect()->back();
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            \Auth::guard('admin')->logout();
            flash()->adderror('Your OTP has been expired');
            return redirect()->route('admin.login');
        }

        
        $user = \App\Models\Admin::find(\Content::adminInfo()->id);
        if($user){
            $verificationCode->update([
                'expire_at' => \Carbon\Carbon::now(),
                'attempt' => 1
            ]);           
            flash()->addsuccess('Welcome Back! '.\Content::adminInfo()->name);
            if(\Content::adminInfo()->role==0){
                return redirect()->route('admin.dashboard');
            }elseif(\Content::adminInfo()->role==1){
                return redirect()->route('admin.housing.dashboard');
            }
            
        }
        flash()->adderror('Your OTP is not correct');
        return redirect()->route('admin.login');
        
    }
    public function resendtwostepsverification(){
        
        $verificationCode = \CommanFunction::admingenerateOtp(\Content::adminInfo()->email);
        $maildata = [
            'otp' => $verificationCode->otp
        ];
        \Mail::to(\Content::adminInfo()->two_step_verification_email)->send(new \App\Mail\TwoFactorMail($maildata));
        flash()->addsuccess('Verification code has been send!');
        return back();
    }
}
