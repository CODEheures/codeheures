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

        $product1 = Product::create([
           'description' => '1h de webmastering',
            'type' => 'time',
            'value' => 1,
            'price' => 60,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product2 = Product::create([
            'description' => '5h de webmastering',
            'type' => 'time',
            'value' => 5,
            'price' => 250,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product3 = Product::create([
            'description' => '10h de webmastering',
            'type' => 'time',
            'value' => 10,
            'price' => 400,
            'unit' => 'heure(s)',
            'reservedForUserId' => $user->id
        ]);

        $product4 = Product::create([
            'description' => '1 site vitrine 5 pages base wix.com',
            'type' => 'one_shot',
            'value' => 1,
            'price' => 800,
            'reservedForUserId' => $user->id
        ]);

        $purchase1 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product3->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 1
        ]);
        $purchase1->created_at = '2015-10-03 20:44:00';
        $purchase1->updated_at = '2015-10-03 20:44:00';
        $purchase1->save();

        $purchase2 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 2
        ]);
        $purchase2->created_at = '2015-10-05 20:44:00';
        $purchase2->updated_at = '2015-10-05 20:44:00';
        $purchase2->save();

        $purchase3 = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product4->id,
            'hash_key' => str_random(12),
            'payed' => true,
            'quantity' => 1
        ]);
        $purchase3->created_at = '2015-08-01 20:44:00';
        $purchase3->updated_at = '2015-08-01 20:44:00';
        $purchase3->save();

        $consommation1 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 1.5,
            'comment' => 'ajoute photos et commentaires'
        ]);
        $consommation1->created_at = '2015-10-04 20:44:00';
        $consommation1->updated_at = '2015-10-04 20:44:00';
        $consommation1->save();

        $consommation2 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 2,
            'comment' => 'ajoute d\'une page prestataire'
        ]);
        $consommation2->created_at = '2015-10-15 20:44:00';
        $consommation2->updated_at = '2015-10-15 20:44:00';
        $consommation2->save();

        $consommation3 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 4,
            'comment' => 'refonte de la page d\'accueil'
        ]);
        $consommation3->created_at = '2015-10-18 20:44:00';
        $consommation3->updated_at = '2015-10-18 20:44:00';
        $consommation3->save();

        $consommation4 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 0.8,
            'comment' => 'mise à jour photo'
        ]);
        $consommation4->created_at = '2015-10-25 20:44:00';
        $consommation4->updated_at = '2015-10-25 20:44:00';
        $consommation4->save();

        $consommation5 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 1.5,
            'comment' => 'gestion des utilisateurs'
        ]);
        $consommation5->created_at = '2015-10-30 20:44:00';
        $consommation5->updated_at = '2015-10-30 20:44:00';
        $consommation5->save();

        $consommation6 = Consommation::create([
            'purchase_id' => $purchase1->id,
            'value' => 0.2,
            'comment' => 'correction de texte'
        ]);
        $consommation6->created_at = '2015-11-08 21:44:00';
        $consommation6->updated_at = '2015-11-08 21:44:00';
        $consommation6->save();

        $consommation7 = Consommation::create([
            'purchase_id' => $purchase2->id,
            'value' => 0.7,
            'comment' => 'mise à jour page 2'
        ]);
        $consommation7->created_at = '2015-11-09 20:44:00';
        $consommation7->updated_at = '2015-11-09 20:44:00';
        $consommation7->save();


        $quotation1 = Quotation::create([
            'user_id' => $user->id,
            'isPublished' => true,
            'downPercentPayment' => 30
        ]);
        $quotation1->created_at = Carbon::now()->subDays(15);
        $quotation1->updated_at = Carbon::now()->subDays(15);
        $quotation1->validity = Carbon::now()->subDays(15)->addMonth(1)->format('Y-m-d');
        $quotation1->save();

        $quotation2 = Quotation::create([
            'user_id' => $user->id,
            'isPublished' => true,
        ]);
        $quotation2->created_at = Carbon::now()->subDays(11);
        $quotation2->updated_at = Carbon::now()->subDays(11);
        $quotation2->validity = Carbon::now()->subDays(11)->addMonth(1)->format('Y-m-d');
        $quotation2->save();

        $lineQuote1 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product1->id,
            'quantity' => 1,
        ]);
        $lineQuote1->created_at = Carbon::now()->subDays(15);
        $lineQuote1->updated_at = Carbon::now()->subDays(15);
        $lineQuote1->save();

        $lineQuote2 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product2->id,
            'quantity' => 3,
            'discount' => 15,
            'discount_type' => 'devise'
        ]);
        $lineQuote2->created_at = Carbon::now()->subDays(15);
        $lineQuote2->updated_at = Carbon::now()->subDays(15);
        $lineQuote2->save();

        $lineQuote3 = LineQuote::create([
            'quotation_id' => $quotation1->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'discount' => 10,
            'discount_type' => 'percent'
        ]);
        $lineQuote3->created_at = Carbon::now()->subDays(15);
        $lineQuote3->updated_at = Carbon::now()->subDays(15);
        $lineQuote3->save();

        $lineQuote4 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'discount' => 10,
            'discount_type' => 'percent'
        ]);
        $lineQuote4->created_at = Carbon::now()->subDays(11);
        $lineQuote4->updated_at = Carbon::now()->subDays(11);
        $lineQuote4->save();

        $lineQuote5 = LineQuote::create([
            'quotation_id' => $quotation2->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'discount' => 10,
            'discount_type' => 'percent'
        ]);
        $lineQuote5->created_at = Carbon::now()->subDays(11);
        $lineQuote5->updated_at = Carbon::now()->subDays(11);
        $lineQuote5->save();

        return null;
    }
}