<?php

namespace App\Common;

use App\Invoice;
use App\Purchase;
use Carbon\Carbon;
use App\Quotation;
use Mpdf\Mpdf;
use PayPal\Api\Payment;
use Illuminate\Contracts\Mail\Mailer;


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
    private $_intermediateNumber=null;
    private $_invoice;
    private $mailer;


    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
        $this->_isDemoUser = true;
    }

    public function setApiContext ($api_context) {
        $this->_api_context = $api_context;
    }

    /**
     * @param $type
     * @param $origin
     * @param $origin_id
     * @return boolean
     * @throws \Exception
     */
    public function setEntity($type, $origin, $origin_id, $intermediateNumber) {
        if ($type != 'isDown' && $type != 'isSold' && $type != 'isIntermediate') {
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
            if($intermediateNumber){
                $this->_intermediateNumber=$intermediateNumber;
            }
            if(!$this->_entity_user->isDemo) {
                $this->_isDemoUser = false;
            } else {
                $this->_isDemoUser = true;
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
            $this->_storage = storage_path() . env('STORAGE_INVOICE');
            $fileName = $this->_storage . $this->_invoice->number . $this->_postName . $this->_intermediateNumber . $this->_ext;
        } else {
            $this->_storage = storage_path() . env('STORAGE_INVOICE_DEMO');
            $fileName = $this->_storage . $this->_invoice->demo_number . $this->_postName . $this->_intermediateNumber . $this->_ext;
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
                if(!$this->_intermediateNumber){
                    $this->_invoice = $invoice;
                    return true;
                } else {
                    if($invoice->intermediateNumber == $this->_intermediateNumber){
                        $this->_invoice = $invoice;
                        return true;
                    }
                }
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

    public function sendMail($type=null, $origin=null, $origin_id=null, $intermediateNumber=null) {
        if($type==null && $origin==null && $origin_id==null) {
            $existInvoice = $this->_invoice;
        } else {
            try {
                $this->setEntity($type, $origin, $origin_id, $intermediateNumber);
            } catch (\Exception $e) {
                throw new \Exception('Probleme dans l\'envoi du mail de la facture');
            }
            $existInvoice = $this->setExistInvoice();
        }
        if($existInvoice) {
            $fileName =  $this->getFileName();
            if(file_exists($fileName)){
                $user = $this->_entity_user;
                $invoice = $this->_invoice;
                if($this->_origin == 'quotation'){
                    $quotation = $this->_entity;
                    $quotation->load('purchases');
                    $isAdmin = false;
                    $this->mailer->send(['text' => 'emails.quotation.invoice.text-confirm', 'html' => 'emails.quotation.invoice.html-confirm'], compact('user', 'quotation', 'type', 'isAdmin', 'invoice'), function($message) use($user, $quotation, $fileName){
                        $message->to($user->email);
                        $message->subject('Votre achat sur ' . env('APP_NAME'));
                        $message->attach($fileName);
                    });
                    $isAdmin = true;
                    $this->mailer->send(['text' => 'emails.quotation.invoice.text-confirm', 'html' => 'emails.quotation.invoice.html-confirm'], compact('user', 'quotation', 'type', 'isAdmin','invoice'), function($message) use($user, $quotation, $fileName, $invoice){
                        $message->to(env('INVOICE_MAIL_ADMIN'));
                        $message->subject('Facture ' . $invoice->number .' envoyée pour ' . $user->email);
                        $message->attach($fileName);
                    });
                    //tracabilité des mails
                    $mails = json_decode($this->_invoice->mails,true);
                    $mails ? null:$mails=array();
                    $newMail = [
                        'userMail' => $user->email,
                        'date' => Carbon::now()
                    ];
                    array_push($mails, $newMail);
                    $this->_invoice->mails = json_encode($mails);
                    $this->_invoice->save();
                } elseif ($this->_origin == 'purchase') {
                    $purchase = $this->_entity;
                    $isAdmin = false;
                    $this->mailer->send(['text' => 'emails.sale.text-confirm', 'html' => 'emails.sale.html-confirm'], compact('user', 'purchase', 'isAdmin'), function($message) use($user, $purchase, $fileName){
                        $message->to($user->email);
                        $message->subject('Votre achat sur ' . env('APP_NAME'));
                        $message->attach($fileName);
                    });
                    $isAdmin = true;
                    $this->mailer->send(['text' => 'emails.sale.text-confirm', 'html' => 'emails.sale.html-confirm'], compact('user', 'purchase', 'isAdmin','invoice'), function($message) use($user, $purchase, $fileName, $invoice){
                        $message->to(env('INVOICE_MAIL_ADMIN'));
                        $message->subject('Facture ' . $invoice->number .' envoyée pour nouvel Achat direct par ' . $user->email);
                        $message->attach($fileName);
                    });
                    //tracabilité des mails
                    $mails = json_decode($this->_invoice->mails,true);
                    $mails ? null:$mails=array();
                    $newMail = [
                        'userMail' => $user->email,
                        'date' => Carbon::now()
                    ];
                    array_push($mails, $newMail);
                    $this->_invoice->mails = json_encode($mails);
                    $this->_invoice->save();
                }
            } else {
                throw new \Exception('Envoi email de la facture impossible. Le fichier de cette facture n\'existe pas');
            }
        } else {
            throw new \Exception('Envoi email de la facture impossible. Cette facture n\'existe pas');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create($type, $origin, $origin_id, $isPayed=false, $percent=100, $intermediateNumber=null) {

        //Entité qui porte la création de la facture
        try {
            $this->setEntity($type, $origin, $origin_id, $intermediateNumber);
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
        $invoice->intermediateNumber = $this->_intermediateNumber;
        $fillable_origin = $this->_origin . '_id';
        $invoice->$fillable_origin = $this->_entity->id;
        $invoice->isPayed = $isPayed;
        $invoice->percent = $percent;

        if($this->_type!='isSold'){
            $invoice->amountHT = $this->_entity->totalPercent(false, $invoice->percent);
            $invoice->amountTTC = $this->_entity->totalPercent(true, $invoice->percent);
        } else {
            if($this->_origin == 'quotation') {
                $invoice->amountHT = $this->_entity->totalSoldPrice();
                $invoice->amountTTC = $this->_entity->totalSoldPrice(true);
            }  elseif ($this->_origin == 'purchase') {
                $paymentId = json_decode($this->_entity->paypal_result)->id;
                $payment = Payment::get($paymentId, $this->_api_context);
                $totalTVA = 0;
                foreach($payment->getTransactions()[0]->getItemList()->getItems() as $item) {
                    $totalTVA = $totalTVA + $item->getTax() * $item->getQuantity();
                }
                $invoice->amountTTC = (int)($payment->getTransactions()[0]->getAmount()->getTotal()*100);
                $invoice->amountHT = (int)($invoice->amountTTC - $totalTVA*100);
            }
        }
        $invoice->save();
        $this->_invoice = $invoice;

        $fileName = $this->getFileName();
        if($this->_origin == 'quotation') {
            if ($this->_entity->isOrdered) {
                $this->_entity->load('lineQuotes');
                $this->_entity->load('invoices');
                try {
                    $entity = $this->_entity;
                    $content = view('pdf.quotation.invoice.index', compact('entity', 'invoice'))->__toString();
                    $header = view('pdf.header.view', compact('entity', 'invoice'))->__toString();
                    $footer = view('pdf.footer.view')->__toString();
                    $this->createPdf($content, $header, $footer, $fileName);
                    return $fileName;
                } catch (\Exception $e) {
                    $this->_invoice->delete();
                    throw new \Exception('Probleme dans la création de la facture PDF.');
                }
            } else {
                throw new \Exception('Facturation interdite. Devis non signé');
            }
        } elseif ($this->_origin == 'purchase') {
            try {
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

    public function validatePayment($type, $origin, $origin_id, $intermediateNumber=null) {
        try {
            $this->setEntity($type, $origin, $origin_id, $intermediateNumber);
            $existInvoice = $this->setExistInvoice();
        } catch (\Exception $e) {
            throw new \Exception('Probleme dans l\'envoi du mail de la facture');
        }
        if($existInvoice) {
            $this->_invoice->isPayed = true;
            $this->_invoice->save();
            return true;
        }
        return false;
    }

    private function createPdf($content, $header, $footer, $fileName) {
        try {
            $css = file_get_contents(asset(mix('css/pdf.css')->toHtml()),false,stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));

            $mpdf = new mPDF();
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
