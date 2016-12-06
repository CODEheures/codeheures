<?php

namespace App\Common;

use App\Consommation;
use App\LineQuote;
use App\Product;
use App\Purchase;
use App\Quotation;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use App\Address;
use App\Prestation;
use App\Common\InvoiceTools;

Class DemoManager
{
    private $ip;
    private $email;
    private $name;
    private $nbDemoUsers;

    public function __construct($ip=null) {
        $this->ip = $ip;
        $this->nbDemoUsers = $this->countExistDemo();
        $this->email = 'demo' . $this->nbDemoUsers . env('DEMO_USER_MAIL');
        $this->name = env('DEMO_USER_NAME');
    }

    /**
     * @return User
     */
    private function isExistDemo() {
        $user = User::where('isDemo', '=', true)->where('ip', '=', $this->ip)->first();
        return $user;
    }

    public function countExistDemo() {
        $user = User::where('isDemo', '=', true)->count();
        return $user;
    }

    /**
     * @return User
     */
    public function getUser() {
        $user = $this->isExistDemo();
        if($user){
            return $user;
        } else {
            $user = $this->createDatas();
            return $user;
        }
    }

    public function destroyDatas($force=false) {
        $demoUsers = User::where('isDemo', '=', true)->get();
        foreach ($demoUsers as $demoUser){
            if(Carbon::now()->diffInMinutes($demoUser->created_at) >= env('DEMO_VALIDITY') || (auth()->check() &&  auth()->user()->role == 'admin' && $force == true)){
                $quotations = $demoUser->quotations;
                $purchases = $demoUser->purchases;
                $products = Product::where('reservedForUserId', '=', $demoUser->id);
                //deleting all
                foreach($quotations as $quotation){
                    //Effacement des fichiers pdf devis
                    $dir = storage_path() . env('STORAGE_QUOTATION_DEMO');
                    $file = $dir . $quotation->id . '-quotation.pdf';
                    $this->delFiles($file);

                    foreach ($quotation->invoices as $invoice){
                        //Effacement des factures
                        $dir = storage_path() . env('STORAGE_INVOICE_DEMO');
                        if($invoice->isDown) {
                            $type = 'isDown';
                        } elseif ($invoice->isSold) {
                            $type = 'isSold';
                        } elseif ($invoice->isIntermediate) {
                            $type = 'isIntermediate';
                        }
                        if(isset($type)){
                            $file = $dir . $invoice->demo_number . '-invoice-' . $type . $invoice->intermediateNumber . '.pdf';
                            $this->delFiles($file);
                        }
                    }
                    $quotation->invoices()->delete();
                    $quotation->lineQuotes()->delete();
                    $quotation->delete();
                }

                foreach($purchases as $purchase){
                    foreach ($purchase->consommations as $consommation) {
                        $prestation = Prestation::where('id', $consommation->prestation_id);
                        if($prestation){ $prestation->delete(); }
                    }
                    foreach ($purchase->invoices as $invoice){
                        //Effacement des factures
                        $dir = storage_path() . env('STORAGE_INVOICE_DEMO');
                        $invoice->isDown ? $type = 'isDown' : $type = 'isSold';
                        $file = $dir . $invoice->demo_number . '-invoice-' . $type .'.pdf';
                        $this->delFiles($file);
                    }
                    $purchase->consommations()->delete();
                    $purchase->invoices()->delete();
                    $purchase->delete();
                }
                $demoUser->addresses()->delete();
                $demoUser->delete();
                $products->delete();
                return null;
            }
        }
    }

    private function delFiles($file) {
        if(file_exists($file)){
            unlink($file);
        }
    }

    /**
     * @return User
     */
    private function createDatas() {

        $contrat = 'CODEheuresDemoContratCommercial0';
        //creation de l'utilisateur
        $fake = Factory::create('fr_FR');

        $passwd = str_random(14);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'isDemo' => true,
            'ip' => $this->ip,
            'password' => bcrypt($passwd),
            'lastName' => $fake->lastName,
            'firstName' => $fake->firstName,
            'enterprise' => 'SAS ' . $fake->company,
            'siret' => '28652145210001'
        ]);

        $user->confirmed = true;
        $user->is_admin_valid = true;
        $user->quota = 15;

        $invoiceAddress = new Address();
        $invoiceAddress->type = 'invoice';
        $invoiceAddress->address = $fake->streetAddress;
        $invoiceAddress->complement = 'BP525';
        $invoiceAddress->zipCode = $fake->postcode;
        $invoiceAddress->town = $fake->city;

        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $user->save();
        $user->addresses()->saveMany([$invoiceAddress,$shippingAddress]);


        //création des produits
        $product2 = Product::create([
            'description' => '5 h de webmastering',
            'type' => 'time',
            'value' => 5,
            'price' => 24000,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product4 = Product::create([
            'description' => '150h de webmastering pour creation e-commerce selon cahier des charge founi',
            'type' => 'time',
            'value' => 150,
            'price' => 400000,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product5 = Product::create([
           'description' => '1 theme baby kid store Prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 7999,
            'url' => 'http://addons.prestashop.com/demo/FO15619.html',
            'reservedForUserId' => $user->id
        ]);

        $product6 = Product::create([
            'description' => '1 module Mercanet BNP prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 14999,
            'url' => 'http://addons.prestashop.com/fr/22144-bnp-paribas-mercanet-officiel.html',
            'reservedForUserId' => $user->id
        ]);

        $product7 = Product::create([
            'description' => '1 module Paiement ATOS prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 19999,
            'url' => 'http://addons.prestashop.com/fr/1-sips-atos-worldine.html',
            'reservedForUserId' => $user->id
        ]);

        //3 Achats effectués
        $purchase1 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 1
        ]);
        $purchase1->created_at = Carbon::now()->subDay(15);
        $purchase1->updated_at = Carbon::now()->subDay(15);
        $purchase1->save();

        //creation des prestations standard demo
        $prestation1 = Prestation::create([
            'name' => 'changer une image',
            'description' => 'changer une image par une autre fournie par le client',
            'duration' => 0.1,
            'isPublished' => true,
            'isObsolete' => true
        ]);

        $prestation2 = Prestation::create([
            'name' => 'changer un texte',
            'description' => 'changer une texte par un autre fourni par le client',
            'duration' => 0.2,
            'isPublished' => true,
            'isObsolete' => true
        ]);

        $prestation3 = Prestation::create([
            'name' => 'changement theme prestation',
            'description' => 'changer le theme d\'un site prestashop (achat non inclu)',
            'duration' => 2.5,
            'isPublished' => true,
            'isObsolete' => true
        ]);

        $prestation4 = Prestation::create([
            'name' => 'mettre des tarifs à jour',
            'description' => 'mise à jour des tarifs (jusqu\'à 100 articles)',
            'duration' => 2,
            'isPublished' => true,
            'isObsolete' => true
        ]);


        //Consommation de l'achat n°1
        $consommation11 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 0.25,
            'comment' => 'changer 3 photos sur le site',
            'prestation_id' => $prestation1->id,
            'ratio_prestation' => 3
        ]);
        $consommation11->created_at = Carbon::now()->subDay(2);
        $consommation11->updated_at = Carbon::now()->subDay(2);
        $consommation11->save();

        $consommation12 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 2.1,
            'comment' => 'changer le theme de la boutique prestashop',
            'prestation_id' => $prestation3->id
        ]);
        $consommation12->created_at = Carbon::now()->subDay(4);
        $consommation12->updated_at = Carbon::now()->subDay(4);
        $consommation12->save();

        $consommation13 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 0.2,
            'comment' => 'changer le texte de la page d\'accueil',
            'prestation_id' => $prestation2->id
        ]);
        $consommation13->created_at = Carbon::now()->subDay(6);
        $consommation13->updated_at = Carbon::now()->subDay(6);
        $consommation13->save();

        $consommation14 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 1.9,
            'comment' => 'mise à jour des tarifs',
            'prestation_id' => $prestation4->id
        ]);
        $consommation14->created_at = Carbon::now()->subDay(7);
        $consommation14->updated_at = Carbon::now()->subDay(7);
        $consommation14->save();

        $consommation15 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 0.05,
            'comment' => 'mise à jour photo',
            'prestation_id' => $prestation1->id
        ]);
        $consommation15->created_at = Carbon::now()->subDay(7);
        $consommation15->updated_at = Carbon::now()->subDay(7);
        $consommation15->save();


        //Devis n°1
        $quotation1 = Quotation::create([
            'user_id' => $user->id,
            'isPublished' => true,
            'downPercentPayment' => 30
        ]);
        $quotation1->created_at = Carbon::now()->subDays(15);
        $quotation1->updated_at = Carbon::now()->subDays(15);
        $quotation1->validity = Carbon::now()->subDays(15)->addMonth(1)->format('Y-m-d');
        $quotation1->file = $contrat;
        $quotation1->save();

        $lineQuote1 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product4->id,
            'quantity' => 1,
        ]);
        $lineQuote1->created_at = Carbon::now()->subDays(15);
        $lineQuote1->updated_at = Carbon::now()->subDays(15);
        $lineQuote1->save();

        $lineQuote2 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product5->id,
            'quantity' => 1,
            'discount' => 0,
            'discount_type' => 'devise'
        ]);
        $lineQuote2->created_at = Carbon::now()->subDays(15);
        $lineQuote2->updated_at = Carbon::now()->subDays(15);
        $lineQuote2->save();

        $lineQuote3 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product6->id,
            'quantity' => 1,
            'discount' => 0,
            'discount_type' => 'percent'
        ]);
        $lineQuote3->created_at = Carbon::now()->subDays(15);
        $lineQuote3->updated_at = Carbon::now()->subDays(15);
        $lineQuote3->save();


        //Devis n°2
        $quotation2 = Quotation::create([
            'user_id' => $user->id,
            'isPublished' => true,
            'downPercentPayment' => 30
        ]);
        $quotation2->created_at = Carbon::now()->subDays(11);
        $quotation2->updated_at = Carbon::now()->subDays(11);
        $quotation2->validity = Carbon::now()->subDays(11)->addMonth(1)->format('Y-m-d');
        $quotation2->file = $contrat;
        $quotation2->save();

        $lineQuote4 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'discount' => 300,
            'discount_type' => 'percent'
        ]);
        $lineQuote4->created_at = Carbon::now()->subDays(11);
        $lineQuote4->updated_at = Carbon::now()->subDays(11);
        $lineQuote4->save();

        $lineQuote5 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product5->id,
            'quantity' => 1,
            'discount' => 0,
            'discount_type' => 'percent'
        ]);
        $lineQuote5->created_at = Carbon::now()->subDays(11);
        $lineQuote5->updated_at = Carbon::now()->subDays(11);
        $lineQuote5->save();

        $lineQuote5 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product7->id,
            'quantity' => 1,
            'discount' => 0,
            'discount_type' => 'percent'
        ]);
        $lineQuote5->created_at = Carbon::now()->subDays(11);
        $lineQuote5->updated_at = Carbon::now()->subDays(11);
        $lineQuote5->save();

        return $user;
    }
}