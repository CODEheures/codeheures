<?php

namespace App\Common;

use App\Consommation;
use App\LineQuote;
use App\Product;
use App\Purchase;
use App\Quotation;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use App\Address;
use App\Prestation;
use App\Common\InvoiceTools;

Class ResetDemo
{
    private $email;
    private $name;
    private $demouser;

    public function __construct() {
        $this->email = env('DEMO_USER_MAIL');
        $this->name = env('DEMO_USER_NAME');
    }

    public function reset() {
        $reset = false;
        $this->demoUser = User::where('email','=', $this->email)->first();

        //Condition du reset
        //1°) Si les devis ont été signés ou refusé
        foreach($this->demouser->quotations as $quotation){
            if($quotation->isOrdered || $quotation->isRefused){
                $reset = true;
            }
        }

        //2°) si le user a un numero de tel dans son profil
        if($this->demouser->phone){
            $reset = true;
        }

        //3°) Si un achat a été fait
        if(count($this->demouser->purchases)>1){
            $reset = true;
        }

        if($reset){
            $this->destroyDatas($this->demouser);
            $this->createDatas($this->email, $this->name);
        }
    }

    private function destroyDatas($demoUser) {
        $quotations = $demoUser->quotations;
        $purchases = $demoUser->purchases;
        $products = Product::where('reservedForUserId', '=', $demoUser->id);
        //deleting all
        foreach($quotations as $quotation){
            $quotation->invoices()->delete();
            $quotation->lineQuotes()->delete();
            $quotation->delete();
        }
        foreach($purchases as $purchase){
            foreach ($purchase->consommations as $consommation) {
                $prestation = Prestation::where('id', $consommation->prestation_id);
                if($prestation){ $prestation->delete(); }
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

    private function createDatas($email, $name) {

        //creation de l'utilisateur
        $fake = Factory::create('fr_FR');

        $passwd = str_random(14);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($passwd),
            'lastName' => $fake->lastName,
            'firstName' => $fake->firstName,
            'enterprise' => 'SAS ' . $fake->company,
            'siret' => '28652145210001',
            'phone' => '695022010'
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
            'price' => 240,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product4 = Product::create([
            'description' => '150h de webmastering pour creation e-commerce selon cahier des charge founi',
            'type' => 'time',
            'value' => 150,
            'price' => 4000,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product5 = Product::create([
           'description' => '1 theme baby kid store Prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 79.99,
            'url' => 'http://addons.prestashop.com/demo/FO15619.html',
            'reservedForUserId' => $user->id
        ]);

        $product6 = Product::create([
            'description' => '1 module Mercanet BNP prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 149.99,
            'url' => 'http://addons.prestashop.com/fr/22144-bnp-paribas-mercanet-officiel.html',
            'reservedForUserId' => $user->id
        ]);

        $product7 = Product::create([
            'description' => '1 module Paiement ATOS prestashop',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 199.99,
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
            'downPercentPayment' => 5
        ]);
        $quotation1->created_at = Carbon::now()->subDays(15);
        $quotation1->updated_at = Carbon::now()->subDays(15);
        $quotation1->validity = Carbon::now()->subDays(15)->addMonth(1)->format('Y-m-d');
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
        ]);
        $quotation2->created_at = Carbon::now()->subDays(11);
        $quotation2->updated_at = Carbon::now()->subDays(11);
        $quotation2->validity = Carbon::now()->subDays(11)->addMonth(1)->format('Y-m-d');
        $quotation2->save();

        $lineQuote4 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'discount' => 2.5,
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

        return null;
    }
}