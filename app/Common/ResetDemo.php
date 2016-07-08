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

Class ResetDemo
{
    private $email;
    private $name;

    public function __construct() {
        $this->email = env('DEMO_USER_MAIL');
        $this->name = env('DEMO_USER_NAME');
    }

    public function reset() {
        $this->destroyDatas($this->email);
        $this->createDatas($this->email, $this->name);
    }

    private function destroyDatas($email) {

        //recherche du user demo
        $demoUser = User::where('email','=', $email)->first();
        $quotations = $demoUser->quotations;
        $purchases = $demoUser->purchases;
        $products = Product::where('reservedForUserId', '=', $demoUser->id);
        //deleting all
        foreach($quotations as $quotation){
            $quotation->lineQuotes()->delete();
            $quotation->delete();
        }
        foreach($purchases as $purchase){
            $purchase->consommations()->delete();
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

        $billingAddress = new Address();
        $billingAddress->type = 'billing';
        $billingAddress->address = $fake->streetAddress;
        $billingAddress->complement = 'BP525';
        $billingAddress->zipCode = $fake->postcode;
        $billingAddress->town = $fake->city;

        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $user->save();
        $user->addresses()->saveMany([$billingAddress,$shippingAddress]);


        //création des produits
        $product1 = Product::create([
            'description' => '1 h de webmastering',
            'type' => 'time',
            'value' => 1,
            'price' => 60,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product2 = Product::create([
            'description' => '5 h de webmastering',
            'type' => 'time',
            'value' => 5,
            'price' => 240,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product3 = Product::create([
            'description' => '10 h de webmastering',
            'type' => 'time',
            'value' => 10,
            'price' => 399,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product4 = Product::create([
            'description' => '150h de webmastering pour creation e-commerce',
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
            'product_id' => $product3->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 1
        ]);
        $purchase1->created_at = Carbon::now()->subDay(15);
        $purchase1->updated_at = Carbon::now()->subDay(15);
        $purchase1->save();

        $purchase2 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 1
        ]);
        $purchase2->created_at = Carbon::now()->subDay(32);
        $purchase2->updated_at = Carbon::now()->subDay(32);
        $purchase2->save();

        $purchase3 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 3
        ]);
        $purchase3->created_at = Carbon::now()->subDay(58);
        $purchase3->updated_at = Carbon::now()->subDay(58);
        $purchase3->save();


        //Consommation de l'achat n°1
        $consommation11 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 1.5,
            'comment' => 'ajoute photos et commentaires'
        ]);
        $consommation11->created_at = Carbon::now()->subDay(2);
        $consommation11->updated_at = Carbon::now()->subDay(2);
        $consommation11->save();

        $consommation12 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 2,
            'comment' => 'ajoute d\'une page prestataire'
        ]);
        $consommation12->created_at = Carbon::now()->subDay(4);
        $consommation12->updated_at = Carbon::now()->subDay(4);
        $consommation12->save();


        //Consommations achat n°2
        $consommation21 = Consommation::create([
            'purchase_id' => $purchase2->id,
            'value' => 4,
            'comment' => 'refonte de la page d\'accueil'
        ]);
        $consommation21->created_at = Carbon::now()->subDay(18);
        $consommation21->updated_at = Carbon::now()->subDay(18);
        $consommation21->save();

        $consommation22 = Consommation::create([
            'purchase_id' => $purchase2->id,
            'value' => 0.2,
            'comment' => 'correction de texte'
        ]);
        $consommation22->created_at = Carbon::now()->subDay(21);
        $consommation22->updated_at = Carbon::now()->subDay(21);
        $consommation22->save();

        $consommation23 = Consommation::create([
            'purchase_id' => $purchase2->id,
            'value' => 0.8,
            'comment' => 'mise à jour photo'
        ]);
        $consommation23->created_at = Carbon::now()->subDay(32);
        $consommation23->updated_at = Carbon::now()->subDay(32);
        $consommation23->save();


        //Consommation achat n°3
        $consommation31 = Consommation::create([
            'purchase_id' => $purchase3->id,
            'value' => 0.8,
            'comment' => 'mise à jour photo'
        ]);
        $consommation31->created_at = Carbon::now()->subDay(37);
        $consommation31->updated_at = Carbon::now()->subDay(37);
        $consommation31->save();

        $consommation32 = Consommation::create([
            'purchase_id' => $purchase3->id,
            'value' => 1.5,
            'comment' => 'gestion des utilisateurs'
        ]);
        $consommation32->created_at = Carbon::now()->subDay(48);
        $consommation32->updated_at = Carbon::now()->subDay(48);
        $consommation32->save();

        $consommation33 = Consommation::create([
            'purchase_id' => $purchase3->id,
            'value' => 0.7,
            'comment' => 'mise à jour page 2'
        ]);
        $consommation33->created_at = Carbon::now()->subDay(58);;
        $consommation33->updated_at = Carbon::now()->subDay(58);;
        $consommation33->save();


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