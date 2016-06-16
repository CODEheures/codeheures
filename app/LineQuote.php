<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineQuote extends Model
{
    protected $fillable = ['quotation_id', 'product_id', 'quantity', 'discount', 'discount_type'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function quotation() {
        return $this->belongsTo('App\Quotation');
    }
}
