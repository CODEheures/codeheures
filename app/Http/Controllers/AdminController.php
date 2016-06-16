<?php

namespace App\Http\Controllers;


use App\Common\ResetDemo;
use App\Consommation;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Purchase;
use App\Product;
use \App\Common\DataGraph;
use \App\Common\SmsFreeMobile;

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
        $purchases->load('consommations');


        //data pour le graphique conso
        $consommations = Consommation::orderBy('created_at', 'DESC')->get();
        $data = $this->dataGraph($consommations);


        return view('admin.monitor.index', compact('user', 'purchases', 'data'));
    }

    public function sms(){


        $sms = new SmsFreeMobile();

        /**
         * configure l'ID utilisateur et la clé disponible dans
         * le compte Free Mobile après avoir activé l'option.
         */
        $sms->setKey("HFMSnaZCFcF2ph")
            ->setUser("11584563");

        try {
            // envoi d'un message
            $sms->send("Hello World 1");
        } catch (Exception $e) {
            // le monde n'est pas parfait, il y aura
            // peut-être des erreurs.
            echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
        }


    }

    public function resetDemo(){
        $resetClass = new ResetDemo();
        $message = $resetClass->reset();
        dd($message);
    }
}
