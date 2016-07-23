<?php

namespace App\Common;

use App\Invoice;
use App\LineQuote;
use App\Product;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Quotation;
use PayPal\Api\Payment;

class InvoiceTools
{

    private $_api_context;
    private $_storage;
    private $_postName;
    private $_ext;
    private $_isDemoUser;
    private $_type;
    private $_origin;
    private $_entity;
    private $_entity_user;
    private $_invoice;


    public function __construct($api_context = null) {
        $this->_api_context = $api_context;
        $this->_isDemoUser = true;
    }

    /**
     * @param $type
     * @param $origin
     * @param $origin_id
     * @return boolean
     * @throws \Exception
     */
    public function setEntity($type, $origin, $origin_id) {
        if ($type != 'isDown' && $type != 'isSold') {
            throw new \Exception('Ce type de facturation n\'existe pas.');
        } else {
            $this->_type = $type;
        }

        if ($origin != 'quotation' && $origin != 'purchase') {
            throw new \Exception('Ce objet de facturation n\'existe pas.');
        } else {
            $this->_origin = $origin;
        }

        //Entité qui porte la création de la facture
        try {
            if($this->_origin == 'quotation') {
                $entity = Quotation::findOrFail($origin_id);
            } elseif ($this->_origin == 'purchase') {
                $entity = Purchase::findOrFail($origin_id);
            }

            $this->_entity = $entity;
            $this->_entity->load('user');
            $this->_entity_user = $entity->user;
            if($this->_entity_user->email != env('DEMO_USER_MAIL')) {
                $this->_isDemoUser = false;
            }


            return true;

        } catch (\Exception $e) {
            throw new \Exception('L\'objet de votre facture n\'existe pas.');
        }
    }


    /**
     * @param string
     */
    public function getFileName() {
        $this->_postName = '-invoice-' . $this->_type;
        $this->_ext = '.pdf';

        if(!$this->_isDemoUser) {
            $this->_storage = storage_path() . '/pdf/invoice/';
            $fileName = $this->_storage . $this->_invoice->number . $this->_postName . $this->_ext;
        } else {
            $this->_storage = storage_path() . '/pdf/demo_invoice/';
            $fileName = $this->_storage . $this->_invoice->demo_number . $this->_postName . $this->_ext;
        }
        return $fileName;
    }


    public function getOwnerUser() {
        return $this->_entity_user;
    }

    /**
     * @return boolean
     */
    public function setExistInvoice() {
        $this->_entity->load('invoices');
        foreach ($this->_entity->invoices as $invoice) {
            $invoiceType = $this->_type;
            if ($invoice->$invoiceType == true) {
                $this->_invoice = $invoice;
                return true;
            }
        }
        return false;
    }

    /**
     * return integer
     */
    private function getNextNumber() {
        if(!$this->_isDemoUser) {
            $getInvoiceWithMaxNumber = Invoice::orderBy('number', 'desc')->first();
            if($getInvoiceWithMaxNumber) {
                $nextNumber = $getInvoiceWithMaxNumber->number + 1;
            } else {
                $nextNumber = 1;
            }
        } else {
            $getInvoiceWithMaxNumber = Invoice::orderBy('demo_number', 'desc')->first();
            if($getInvoiceWithMaxNumber) {
                $nextNumber = $getInvoiceWithMaxNumber->demo_number + 1;
            } else {
                $nextNumber = 1;
            }
        }
        return $nextNumber;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create($type, $origin, $origin_id, $isPayed=false) {

        //Entité qui porte la création de la facture
        try {
            $this->setEntity($type, $origin, $origin_id);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        //Test de l'existance de la facture
        $existInvoice = $this->setExistInvoice();
        if($existInvoice) {
            return $this->getFileName();
        }

        //Creation du fichier PDF selon le cas
        $nextNumber = $this->getNextNumber();

        $invoice = new Invoice;
        if(!$this->_isDemoUser) {
            $invoice->number = $nextNumber;
        } else {
            $invoice->number = 0;
            $invoice->demo_number = $nextNumber;
        }
        $invoice->origin = $this->_origin;
        $invoiceType = $this->_type;
        $invoice->$invoiceType = true;
        $fillable_origin = $this->_origin . '_id';
        $invoice->$fillable_origin = $this->_entity->id;
        $invoice->isPayed = $isPayed;
        $invoice->save();
        $this->_invoice = $invoice;

        $fileName = $this->getFileName();
        if($this->_origin == 'quotation') {
            if ($this->_entity->isOrdered) {
                $this->_entity->load('lineQuotes');
                $totalPrice = $this->totalPrice($this->_entity);
                $totalTva = $this->totalPrice($this->_entity, true);
                if($this->_type == 'isDown') {
                    if($this->_entity->haveDownPercent()) {
                        try {
                            $entity = $this->_entity;
                            $content = view('pdf.quotation.invoice.index', compact('entity', 'totalPrice', 'totalTva', 'invoice'))->__toString();
                            $header = view('pdf.header.view', compact('entity', 'invoice'))->__toString();
                            $footer = view('pdf.footer.view')->__toString();
                            $this->createPdf($content, $header, $footer, $fileName);
                            return $fileName;
                        } catch (\Exception $e) {
                            $this->_invoice->delete();
                            throw new \Exception('Probleme dans la création de la facture PDF.');
                        }
                    } else {
                        throw new \Exception('Pas d\'accompte à facturer sur ce devis');
                    }
                } elseif ($this->_type == 'isSold') {
                    if($this->_entity->haveDownPercent()) {
                        $haveDown = true;
                    } else {
                        $haveDown= false;
                    }
                    try {
                        $entity = $this->_entity;
                        $content = view('pdf.quotation.invoice.index', compact('entity', 'totalPrice', 'totalTva', 'invoice', 'haveDown'))->__toString();
                        $header = view('pdf.header.view', compact('entity', 'invoice'))->__toString();
                        $footer = view('pdf.footer.view')->__toString();
                        $this->createPdf($content, $header, $footer, $fileName);
                        return $fileName;
                    } catch (\Exception $e) {
                        $this->_invoice->delete();
                        throw new \Exception('Probleme dans la création de la facture PDF');
                    }
                }
            } else {
                throw new \Exception('Facturation interdite. Devis non signé');
            }
        } elseif ($this->_origin == 'purchase') {
            try {
                $paymentId = json_decode($this->_entity->paypal_result)->id;
                $payment = Payment::get($paymentId, $this->_api_context);
                $entity = $this->_entity;
                $content = view('pdf.purchase.invoice.index', compact('payment', 'entity', 'invoice'))->__toString();
                $header = view('pdf.header.view', compact('entity', 'invoice'))->__toString();
                $footer = view('pdf.footer.view')->__toString();
                $this->createPdf($content, $header, $footer, $fileName);
                return $fileName;
            } catch (\Exception $e) {
                $this->_invoice->delete();
                throw new \Exception('Probleme dans la création de la facture PDF' . $e);
            }
        }
    }

    public function validatePayment($id) {
        dd($id);
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

    private function createPdf($content, $header, $footer, $fileName) {
        try {
            $css = file_get_contents(asset('css/pdf.min.css'));

            $mpdf = new \mPDF();
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
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
            $mpdf->Output($fileName, 'F');
            return true;
        } catch (\Exception $e) {
            Throw new \Exception($e);
        }
    }
}
