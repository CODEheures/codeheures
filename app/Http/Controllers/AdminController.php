<?php

namespace App\Http\Controllers;


use App\Address;
use App\Common\DemoManager;

use App\Http\Requests\AdminCreateAccountRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;

use App\Purchase;
use \App\Common\DataGraph;
use App\Common\Credit;
use \App\Common\SmsFreeMobile;
use App\Http\Requests\UpdateCustomerQuotaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class AdminController extends Controller
{
    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->auth = $auth;
    }

    use DataGraph;
    use Credit;

    public function monitor(){
        $user = $this->auth->user();
        $purchases = Purchase::where(function($query) {
            $query->where('payed', '=', true)
                ->orWhere('quotation_id', '<>', 'null');
        })->orderBy('user_id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $purchases->load('product');
        $purchases->load(['consommations' => function($query){
            $query->orderBy('created_at');
        }]);


        //data pour le graphique conso
        $consommations = $this->consosAndtotalLeft($purchases)[0];
        //$consommations = Consommation::orderBy('created_at', 'DESC')->get();
        $data = $this->dataGraph($consommations);

        $customersList = User::where('role', '=', 'user')->get();

        return view('admin.monitor.index', compact('user', 'purchases', 'data', 'customersList'));
    }

    public function sms(){


        $sms = new SmsFreeMobile();

        /**
         * configure l'ID utilisateur et la clé disponible dans
         * le compte Free Mobile après avoir activé l'option.
         */

        $sms->setKey(env('FREE_SMS_PASS'))
            ->setUser(env("FREE_SMS_USER"));

        try {
            // envoi d'un message
            $sms->send("Hello World 1");
        } catch (\Exception $e) {
            // le monde n'est pas parfait, il y aura
            // peut-être des erreurs.
            echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
        }
        return redirect('/')->with('info', 'sms de test envoyé');

    }

    public function resetDemo(){
        $resetClass = new DemoManager();
        $resetClass->destroyDatas(true);
        return redirect(route('admin.monitor.index'))->with('info', 'reset des comptes démos effectué');
    }

    public function updateCustomerQuota(UpdateCustomerQuotaRequest $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only('quota'));
        return redirect()->back()->with('success', 'Quota de l\'utilisateur mis à jour');
    }

    public function customerActive($id) {
        $user = User::findOrFail($id);
        $user->is_admin_valid = true;
        $user->save();
        return redirect()->back()->with('success', 'Utilisateur desormais actif');
    }

    public function customerDesactive($id) {
        $user = User::findOrFail($id);
        $user->is_admin_valid = false;
        $user->save();
        return redirect()->back()->with('success', 'Utilisateur desormais inactif');
    }

    public function customerRegisterView() {
        return view('admin.cutomer.register');
    }

    public function customerRegisterPost(AdminCreateAccountRequest $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirmation_token = str_random(60);
        $user->new_create_by_admin = true;


        $request->has('firstName') ? $user->firstName = $request->firstName : null;
        $request->has('lastName') ? $user->lastName = $request->lastName : null;
        $request->has('enterprise') ? $user->enterprise = $request->enterprise : null;
        $request->has('siret') ? $user->siret = $request->siret : null;
        $request->has('phone') ? $user->phone = (str_replace('+33','0',str_replace('-','',filter_var($request->phone,FILTER_SANITIZE_NUMBER_INT)))) : null;

        $invoiceAddress = new Address();
        $invoiceAddress->type = 'invoice';
        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $invoiceAddress->address = $request->address;
        $invoiceAddress->zipCode = $request->zipCode;
        $invoiceAddress->town = $request->town;

        $request->has('complement') ? $invoiceAddress->complement = $request->complement : null;

        DB::beginTransaction();
        $user->save();
        $user->addresses()->saveMany([$invoiceAddress,$shippingAddress]);
        DB::commit();

        return redirect(route('admin.monitor.index'));

    }

    public function customerEditView($id) {
        $user = User::find($id);
        if($user){
            return view('admin.cutomer.edit', compact('user'));
        } else {
            return back()->withErrors('Id utilisateur invalide');
        }
    }

    public function customerUpdate($id, Requests\AdminEditAccountRequest $request) {
        $user = User::find($id);
        if($user){
            $address = Address::where('user_id', '=', $user->id)->where('type', '=', 'invoice')->first();

            $updates = $request->only(['email', 'name', 'phone', 'firstName', 'lastName', 'enterprise', 'siret']);
            $updates['phone'] = (str_replace('+33','0',str_replace('-','',filter_var($updates['phone'],FILTER_SANITIZE_NUMBER_INT))));
            if ($request->get('phone') == ""){
                $updates['phone']=null;
            }

            DB::beginTransaction();
            $user->update($updates);
            $address->update($request->only(['address', 'complement', 'zipCode', 'town']));
            DB::commit();

            return redirect(route('admin.monitor.index'))->with('success', 'utilisateur modifié');
        } else {
            return redirect(route('admin.monitor.index'))->withErrors('Probleme dans la mise à jour');
        }

    }

    public function testPdf() {
        $content = '
        <!DOCTYPE html>
        <html lang="en">
        <body>
        
        <div class="seller">
            <div class="from-seller">Designation du vendeur</div>
            <div class="infos">
                SAS <br />
                32 , s<br />
                SIRET: <br/>
                TVA n°:
            </div>
        </div>
        
        <div class="customer">
            <div class="to-customer">Designation du client</div>
            <div class="infos">
                <br />
                1 Rue-lès-, France
                <br />TVA n°:-/-
            </div>
        </div>
        
        <div class="invoice-title">
            <h2>Facture n°1:</h2>
            <div class="price">
                <div class="total-price">
                    Coût total: 58.80€ TTC
                </div>
            </div>
        </div>
        <div class="invoice">
            <table>
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix Ht</th>
                    <th>Quantité</th>
                    <th>TVA</th>
                    <th>Prix TTC</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Annonce urgente</td>
                    <td>49.00€</td>
                    <td>1</td>
                    <td>20%</td>
                    <td>58.80€</td>
                </tr>
                </tbody>
            </table>
            <p class="line-info">Cette facture contient 1 ligne.</p>
            <div class="invoice-total">
                <div class="invoice-total-title">
                    <p class="ht">Total HT</p>
                    <p class="tva">Total TVA</p>
                    <p class="ttc">Total TTC</p>
                </div>
                <div class="invoice-total-value">
                    <p class="ht">49.00€</p>
                    <p class="tva">9.80€</p>
                    <p class="ttc">58.80€</p>
                </div>
            </div></div>
        
        <div class="invoice-title">
            <h2>
                Facture acquitée le mercredi 22 mars 2017
            </h2>
        </div>
        </body>
        </html>
        ';

        $header = '
        <div class="pdfHeader">
        <div class="logo">
            <a href="http://destockeurope.progress/home" class="navbar-logo ">
                <img src="http://destockeurope.progress/images/logopdf.svg"/>
            </a>
        </div>
        
        <p class="navbar-menu">
            <a href="http://destockeurope.progress/home">Facture n°1<br/>
                <span class="created_at">
                        Emise le: mercredi 22 mars 2017
                    </span>
            </a>
        </p>
        
        </div>';

        $footer = '
        <div class="pdfFooter">
        <div class="infos">
            <p>
                SAS DestockEurope<br/>
                32 rue Gutenberg, 37300 Joué-Lès-Tours<br />
                06.87.34.06.83<br />
                contact@desctockeurope.com
            </p>
        </div>
        <div class="copyright">
            <p class="page">Page <span class="page">{PAGENO}</span> sur <span class="topage">{nbpg}</span></p>
            <div class="suiteLogo">
                <span class="htmlentity">&copy;</span>2017 DestockEurope<span class="logo"></span>
            </div>
        </div>
        </div>';

        $css = 'table a:link{color:#666}table a:link,table a:visited{font-weight:700;text-decoration:none}table a:visited{color:#999}table a:active,table a:hover{color:#bd5a35;text-decoration:underline}table caption{width:100%;text-align:left}table caption span{font-size:1rem}table{font-family:Arial,Helvetica,sans-serif;color:#666;font-size:1.2rem;text-shadow:.1rem .1rem 0 #fff;background:#eaebec;margin:2rem;border:none;border-radius:.3rem;box-shadow:0 .1rem .2rem #e1e1e1}table th{padding:2.1rem .8rem 2.2rem;border-top:.1rem solid #fafafa;border-bottom:.1rem solid #e0e0e0;background:#ededed;background:-webkit-linear-gradient(bottom,#ededed,#ebebeb);background:linear-gradient(0deg,#ededed,#ebebeb)}table th:first-child{text-align:left;padding-left:2rem}table tr:first-child th:first-child{border-top-left-radius:.3rem}table tr:first-child th:last-child{border-top-right-radius:.3rem}table tr{text-align:center;padding-left:2rem;display:table-row}table td:first-child{text-align:left;padding-left:2rem;border-left:0}table td{padding:.8rem;border-top:.1rem solid #fff;border-bottom:.1rem solid #e0e0e0;border-left:.1rem solid #e0e0e0;background:#fff}table tr.even td{background:#f6f6f6;background:-webkit-linear-gradient(bottom,#f8f8f8,#f6f6f6);background:linear-gradient(0deg,#f8f8f8,#f6f6f6)}table tr:last-child td{border-bottom:0}table tr:last-child td:first-child{border-bottom-left-radius:.3rem}table tr:last-child td:last-child{border-bottom-right-radius:.3rem}table tbody tr:hover td{background:#f2f2f2;background:-webkit-linear-gradient(bottom,#f2f2f2,#f0f0f0);background:linear-gradient(0deg,#f2f2f2,#f0f0f0)}body{background-color:transparent}body,div.pdfHeader{font-family:open sans,Helvetica Neue,Arial,sans-serif}div.pdfHeader{margin:0;padding-top:.3cm;padding-left:.3cm;padding-right:.3cm;width:100%;height:1.2cm;line-height:16px;background:rgba(34,34,34,.06);border-bottom:1px solid #32368c;font-size:10px;font-weight:100}div.pdfHeader div.logo{float:left;vertical-align:middle;width:2.5cm}div.pdfHeader div.logo .navbar-logo img{width:2.5cm;padding-bottom:.1cm}div.pdfHeader div.rubalise{width:100%;height:.4cm;padding-top:-.1cm;padding-bottom:-.1cm;background-size:contain;background-image:url("/images/rubalisepdf.svg")}div.pdfHeader .navbar-menu{float:right;text-align:right;overflow:hidden}div.pdfHeader .navbar-menu a{text-transform:uppercase;font-size:10px;margin:0 10px;position:relative;color:#222}div.pdfHeader .navbar-menu a span.created_at{position:relative;left:10px}div.seller div.from-seller{float:left;display:inline-block;width:180px}div.seller div.infos{float:left;padding-left:10px;margin-left:20px;border-left:1px solid #000}div.customer{padding-top:50px;margin-left:5cm}div.customer div.to-customer{float:left;display:inline-block;width:180px}div.customer div.infos{float:left;padding-left:10px;margin-left:20px;border-left:1px solid #000}div.invoice-title{margin-top:20px;line-height:40px}div.invoice-title h2{display:inline-block;font-size:18px}div.invoice-title div.price{float:right}div.invoice-title div.price div.total-price{width:5cm;float:right;margin-right:40px;padding:0 15px;border-radius:8px;border:1px solid #32368c;background-color:#32368c;color:#fff;text-align:center}div.invoice{padding-top:20px}div.invoice p{padding:0;font-weight:700}div.invoice p.line-info{font-size:12px;font-weight:100}div.invoice table{margin:0;width:100%;border:1px solid #b5b5b5;border-radius:6px}div.invoice table tr{page-break-inside:avoid;page-break-after:auto}div.invoice table tr td{text-align:right}div.invoice table td{page-break-inside:avoid;page-break-after:auto;font-size:12px}div.invoice table thead{display:table-header-group}div.invoice table thead tr th{font-size:14px;padding-top:5px;padding-bottom:5px}div.invoice div.invoice-total p:not(.ttc){font-weight:100}div.invoice div.invoice-total p.ttc{margin-top:10px;padding-top:5px}div.invoice div.invoice-total div.invoice-total-title{width:60%;display:inline-block;float:left;text-align:right}div.invoice div.invoice-total div.invoice-total-value{text-align:right;float:right;width:25%;display:inline-block;padding-right:20px}div.invoice div.invoice-total div.invoice-total-value p.ttc{border-top:2px solid #000}div.pdfFooter{margin:0;padding-top:.3cm;padding-left:.3cm;padding-right:.3cm;width:100%;height:1.2cm;font-size:10px;line-height:10px;background:rgba(34,34,34,.06);border-top:1px solid #222}div.pdfFooter .infos{width:30%;float:left}div.pdfFooter .infos i{padding-right:3px}div.pdfFooter .infos i:not(:first-of-type){padding-left:10px}div.pdfFooter .copyright{width:40%;float:right;position:relative;text-align:right;vertical-align:top}div.pdfFooter .copyright p.page{padding-bottom:.2cm}div.pdfFooter .copyright div.suiteLogo{float:right;vertical-align:top;height:1cm;width:3cm}';

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
        $storage = storage_path('app/testpdf.pdf');
        Storage::delete($storage);

        $mpdf->Output($storage, 'F');
        return response('Fichier ici: ' . $storage,200);
    }
}
