<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class IsNotOauth
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
        if($request->only('email') && $request->only('email') != '') {
            $user = User::where('email', '=', $request->email)->first();
            if($user) {
                $oAuth = $user->oAuthProvider(config('providers_login'));
                if($oAuth && $oAuth != '') {
                    return redirect(route('login'))->with('info', 'Compte ouvert grâce à ' . $oAuth . '. Le mot de passe de ce compte ne peut pas être réinitialiser');
                }
            }
        }



        return $next($request);
    }
}
