<?php

namespace App\Http\Middleware;


use Closure;

class IsEmailConfirmed
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
        if(auth()->user()->confirmed == true){
            return $next($request);
        } else {
            return redirect(route('home'))
                ->with('info', 'Votre Email est en attente de confirmation');
        }
    }
}
