<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class PurchaseController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('haveNewQuotation');
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
            if($purchase->product->type=='time'){
                $totalQuantity = $purchase->product->value*$purchase->quantity;
                $totalConsommation = 0;
                foreach($purchase->consommations as $consommation){
                    $totalConsommation += $consommation->value;
                }
                $totalLeft = round($totalQuantity-round($totalConsommation,1),1);

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
            return view('purchase.show', compact('purchase','data', 'totalLeft'));
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
