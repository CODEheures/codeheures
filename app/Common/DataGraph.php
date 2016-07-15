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
        //TODO STACKER LES CONSOMMATIONS DE LA MËME DATE
        $consommations = $consommations->sortBy('created_at');
        $conso = [];
        foreach($consommations as $consommation){

            //Detection d'un cumul de consommations
            if(count($conso) > 0 && ($consommation->created_at->format('Y-m-d') == $conso[count($conso)-1]['category'])) {
                $flag_add = true;
            } else {
                $flag_add = false;
            }
            if($consommation->prestation_id){
                if(!$flag_add){
                    $conso[] = [
                        "category" => $consommation->created_at->format('Y-m-d'),
                        "Temps passé" => $consommation->value,
                        "Temps de référence" => $consommation->prestation->duration,
                        "type" => $consommation->prestation->name
                    ];
                } else {
                    $conso[count($conso)-1]['Temps passé'] = $conso[count($conso)-1]['Temps passé']  + $consommation->value;
                    $conso[count($conso)-1]['Temps de référence'] = $conso[count($conso)-1]['Temps de référence']  + $consommation->prestation->duration;
                    $conso[count($conso)-1]['type'] = $conso[count($conso)-1]['type']  . " + " . $consommation->prestation->name;
                }
            } else {
                if(!$flag_add) {
                    $conso[] = [
                        "category" => $consommation->created_at->format('Y-m-d'),
                        "Temps passé" => $consommation->value,
                        "Temps de référence" => $consommation->value,
                        "type" => $consommation->comment
                    ];
                } else {
                    $conso[count($conso)-1]['Temps passé'] = $conso[count($conso)-1]['Temps passé']  + $consommation->value;
                    $conso[count($conso)-1]['Temps de référence'] = $conso[count($conso)-1]['Temps de référence']  + $consommation->value;
                    $conso[count($conso)-1]['type'] = $conso[count($conso)-1]['type']  . " + " . $consommation->comment;
                }
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