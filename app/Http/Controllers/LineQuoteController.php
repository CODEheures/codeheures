<?php

namespace App\Http\Controllers;


use App\Http\Requests\LineQuoteRequest;
use App\LineQuote;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Quotation;

class LineQuoteController extends Controller
{

    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => []]);
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineQuoteRequest $request)
    {
        $quotation = Quotation::findOrFail($request->quotation_id);
        if(!$quotation->isOrdered){
            $nonConformDiscount = $this->redirectNonConformDiscount($request);
            if($nonConformDiscount){
                return redirect()->back()->withErrors($nonConformDiscount);
            }

            LineQuote::create($request->only(['quotation_id', 'product_id', 'quantity', 'discount', 'discount_type']));
            $quotation->isViewed = false;
            $quotation->save();
            return redirect()->back()->with('info', 'ligne ajoutée');
        }

        return redirect()->back()->withErrors('Interdiction d\'ajouter une ligne d\'un devis acheté par un client');

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
    public function edit($id)
    {
        $lineQuote = LineQuote::findOrFail($id);
        if(!$lineQuote->quotation->isOrdered){
            return redirect(route('admin.quotation.edit', ['id' => $lineQuote->quotation->id, 'lineQuoteId' => $lineQuote->id]));
        }
        return redirect()->back()->withErrors('Interdiction de modifier une ligne d\'un devis acheté par un client');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineQuoteRequest $request, $id)
    {
        $nonConformDiscount = $this->redirectNonConformDiscount($request);
        if($nonConformDiscount){
            return redirect()->back()->withErrors($nonConformDiscount);
        }
        $lineQuote = LineQuote::findOrFail($id);
        if(!$lineQuote->quotation->isOrdered) {
            $lineQuote->update($request->only(['quantity', 'discount', 'discount_type']));
            $lineQuote->quotation->isViewed = false;
            $lineQuote->quotation->save();
            return redirect(route('admin.quotation.edit', ['id' => $lineQuote->quotation->id]))->with('info', 'informations sauvegardées');
        }
        return redirect()->back()->withErrors('Interdiction de modifier une ligne d\'un devis acheté par un client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lineQuote = LineQuote::findOrFail($id);
        if(!$lineQuote->quotation->isOrdered) {
            $lineQuote->delete();
            $lineQuote->quotation->isViewed = false;
            $lineQuote->quotation->save();
            return redirect()->back()->with('success','Ligne du devis supprimée');
        }
        return redirect()->back()->withErrors('Interdiction de supprimer une ligne d\'un devis acheté par un client');
    }

    private function redirectNonConformDiscount($request){
        if($request->discount > 10000 && $request->discount_type == 'percent') {
            return 'Reduction supérieur à 100% impossible';
        }

        if($request->discount_type == 'devise' && $request->discount > 0) {
            $lineQuote = new LineQuote();
            $lineQuote->product()->associate($request->product_id);
            $lineQuote->quantity = $request->get('quantity');
            if($lineQuote->product->price*$lineQuote->quantity < $request->discount){
                return 'Reduction supérieur au prix total impossible';
            }
        }

        return null;
    }
}
