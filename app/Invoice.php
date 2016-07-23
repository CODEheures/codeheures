<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'purchase_id',
        'quotation_id',
        'isDown',
        'isSold',
        'isPayed',
        'mail',
        'nbMailBefore',
        'nbMailAfter',
        'origin',
        'number',
        'demo_number'
    ];

    public function purchase() {
        return $this->belongsTo('App\Purchase');
    }

    public function quotation() {
        return $this->belongsTo('App\Quotation');
    }

}
