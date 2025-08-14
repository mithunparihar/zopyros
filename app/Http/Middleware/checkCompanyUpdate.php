<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkCompanyUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::check()) {
            $userInfo = \App\Models\User::with('companyInfo')->findOrFail(\Auth::user()->id);
            $segment = request()->segment(3);
            if ( ($userInfo->companyInfo->update_company_overview ?? 0) == 0 && $segment!='update') {
                $message = \App\Enums\AlertMessage::ADDCOMPANYINFO;
                flash()->addsuccess("$message->value");
                return redirect()->route('user.company.update');
            }
        }
        return $next($request);
    }
}
