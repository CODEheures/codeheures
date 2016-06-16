<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consommation extends Model
{
    protected $fillable = ['purchase_id', 'value', 'comment'];

    public function purchase() {
        return $this->belongsTo('App\Purchase');
    }

}
