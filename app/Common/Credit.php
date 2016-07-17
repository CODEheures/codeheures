<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 17/08/2015
 * Time: 14:02
 */

namespace App\Common;

trait Credit
{
    public function consosAndtotalLeft($purchases) {
        $conso = collect([]);
        $totalQuantity = 0;
        $totalConsommation = 0;
        foreach($purchases as $purchase){
            if($purchase->product->type == 'time'){
                $totalQuantity += $purchase->product->value*$purchase->quantity;
                $conso  = $conso->merge($purchase->consommations);
            }
            foreach($purchase->consommations as $consommation){
                if($purchase->product->type == 'time'){
                    $totalConsommation += $consommation->value;
                }
            }
        }

        $totalLeft = $totalQuantity-$totalConsommation;

        return [$conso, $totalLeft];
    }
}