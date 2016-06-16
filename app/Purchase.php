<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'product_id', 'hash_key', 'payed', 'quantity', 'lineQuote_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function consommations() {
        return $this->hasMany('App\Consommation');
    }

    public function lineQuote() {
        return $this->belongsTo('App\LineQuote');
    }
}
