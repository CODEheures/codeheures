<?php

namespace App\Http\Middleware;


use Closure;

class FullProfile
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
        $testEmail = false;
        $testName = false;
        $testEnterprise = false;
        $testAddress = false;

        if(auth()->user()->email <>''){
            $testEmail = true;
        }

        if(auth()->user()->firstName <>'' && auth()->user()->lastName <> ''){
            $testName = true;
        }

        if(auth()->user()->enterprise <>'' && auth()->user()->siret <> ''){
            $testEnterprise = true;
        }

        foreach(auth()->user()->addresses as $address){
            if($address->type == 'billing'){
                if($address->address <>'' && $address->zipCode <>'' && $address->town <>''){
                    $testAddress = true;
                }
            }
        }

        if($testEmail==false){
            return redirect(route('customer.account.edit'))
                ->with('info', 'Completez votre profil SVP. Vous devez remplir votre email 
                avant de pouvoir afficher cette page');
        }


        if(!$testName==true && !$testEnterprise==true){
            if($testAddress==true){
                return redirect(route('customer.account.edit'))
                    ->with('info', 'Completez votre profil SVP. Vous devez remplir votre nom et prénom et/ou votre
                    nom d\'entreprise et siret dans votre profil avant de pouvoir afficher cette page');
            } else {
                return redirect(route('customer.account.edit'))
                    ->with('info', 'Completez votre profil SVP. Vous devez remplir votre nom et prénom et/ou votre
                    nom d\'entreprise et siret dans votre profil ainsi que votre adresse de facturation
                    avant de pouvoir afficher cette page');
            }
        }

        if($testAddress==false){
            return redirect(route('customer.account.edit'))
                ->with('info', 'Completez votre profil SVP. Vous devez remplir votre adresse de facturation
                avant de pouvoir afficher cette page');
        }

        return $next($request);
    }
}
