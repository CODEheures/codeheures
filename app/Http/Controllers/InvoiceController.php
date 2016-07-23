<?php

namespace App\Http\Controllers;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Common\InvoiceTools;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->auth = $auth;
    }

    public function get($type, $origin, $origin_id) {

        $invoiceTools = new InvoiceTools();
        $invoiceTools->setEntity($type, $origin, $origin_id);
        if($this->auth->user() == $invoiceTools->getOwnerUser() || $this->auth->user()->role == 'admin'){
            $existInvoice = $invoiceTools->setExistInvoice();
            if($existInvoice) {
                $fileName = $invoiceTools->getFileName();
                if(file_exists($fileName)){
                    return response(file_get_contents($fileName))
                        ->header('Content-Type', 'application/pdf');
                } else {
                    return redirect()->back()->withErrors('Le fichier de cette facture n\'existe pas');
                }
            } else {
                return redirect()->back()->withErrors('Cette facture n\'existe pas');
            }
        } else {
            return redirect()->back();
        }
    }
}
