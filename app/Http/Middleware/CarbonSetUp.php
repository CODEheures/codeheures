<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CarbonSetUp
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
        setlocale(LC_TIME, env('APP_LOCALE'));
        Carbon::setLocale('fr');
        return $next($request);
    }
}
