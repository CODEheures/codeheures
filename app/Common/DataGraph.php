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
        $consommations = $consommations->sortBy('created_at');
        $conso = [];
        foreach($consommations as $consommation){
            if($consommation->prestation_id){
                $conso[] = [
                    "category" => $consommation->created_at->format('Y-m-d'),
                    "Temps passé" => $consommation->value,
                    "Temps de référence" => $consommation->prestation->duration,
                    "type" => $consommation->prestation->name
                ];
            } else {
                $conso[] = [
                    "category" => $consommation->created_at->format('Y-m-d'),
                    "Temps passé" => $consommation->value,
                    "Temps de référence" => '',
                    "type" => $consommation->comment
                ];
            }
        }

        if(count($conso) != 0) {
            $data = json_encode($conso,JSON_NUMERIC_CHECK);
        } else {
            $data = null;
        }

        return $data;
    }

}