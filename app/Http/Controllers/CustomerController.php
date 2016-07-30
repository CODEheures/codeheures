<?php

namespace App\Http\Controllers;


use App\Common\DataGraph;
use App\Common\InvoiceTools;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\PhoneAccountRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailer;
use App\Address as CodeheuresAddress;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateAccountAddressRequest;
use App\Http\Requests\SaleChoiceRequest;
use App\Purchase;
use App\Product;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\PayerInfo;
use PayPal\Api\ShippingAddress;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PhpSpec\Exception\Exception;
use PayPal\Api\Address as PaypalAddress;
use App\Common\Credit;

class CustomerController extends Controller
{
    private $mailer;
    private $auth;
    private $_api_context;
    private $invoiceTools;

    public function __construct(Mailer $mailer, Guard $auth, InvoiceTools $invoiceTools) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
        $this->middleware('isEmailConfirmed', ['only' => ['saleChoice', 'saleRecapitulation']]);
        $this->middleware('fullProfile', ['only' => ['saleChoice', 'saleRecapitulation']]);
        $this->middleware('admin', ['only' => ['testPdf']]);
        $this->mailer = $mailer;
        $this->auth = $auth;
        $this->invoiceTools = $invoiceTools;


        // setup PayPal api context
        if(auth()->check() && auth()->user()->email != env('DEMO_USER_MAIL')){
            $paypal_conf = config('paypal');
        } else {
            $paypal_conf = config('paypal_sandbox');
        }
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->invoiceTools->setApiContext($this->_api_context);
    }

    use DataGraph;
    use Credit;

    public function edit() {
        $user = $this->auth->user();
        $addresses = CodeheuresAddress::where('user_id', '=', $user->id)->get();
        return view('customer.account.edit', compact('user', 'addresses'));

    }

    public function update(UpdateAccountRequest $request){
        $updates = $request->only(['email', 'name', 'phone', 'firstName', 'lastName', 'enterprise', 'siret']);
        $updates['phone'] = (str_replace('+33','0',str_replace('-','',filter_var($updates['phone'],FILTER_SANITIZE_NUMBER_INT))));
        if ($request->get('phone') == ""){
            $updates['phone']=null;
        }
        $user = $this->auth->user();

        $withInfoPlus = '';
        if($user->email != $updates['email'] && $user->email ==  env('DEMO_USER_MAIL')) {
            $updates['email'] = env('DEMO_USER_MAIL');
            $withInfoPlus = '(l\'email du compte de demonstration n\'est pas modifiable)';
        }

        if($user->email != $updates['email']) {
            $user->update($updates);
            AuthController::setNewToken($user, $this->mailer);
            return redirect()->back()->with('success', 'merci de valider votre nouvel email par le lien reçu');
        } else {
            $user->update($updates);
            return redirect()->back()->with('success', 'informations enregistrées'.$withInfoPlus);
        }
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
        $address = CodeheuresAddress::where('user_id', '=', $user->id)->where('type', '=', $request->get('type'))->first();
        $address->update($request->only(['address', 'complement', 'zipCode', 'town']));
        return redirect()->back()->with('success', 'informations enregistrées');
    }

    public function monitor(){
        $user = $this->auth->user();
        $purchases = $user->validPuchases();
        $purchases->load('product');
        $purchases->load('invoices');
        $purchases->load(['consommations' => function($query){
            $query->orderBy('created_at');
        }]);


        //data pour le graphique conso
        $totalLeft = $this->consosAndtotalLeft($purchases)[1];
        $conso = $this->consosAndtotalLeft($purchases)[0];
        $data = $this->dataGraph($conso);
        
        return view('customer.monitor.index', compact('user', 'purchases', 'data', 'totalLeft'));
    }

    public function customerDemoToRegister(){
        if(auth()->user()->email == env('DEMO_USER_MAIL')){
            auth()->logout();
            return redirect(route('register'));
        }

        return redirect(route('home'));
    }

    public function saleChoice() {
        $productsList = Product::where('isObsolete', '=', false)
            ->where('type', '=', 'time')
            ->where(function($query)  {
                $query->whereNull('reservedForUserId')
                    ->orWhere('reservedForUserId', '=', '0');
            })

            ->where(function($query)  {
                $query->where('value', '=', 1)
                    ->orWhere('value', '=', 5)
                    ->orWhere('value', '=', 10)
                    ->orWhere('value', '=', 50);
            })
            ->orderBy('value')
            ->get();
        $user = $this->auth->user();
        $purchases = $user->validPuchases();
        $totalLeft = $this->consosAndtotalLeft($purchases)[1];
        return view('sale.choice.index', compact('productsList', 'totalLeft'));
    }

    public function saleRecapitulation(SaleChoiceRequest $request) {
        $user = $this->auth->user();
        $purchases = $user->validPuchases();
        $totalLeft = $this->consosAndtotalLeft($purchases)[1];
        $product = Product::findOrFail($request->get('product-id'));
        if(auth()->user()->is_admin_valid && auth()->user()->quota >= $totalLeft+$product->value){
            return view('sale.recapitulation.index', compact('product'));
        }
        return redirect(route('customer.monitor.index'))
            ->with('error', 'Ho mince! Une erreur inconnue est apparue \':(');

    }

    public function salePayment($id) {
        $product = Product::findOrFail($id);
        $purchase = new Purchase();
        $purchase->hash_key = $purchase->generateHashKey();
        $purchase->user_id = $this->auth->user()->id;
        $purchase->product_id = $product->id;
        $purchase->payed = false;
        $purchase->quantity = 1;
        $purchase->save();

        $price = round(($product->price + round(($product->price*$product->tva/100),2)),2);


        $payerInfo = new PayerInfo();

        $adresses = $this->auth->user()->addresses;
        foreach ($adresses as $adress) {
            if($adress->type == 'invoice') {
                $paypalAdress = new ShippingAddress();
                $paypalAdress->setLine1($adress->address);
                $paypalAdress->setLine2($adress->complement);
                $paypalAdress->setPostalCode($adress->zipCode);
                $paypalAdress->setCity($adress->town);
                $paypalAdress->setCountryCode('FR');
                if($this->auth->user()->enterprise != null){
                    $paypalAdress->setRecipientName($this->auth->user()->enterprise);
                } else {
                    $paypalAdress->setRecipientName($this->auth->user()->firstName . ' ' . $this->auth->user()->lastName);
                }
            }
        }


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $payer->setPayerInfo($payerInfo);


        $item_1 = new Item();
        $item_1->setName($product->description) // item name
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setTax(round(($product->tva*$product->price/100),2))
            ->setPrice($price); // unit price

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $item_list->setShippingAddress($paypalAdress);

        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Votre achat chez CODEheures')
            ->setInvoiceNumber($purchase->id);


        $redirect_urls = new RedirectUrls();

        // Specify return URL
        $redirect_urls->setReturnUrl(route('customer.sale.payment.status').'?success=true')
            ->setCancelUrl(route('customer.sale.payment.status').'?success=false');

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));


        try {
            $payment->create($this->_api_context);
        } catch (PayPalConnectionException $ex) {
            if (config('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Ho mince! Une erreur inconnue est apparue \':(');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        session(['paypal_payment_id' => $payment->getId()]);

        if(isset($redirect_url)) {
            // redirect to paypal
            return redirect($redirect_url);
        }
        return redirect(route('customer.monitor.index'))
            ->with('error', 'Ho mince! Une erreur inconnue est apparue \':(');
        }

    public function salePaymentStatus(Request $request) {

        if($request->get('success') == 'true') {
            // Get the payment ID before session clear
            $session_payment_id = session('paypal_payment_id');
            $payment_id = $request->get('paymentId');

            //test sessionId = Request return paymentId
            if($session_payment_id != $payment_id) {
                session()->forget('paypal_payment_id');
                return redirect(route('customer.monitor.index'))
                    ->with('error', 'Ho non! Le paiement à échoué \':(');

            }

            // clear the session payment ID
            session()->forget('paypal_payment_id');

            if (empty($request->input('PayerID')) || empty($request->input('token'))) {
                return redirect(route('customer.monitor.index'))
                    ->with('error', 'Ho non! Le paiement à échoué \':(');
            }

            try {
                $payment = Payment::get($payment_id, $this->_api_context);

                // PaymentExecution object includes information necessary
                // to execute a PayPal account payment.
                // The payer_id is added to the request query parameters
                // when the user is redirected from paypal back to your site
                $execution = new PaymentExecution();
                $execution->setPayerId($request->input('PayerID'));
                //Execute the payment
                $result = $payment->execute($execution, $this->_api_context);
            } catch (\Exception $e) {
                return redirect(route('customer.monitor.index'))
                    ->with('error', 'Ho non! Le paiement à échoué \':(');
            }




            if ($result->getState() == 'approved') { // payment made
                $purchase = Purchase::findOrFail($result->getTransactions()[0]->getInvoiceNumber());
                $purchase->paypal_result = json_encode(['id' => $result->getId()]);
                $purchase->payed = true;
                $purchase->save();

                //envoi du mail de la facture
                try {
                    $this->invoiceTools->create('isSold', 'purchase', $purchase->id, true);
                    $this->invoiceTools->sendMail();
                    return redirect(route('customer.monitor.index'))
                        ->with('success', 'Merci pour votre paiement. Votre compte est crédité. Votre facture est disponible dans votre espace client sur le détail de votre commande sur le lien suivant: ')
                        ->with('info_url', route('invoice.get', ['type' => 'isSold', 'origin' => 'purchase', 'id' => $purchase->id]))
                        ->with('info_url_txt', 'voir ma facture');
                } catch (\Exception $e) {
                    return redirect(route('customer.monitor.index'))
                        ->with('success', 'Merci pour votre paiement. Votre compte est crédité.');
                }
            }

            return redirect(route('customer.monitor.index'))
                ->with('error', 'Ho non! Le paiement à échoué \':(');
        } else {
            return redirect(route('customer.monitor.index'))
                ->with('error', 'Ho non! Le paiement à échoué \':(');
        }
    }
}
