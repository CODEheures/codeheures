<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 17/08/2015
 * Time: 14:02
 */

namespace App\Common;

trait DataGraph
{
    public function dataGraph($consommations) {
        $conso = [];
        foreach($consommations as $consommation){
            if(count($conso)>0 && $consommation->created_at->format('Y-m-d') == $conso[count($conso)-1]['x']){
                $conso[count($conso)-1]['y'] += $consommation->value;
                $conso[count($conso)-1]['com'] = $conso[count($conso)-1]['com'] . ' | ' . $consommation->comment . ' ' . $consommation->purchase->user->name;
            } else {
                $conso[] = [
                    'x' => $consommation->created_at->format('Y-m-d'),
                    'y' => $consommation->value,
                    'com' => $consommation->comment . ' ' . $consommation->purchase->user->name,
                ];
            }
        }

        $main=[];
        $main[] = [
            'className' => '.consommations',
            'data' => $conso
        ];

        $data = [
            'xScale' => 'time',
            'yScale' => 'linear',
            'main' => $main

        ];

        $data = json_encode($data,JSON_NUMERIC_CHECK);

        return $data;
    }

}