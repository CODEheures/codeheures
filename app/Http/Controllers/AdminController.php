<?php

namespace App\Http\Controllers;


use App\Common\ResetDemo;
use App\Consommation;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Purchase;
use App\Product;
use \App\Common\DataGraph;
use \App\Common\SmsFreeMobile;
use App\Http\Requests\UpdateCustomerQuotaRequest;

class AdminController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->auth = $auth;
    }

    use DataGraph;

    public function monitor(){
        $user = $this->auth->user();
        $purchases = Purchase::orderBy('user_id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $purchases->load('product');
        $purchases->load(['consommations' => function($query){
            $query->orderBy('created_at');
        }]);


        //data pour le graphique conso
        $consommations = Consommation::orderBy('created_at', 'DESC')->get();
        $data = $this->dataGraph($consommations);

        $customersList = User::where('role', '=', 'user')->get();

        return view('admin.monitor.index', compact('user', 'purchases', 'data', 'customersList'));
    }

    public function sms(){


        $sms = new SmsFreeMobile();

        /**
         * configure l'ID utilisateur et la clé disponible dans
         * le compte Free Mobile après avoir activé l'option.
         */

        $sms->setKey(env('FREE_SMS_PASS'))
            ->setUser(env("FREE_SMS_USER"));

        try {
            // envoi d'un message
            $sms->send("Hello World 1");
        } catch (\Exception $e) {
            // le monde n'est pas parfait, il y aura
            // peut-être des erreurs.
            echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
        }
        return redirect('/')->with('info', 'sms de test envoyé');

    }

    public function resetDemo(){
        $resetClass = new ResetDemo();
        $resetClass->reset();
        return redirect()->back()->with('info', 'reset du compte démo effectué');
    }

    public function updateCustomerQuota(UpdateCustomerQuotaRequest $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only('quota'));
        return redirect()->back()->with('success', 'Quota de l\'utilisateur mis à jour');
    }

    public function customerActive($id) {
        $user = User::findOrFail($id);
        $user->is_admin_valid = true;
        $user->save();
        return redirect()->back()->with('success', 'Utilisateur desormais actif');
    }

    public function customerDesactive($id) {
        $user = User::findOrFail($id);
        $user->is_admin_valid = false;
        $user->save();
        return redirect()->back()->with('success', 'Utilisateur desormais inactif');
    }
}
