<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineQuote extends Model
{
    protected $fillable = ['quotation_id', 'product_id', 'quantity', 'discount', 'discount_type'];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function quotation() {
        return $this->belongsTo('App\Quotation');
    }
}
