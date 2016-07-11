<?php

namespace App\Http\Controllers;

use App\Consommation;
use App\Http\Requests\ConsommationRequest;
use App\Prestation;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Common\DataGraph;

class ConsommationController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
        $this->middleware('admin', ['except' => ['show']]);
        $this->auth = $auth;
    }

    use DataGraph;

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
    public function store(ConsommationRequest $request)
    {
        $message = $this->redirectNoneConformConsommation($request);
        if ($message != null) {
            return redirect()->back()->withErrors($message);
        }

        $consommation = new Consommation();
        $consommation->value = $request->get('value');
        $consommation->comment = $request->get('comment');
        $consommation->created_at = $request->get('created_at');

        $purchase = Purchase::findOrFail($request->get('purchase_id'));
        $purchase->consommations()->save($consommation);

        $prestation = Prestation::findOrFail($request->get('prestation_id'));
        $prestation->consommations()->save($consommation);

        return redirect()->back()->with('success','Pointage enregistré');
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
        $consommationToEdit = Consommation::findOrFail($id);
        $consommationToEdit->load('purchase');
        $consommationToEdit->load('prestation');

        $purchase = $consommationToEdit->purchase;
        $purchase->load(['consommations' => function($query){
            $query->orderBy('created_at', 'DESC');
        }]);
        $purchase->load('product');

        $consommations = $purchase->consommations()->get();
        $consommations->load('prestation');
        $data = $this->dataGraph($consommations);

        $prestations[0] = 'Aucun';
        $prestationsDatas= Prestation::where('isObsolete', '=', 'false')->orderBy('name')->Lists('name', 'id');
        $prestations = $prestations + $prestationsDatas->toArray();

        return view('consommation.edit', compact('consommationToEdit', 'purchase', 'consommations', 'data', 'prestations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsommationRequest $request, $id)
    {
        $message = $this->redirectNoneConformConsommation($request, $id);
        if ($message != null) {
            return redirect()->back()->withErrors($message);
        }
        $consommation = Consommation::findOrFail($id);
        $consommation->update($request->only(['created_at', 'comment', 'value']));

        $prestation = Prestation::findOrFail($request->get('prestation_id'));
        $prestation->consommations()->save($consommation);

        return redirect(route('purchase.show', ['id' => $consommation->purchase->id]))->with('success', 'Consommation mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consommation = Consommation::findOrFail($id);
        $consommation->delete();

        return redirect()->back()->with('success','Consommation supprimée');
    }


    private function redirectNoneConformConsommation($request, $updateId=0){
        $purchase = Purchase::findOrFail($request->get('purchase_id'));
        $prestationReference = Prestation::findOrFail($request->get('prestation_id'));

        $purchase->load('consommations');
        $purchase->load('product');

        $totalConsommation = 0;
        $totalQuantity = $purchase->product->value*$purchase->quantity;

        foreach($purchase->consommations as $consommation){
            $totalConsommation += $consommation->value;
        }

        if($updateId > 0){
            $totalConsommation = $totalConsommation - $purchase->consommations()->find($updateId)->value;
        }


        if(round($totalConsommation+$request->get('value'),2) > $totalQuantity){
            return 'Pointage refusé, valeur supérieure au reliquat';
        }

        if($purchase->created_at->gt(Carbon::createFromFormat('Y-m-d', $request->get('created_at')))){
            return 'Date invalide: pointage antérieur à l\'achat client';
        }

        if($request->get('value') > $prestationReference->duration) {
            return 'Pointage interdit: votre valeure est plus élévée que la référence indiquéé';
        }

        return null;
    }
}
