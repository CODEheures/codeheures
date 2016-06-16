<?php

namespace App\Http\Middleware;

use App\Quotation;
use Carbon\Carbon;
use Closure;

class HaveNewQuotation
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
        if(auth()->check()){
            $nbNewQuotations = Quotation::where('user_id',  '=', auth()->user()->id)
                ->where('isViewed', '=', false)
                ->where('validity', '>', Carbon::now()->format('Y-m-d'))
                ->count();
            session()->set('nbNewQuote', $nbNewQuotations);
        }
        return $next($request);
    }
}
