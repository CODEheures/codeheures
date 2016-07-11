<?php

namespace App\Http\Controllers;

use App\Common\UserList;
use App\Common\ListEnum;
use App\Http\Requests\ProductRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{

    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => []]);
        $this->auth = $auth;
    }

    use UserList;
    use ListEnum;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('description', 'DESC')->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
        $userList = UserList::userList();
        $listEnumProductType = $this->getEnumValues('products', 'type');
        $listUnits = [''];
        $listUnits  = $listUnits + $this->getEnumValues('products', 'unit');
        return view('admin.product.create', compact('product', 'userList', 'listEnumProductType', 'listUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->only(['description', 'type', 'unit', 'value', 'price', 'reservedForUserId', 'url']));
        return redirect(route('admin.product.index'))->with('success', 'Modifications enregistrées');
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
        $product = Product::findOrFail($id);
        $product->load('lineQuotes');
        $userList = UserList::userList();
        $listEnumProductType = $this->getEnumValues('products', 'type');
        $listUnits = [''];
        $listUnits  = $listUnits + $this->getEnumValues('products', 'unit');
        return view('admin.product.edit', compact('product', 'userList', 'listEnumProductType', 'listUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        //dd($request->all());
        $product = Product::findOrFail($id);
        if($product->canEdit()){
            $product->update($request->only(['description', 'type', 'unit', 'value', 'price', 'reservedForUserId', 'url']));
            return redirect()->back()->with('success', 'Modifications enregistrées');
        }

        return redirect()->back()->withErrors('Interdiction de modifier ce produit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->canEdit()){
            $product->delete();
            return redirect(route('admin.product.index'))->with('success', 'Produit supprimé');
        }

        return redirect()->back()->withErrors('Interdiction de modifier ce produit');
    }

    public function toObsolete($id) {
        $product = Product::findOrFail($id);
        if(!$product->isObsolete){
            $product->isObsolete = true;
            $product->save();
            return redirect()->back()->with('success', 'Produit marqué comme obsolete');
        }

        return redirect()->back()->withErrors('Interdiction de modifier ce produit');
    }

    public function toNotObsolete($id) {
        $product = Product::findOrFail($id);
        if($product->isObsolete){
            $product->isObsolete = false;
            $product->save();
            return redirect()->back()->with('success', 'Produit marqué comme non obsolete');
        }

        return redirect()->back()->withErrors('Interdiction de modifier ce produit');
    }

}
