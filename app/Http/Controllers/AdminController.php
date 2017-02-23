<?php

namespace App\Http\Controllers;


use App\Address;
use App\Common\DemoManager;
use App\Consommation;

use App\Http\Requests\AdminCreateAccountRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Purchase;
use App\Product;
use \App\Common\DataGraph;
use App\Common\Credit;
use \App\Common\SmsFreeMobile;
use App\Http\Requests\UpdateCustomerQuotaRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->auth = $auth;
    }

    use DataGraph;
    use Credit;

    public function monitor(){
        $user = $this->auth->user();
        $purchases = Purchase::where(function($query) {
            $query->where('payed', '=', true)
                ->orWhere('quotation_id', '<>', 'null');
        })->orderBy('user_id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $purchases->load('product');
        $purchases->load(['consommations' => function($query){
            $query->orderBy('created_at');
        }]);


        //data pour le graphique conso
        $consommations = $this->consosAndtotalLeft($purchases)[0];
        //$consommations = Consommation::orderBy('created_at', 'DESC')->get();
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
        $resetClass = new DemoManager();
        $resetClass->destroyDatas(true);
        return redirect(route('admin.monitor.index'))->with('info', 'reset des comptes démos effectué');
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

    public function customerRegisterView() {
        return view('admin.cutomer.register');
    }

    public function customerRegisterPost(AdminCreateAccountRequest $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirmation_token = str_random(60);
        $user->new_create_by_admin = true;


        $request->has('firstName') ? $user->firstName = $request->firstName : null;
        $request->has('lastName') ? $user->lastName = $request->lastName : null;
        $request->has('enterprise') ? $user->enterprise = $request->enterprise : null;
        $request->has('siret') ? $user->siret = $request->siret : null;
        $request->has('phone') ? $user->phone = $request->phone : null;

        $invoiceAddress = new Address();
        $invoiceAddress->type = 'invoice';
        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $invoiceAddress->address = $request->address;
        $invoiceAddress->zipCode = $request->zipCode;
        $invoiceAddress->town = $request->town;

        $request->has('complement') ? $invoiceAddress->complement = $request->complement : null;

        DB::beginTransaction();
        $user->save();
        $user->addresses()->saveMany([$invoiceAddress,$shippingAddress]);
        DB::commit();

        return redirect(route('admin.monitor.index'));

    }
}
