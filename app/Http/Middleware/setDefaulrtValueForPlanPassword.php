<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class setDefaulrtValueForPlanPassword
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

        URL::defaults(['plan_password' => 'default']);
        return $next($request);
    }
}
