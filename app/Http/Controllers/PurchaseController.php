<?php

namespace App\Http\Controllers;

use App\Prestation;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Common\DataGraph;

class PurchaseController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::findOrFail($id);
        if($this->auth->user()->role =='admin' || $purchase->user->id == $this->auth->user()->id){
            $purchase->load('product');
            $purchase->load('consommations');
            $purchase->load('user');

            $totalLeft=0;
            $data = [];
            $conso = [];
            $prestations= [];
            

            if($purchase->product->type=='time'){
                $totalQuantity = $purchase->product->value*$purchase->quantity;
                $totalConsommation = 0;
                foreach($purchase->consommations as $consommation){
                    $totalConsommation += $consommation->value;
                }
                $totalLeft = round($totalQuantity-round($totalConsommation,2),2);


                foreach($purchase->consommations as $consommation){
                    $totalConsommation += $consommation->value;
                }

                $prestations[0] = 'Aucun';
                $prestationsDatas= Prestation::where('isObsolete', '=', 'false')->orderBy('name')->Lists('name', 'id');
                $prestations = $prestations + $prestationsDatas->toArray();

            } else {
                $totalQuantity = $purchase->quantity;
                $totalConsommation = 0;
                foreach($purchase->consommations as $consommation){
                    $totalConsommation += $consommation->value;
                }
                $totalLeft = round($totalQuantity-round($totalConsommation,2),2);
            }

            $data = $this->dataGraph($purchase->consommations);

            return view('purchase.show', compact('purchase','data', 'totalLeft', 'prestations'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
