<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public $redirectTo = RouteServiceProvider::ADMINHOME;


    /// Login
    public function create(){
        return view('admin.auth.login');
    }
    public function store(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);   
        $credentials = $request->only('email', 'password');
        
        
        if (\Auth::guard('admin')->attempt($credentials)) {
            $adminInfo = \Content::adminInfo();

            flash()->addsuccess('Welcome Back! '.$adminInfo->name);
            \CommanFunction::addLogActivity($adminInfo->id,'admin');

                $logindata = \App\Models\Admin::find($adminInfo->id);
                $logindata->lastlogin_at = date('Y-m-d H:i:s');
                $logindata->save();

            if($adminInfo->two_step_verification==1){
                $verificationCode = \CommanFunction::admingenerateOtp($adminInfo->email);
                $maildata = [
                    'otp' => $verificationCode->otp
                ];
                dispatch(new \App\Jobs\TwoFactor($maildata,$logindata))->delay(3);
            }
            
            return redirect()->intended(RouteServiceProvider::ADMINHOME);
        }
  
        return redirect()->route("admin.login")->withErrors(['email'=>'These credentials do not match our records.']);
    }

    /// Logout
    public function destroy(){
        \Auth::guard('admin')->logout();
        return back()->with('success_msg','Logout!');
    }

    /// Forget Password
    public function forgotpassword(){
        return view('admin.auth.forgot-password');
    }
    public function sendforgotpasswordlink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);
        $user = \App\Models\Admin::where('email',$request->email)->first();
        if(empty($user)){
            return redirect()->back()->withErrors(['email'=>'This email address is not exists in our records.']);
        }
        if($user->is_publish==0){
            return redirect()->back()->withErrors(['email'=>'This account is not activated yet.']);
        }

        $token = \Str::random(64);  
        $checktoken = \DB::table('password_reset_tokens')->where('email',$request->email)->first();
        if(empty($checktoken)){
            \DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => \Carbon\Carbon::now()
            ]);
        }else{
            \DB::table('password_reset_tokens')->where('email',$request->email)->update([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => \Carbon\Carbon::now()
            ]);
        }
        dispatch(new \App\Jobs\Admin\ForgetPassword($token,$user))->delay(3);
        flash()->addsuccess('We have e-mailed your password reset link!');
        return back();

    }


    //// Reset Password
    public function resetpasswordget($token){
        return view('admin.auth.reset-password',compact('token'));
    }
    public function submitResetPasswordForm(Request $request){
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required'
        ]);
        $updatePassword = \DB::table('password_reset_tokens')->where(['token' => $request->token ])->first();
        if(!$updatePassword){
            // flash()->addsuccess('Invalid token!');
            return back()->withInput()->with('error_msg', 'Invalid token!');
        }
        $user = \App\Models\Admin::where('email',$updatePassword->email)->update(['password' => \Hash::make($request->password),'password_text'=>$request->password]);
        \DB::table('password_reset_tokens')->where(['token'=> $request->token])->delete();
        flash()->addsuccess('Your password has been changed!');
        return redirect()->route('admin.login');
    }

}
