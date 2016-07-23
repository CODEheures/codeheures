<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quotation_id', 'hash_key', 'payed', 'quantity', 'paypal_result'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function consommations() {
        return $this->hasMany('App\Consommation');
    }

    public function quotation() {
        return $this->belongsTo('App\Quotation');
    }

    public function invoices() {
        return $this->hasMany('App\Invoice');
    }

    public function generateHashKey() {
        $key = str_random(12);
        while (Purchase::where('hash_key', '=', $key)->count() > 0) {
            $key = str_random(12);
        }

        return $key;
    }

    public function havePaypalInvoice() {
        if($this->paypal_result) {
           return true;
        } else {
            return false;
        }
    }
}
