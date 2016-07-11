<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consommation extends Model
{
    protected $fillable = ['created_at', 'purchase_id', 'prestation_id', 'value', 'comment'];

    public function purchase() {
        return $this->belongsTo('App\Purchase');
    }

    public function prestation() {
        return $this->belongsTo('App\Prestation');
    }
}
