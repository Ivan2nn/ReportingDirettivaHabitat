<?php

namespace App\Http\Middleware;

use Closure;

class Report_III_MiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->session()->put('report_number', 'III');
        $request->session()->save();
        return $next($request);
    }
}
