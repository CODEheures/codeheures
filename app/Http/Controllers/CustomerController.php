<?php

namespace App\Http\Controllers;


use App\Http\Requests\PhoneAccountRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailer;
use App\Address;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateAccountAddressRequest;
use App\Purchase;
use App\Product;

class CustomerController extends Controller
{
    private $mailer;
    private $auth;

    public function __construct(Mailer $mailer, Guard $auth) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
        $this->mailer = $mailer;
        $this->auth = $auth;
    }

    public function edit() {
        $user = $this->auth->user();
        $addresses = Address::where('user_id', '=', $user->id)->get();
        return view('customer.account.edit', compact('user', 'addresses'));

    }

    public function update(UpdateAccountRequest $request){

        $updates = $request->only(['name', 'phone', 'firstName', 'lastName', 'enterprise', 'siret']);
        $updates['phone'] = (str_replace('+33','0',str_replace('-','',filter_var($updates['phone'],FILTER_SANITIZE_NUMBER_INT))));
        if ($request->get('phone') == ""){
            $updates['phone']=null;
        }
        $user = $this->auth->user();
        $user->update($updates);
        return redirect()->back()->with('success', 'informations enregistrées');
    }

    /**
     * @param PhoneAccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoneOnly(PhoneAccountRequest $request){
        $updates = $request->only(['phone']);
        $updates['phone'] = (str_replace('+33','0',str_replace('-','',filter_var($updates['phone'],FILTER_SANITIZE_NUMBER_INT))));

        if ($request->get('phone') == ""){
            $updates['phone']=null;
        }

        $routeReturn = json_decode($request->get('routeReturn'),true);

        $user = $this->auth->user();
        $user->update($updates);

        return redirect(route($routeReturn['name'], $routeReturn['param']))->with('success', 'informations enregistrées');
    }

    public function addressUpdate(UpdateAccountAddressRequest $request){
        $user = $this->auth->user();
        $address = Address::where('user_id', '=', $user->id)->where('type', '=', $request->get('type'))->first();
        $address->update($request->only(['address', 'complement', 'zipCode', 'town']));
        return redirect()->back()->with('success', 'informations enregistrées');
    }

    public function monitor(){
        $user = $this->auth->user();
        $purchases = Purchase::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->get();
        $purchases->load('product');
        $purchases->load('consommations');


        //data pour le graphique conso
        $conso = [];
        $totalQuantity = 0;
        $totalConsommation = 0;
        foreach($purchases as $purchase){
            if($purchase->product->type == 'time'){
                $totalQuantity += $purchase->product->value*$purchase->quantity;
            }
            foreach($purchase->consommations as $consommation){
                $conso[] = [
                    'x' => $consommation->created_at->format('Y-m-d'),
                    'y' => $consommation->value,
                    'com' => $consommation->comment
                ];

                if($purchase->product->type == 'time'){
                    $totalConsommation += $consommation->value;
                }
            }
        }

        $totalLeft = $totalQuantity-$totalConsommation;

        $main=[];
        $main[] = [
            'className' => '.consommations',
            'data' => $conso
        ];

        $data = [
            'xScale' => 'time',
            'yScale' => 'linear',
            'main' => $main

        ];


        $data = json_encode($data,JSON_NUMERIC_CHECK);


        return view('customer.monitor.index', compact('user', 'purchases', 'data', 'totalLeft'));
    }

    public function customerDemoToRegister(){
        if(auth()->user()->email == env('DEMO_USER_MAIL')){
            auth()->logout();
            return redirect(route('register'));
        }

        return redirect(route('home'));
    }
}
