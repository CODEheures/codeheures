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
                ->where('validity', '>', Carbon::now()->format('Y-m-d'))
                ->where('isPublished', '=', true)
                ->where('isOrdered', '=', false)
                ->where('isRefused', '=', false)
                ->count();
            session()->set('nbNewQuote', $nbNewQuotations);
        }

        return $next($request);
    }
}
