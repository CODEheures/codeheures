<?php

namespace App\Http\Controllers;

use App\Common\SmsFreeMobile;
use App\Http\Requests\QuotationRequest;
use App\LineQuote;
use App\Product;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Quotation;
use App\Common\ListEnum;
use App\Common\UserList;
use PhpSpec\Util\Filesystem;

class QuotationController extends Controller
{

    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
        $this->middleware('fullProfile', ['only' => ['customerIndex', 'order', 'refuse', 'pdf']]);
        $this->middleware('admin', ['except' => ['customerIndex', 'order', 'refuse', 'orderPost', 'pdf']]);
        $this->auth = $auth;
    }

    use ListEnum;
    use UserList;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::where('isArchived', '=', 'false')->orderBy('created_at', 'DESC')->get();
        $quotations->load('lineQuotes');
        $totalPrice = [];
        foreach($quotations as $quotation){
            $totalPrice[$quotation->id] = $this->totalPrice($quotation);
        }
        return view('admin.quotation.index', compact('quotations', 'totalPrice'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerIndex()
    {
        $quotations = Quotation::where('user_id', '=', $this->auth->user()->id)->where('isPublished', '=', true)->where('isRefused', '=', false)->where('isArchived', '=', false)->where('validity', '>=', Carbon::today()->format('Y-m-d'))->get();
        $quotations->load('lineQuotes');
        $totalPrices = [];
        $totalTvas = [];
        foreach($quotations as $quotation){
            $totalPrices[$quotation->id] = $this->totalPrice($quotation);
            $totalTvas[$quotation->id] = $this->totalPrice($quotation, true);
            $quotation->isViewed = true;
            $quotation->save();
    }
        return view('customer.quotation.index', compact('quotations', 'totalPrices', 'totalTvas'));
    }

    /**
     * Return PDF of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->user_id == $this->auth->user()->id) {
            $quotation->load('lineQuotes');
            $quotation->load('user');
            $totalPrice = $this->totalPrice($quotation);
            $totalTva = $this->totalPrice($quotation, true);
            $isPdf = true;

            $content = view('pdf.quotation.index', compact('quotation', 'totalPrice', 'totalTva', 'isPdf'))->__toString();
            $header = view('header.pdf', compact('quotation'))->__toString();
            $footer = view('footer.pdf')->__toString();
            $css = file_get_contents(asset('css/pdf.min.css'));

            $mpdf = new \mPDF();

            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            //$mpdf->Bookmark('Start of the document');
            $mpdf->AddPageByArray([
                'margin-left' => 10,
                'margin-right' => 10,
                'margin-top' => 30,
                'margin-bottom' => 30,
                'margin-header' => 10,
                'margin-footer' => 10
            ]);
            $mpdf->WriteHTML($css,1);
            $mpdf->WriteHTML($content,2);
            $mpdf->Output();

        } else {
            return redirect(route('home'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order($id, Request $request)
    {
        if(!$this->auth->user()->phone){
            $routeReturn['name'] = 'customer.quotation.order';
            $routeReturn['param'] = ['id' => $id];
            $user = $this->auth->user();
            return view('customer.account.phoneForce', compact('user', 'routeReturn'));
        }
        $quotation = Quotation::findOrFail($id);
        if($quotation->user_id == $this->auth->user()->id) {
            $quotation->load('lineQuotes');
            $totalPrice = $this->totalPrice($quotation);
            $totalTva = $this->totalPrice($quotation, true);

            if ($quotation->canPurchase()) {
                if (!$quotation->hasValidCode()) {
                    if ($quotation->canHaveNewCode()) {
                        //generation du code
                        $randomSMSConfirmCode = rand($quotation->getMinSmsCode(), $quotation->getMaxSmsCode());
                        $quotation->sms_code = $randomSMSConfirmCode;
                        $quotation->sms_validity = Carbon::now();
                        $quotation->sms_tentatives = 0;
                        $quotation->save();
                        $this->sms('Votre code de confirmation est: ' . $randomSMSConfirmCode);
                        $request->session()->flash('status', 'Vous allez recevoir un SMS avec un code de confirmation valable pendant 15minutes à renseigner en bas de cette page');
                    } else {
                        $error = 'Nombre de tentatives atteint. Attendre ' . $quotation->getLeftTimeCodeValidity() .
                            'secondes avant génération et envoi d\'un nouveau code';
                        return redirect(route('customer.quotation.index'))->withErrors($error);
                    }

                }
                return view('customer.quotation.order', compact('quotation', 'totalPrice', 'totalTva'));
            }
        } else {
            return redirect(route('home'));
        }
        return redirect(route('customer.quotation.index'))->withErrors('Signature interdite: devis déjà signé ou date de validité dépassée');
    }

    public function orderPost(Request $request, $id) {
        $quotation = Quotation::findOrFail($id);
        if($quotation->hasValidCode() && $quotation->user_id == auth()->user()->id){
            $quotation->sms_tentatives += 1;
            $quotation->save();
            if($quotation->sms_code == $request->get('smsCode')){
                $quotation->isOrdered = true;
                $quotation->orderDate = Carbon::now();
                $quotation->phoneUsedForOrder = auth()->user()->phone;
                $quotation->save();
                //TODO MAIL AVEC PDF
                $lineQuotes = $quotation->lineQuotes;
                foreach ($lineQuotes as $lineQuote) {
                    $purchase = Purchase::create([
                        'user_id' => $quotation->user->id,
                        'product_id' => $lineQuote->product->id,
                        'hash_key' => str_random(12),
                        'payed' => false,
                        'quantity' => $lineQuote->quantity,
                        'quotation_id' => $quotation->id
                    ]);
                    $purchase->save();
                }
                return redirect(route('customer.quotation.index'))->with('success', 'Votre devis est desormais numériquement signé,
                merci de votre confiance. Merci de nous renvoyer un devis papier signé d\'ici 15 jours. Ce devis vous a
                été envoyé dans votre boite mail et est disponible en téléchargement sur votre compte CODEheures dans la rubrique
                "Mes Devis"');
            } else {
                return redirect()->back()->withErrors('code erroné');
            }
        } else {
            if(!$quotation->hasValidCode() && $quotation->user_id == auth()->user()->id) {
                return redirect()->back();
            }
        }
        return redirect(route('home'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newQuotation = new Quotation;
        $userList = UserList::userList();
        return view('admin.quotation.create', compact('newQuotation', 'userList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        if(Carbon::createFromFormat('Y-m-d', $request->get('validity'))->isFuture()){
            $quotation = Quotation::create($request->only(['user_id', 'validity']));
            return redirect(route('admin.quotation.edit', ['id' => $quotation->id]))->with('info', 'ajoutez des lignes au nouveau devis');
        }

        return redirect()->back()->withErrors('La date choisie doit être future');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $lineQuoteId = null)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->load('lineQuotes');
        $totalPrice = $this->totalPrice($quotation);
        $userList = UserList::userList();
        $productList = Product::where('isObsolete', '=', false)
            ->where(function($query) use($quotation) {
                $query->whereNull('reservedForUserId')
                    ->orWhere('reservedForUserId', '=', $quotation->user_id);
            })
            ->Lists('description', 'id');

        $newLineQuote = new LineQuote();
        $listEnumDiscountType = $this->getEnumValues('line_quotes', 'discount_type');
        return view('admin.quotation.edit', compact('quotation', 'lineQuoteId', 'userList', 'productList', 'newLineQuote', 'listEnumDiscountType', 'totalPrice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, $id)
    {
        if(Carbon::createFromFormat('Y-m-d', $request->get('validity'))->isFuture()){
            $quotation = Quotation::findOrFail($id);
            if($quotation->canEdit()){
                $quotation->update($request->only(['user_id', 'validity', 'downPercentPayment']));
                $quotation->isViewed = false;
                $quotation->save();
                return redirect()->back()->with('info', 'informations sauvegardées');
            }
            return redirect()->back()->withErrors('Le devis est déjà signé, modification interdite');
        }

        return redirect()->back()->withErrors('La date choisie doit être future');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->canDelete()) {
            $quotation->lineQuotes()->delete();
            $quotation->delete();
            return redirect(route('admin.quotation.index'))->with('info', 'Devis supprimé');
        }

        return redirect()->back()->withErrors('Interdiction de supprimer un devis payé par le client');
    }

    /**
     * Publish the specified resource for customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->canPublish()){
            $quotation->isPublished = true;
            $quotation->save();
            return redirect()->back()->with('info', 'Devis publié');
        }

        return redirect()->back()->withErrors('Ajoutez au moins une ligne au devis pour pouvoir le publier');
    }

    /**
     * UnPublish the specified resource for customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unPublish($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->canUnpublish()){
            $quotation->isPublished = false;
            $quotation->isViewed = false;
            $quotation->save();
            return redirect()->back()->with('info', 'Devis dépublié');
        }
        return redirect()->back()->withErrors('Devis signé, dépublication interdite');
    }

    /**
     * UnPublish the specified resource for customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refuse($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->canRefuse() && $quotation->user_id == auth()->user()->id){
            $quotation->isRefused = true;
            $quotation->save();
            return redirect()->back()->with('info', "Ho non '-(. Vous venez de refuser notre devis. 
            Nous vous remerçions de votre confiance et restons à votre disposition pour toute question");
        }
        return redirect()->back()->withErrors('Action interdite');
    }

    /**
     * Archive the specified resource for customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $quotation = Quotation::findOrFail($id);
        if($quotation->canArchive){
            $quotation->isArchived = true;
            $quotation->save();
            return redirect(route('admin.quotation.index'))->with('info', 'Devis archivé');
        }
        return redirect()->back()->withErrors('Devis non signé, archivage interdite');
    }



    private function totalPrice(Quotation $quotation, $tva=false){
        $totalPrice = 0;
        foreach($quotation->lineQuotes as $lineQuote){
            if($lineQuote->discount > 0) {
                if($lineQuote->discount_type == 'percent') {
                    $totalPrice += $lineQuote->product->price*$lineQuote->quantity*(1-$lineQuote->discount/100)*($tva ? $lineQuote->product->tva/100 :1);
                } else {
                    $totalPrice += ($lineQuote->product->price*$lineQuote->quantity -$lineQuote->discount)*($tva ? $lineQuote->product->tva/100 :1);
                }
            } else {
                $totalPrice += $lineQuote->product->price*$lineQuote->quantity*($tva ? $lineQuote->product->tva/100 :1);
            }
        }
        return $totalPrice;
    }

    private function sms($message){
        $sms = new SmsFreeMobile();
        $sms->setKey(env('FREE_SMS_PASS'))
            ->setUser(env('FREE_SMS_USER'));
        try {
            $sms->send($message);
        } catch (Exception $e) {
            echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
        }
    }
}
