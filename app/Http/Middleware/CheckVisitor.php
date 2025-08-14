<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $role = 'visitor';
        $userid = (\Auth::user()->id ?? 0) > 0 ? \Auth::user()->id : 0;
        $checkData = \App\Models\LogActivity::whereIp($ipAddress)->whereRole($role)->first();
        if(!$checkData){
            \CommanFunction::addLogActivity($userid, $role);
        }

        if(\Auth::check()){
            $status = \Auth::user()->is_publish;
            $type = \Auth::user()->type;
            $profileComplete = \Auth::user()->profile_complete;
            if($status==0){
                \Auth::logout();
                flash()->addsuccess('Logging you out automatically!');
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
