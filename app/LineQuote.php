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

    public function totalPriceHtWithoutRemise() {
        return (int) ($this->product->price*$this->quantity);
    }

    public function totalPriceHt() {
        return (int) ($this->totalPriceHtWithoutRemise()-$this->remise());
    }

    public function remise() {
        if($this->discount_type == 'devise') {
            return (int) ($this->discount);
        } else {
            return (int) ($this->totalPriceHtWithoutRemise()*$this->discount/10000);
        }
    }

    public function tvaPercent() {
        return (int) ($this->product->tva);
    }

    public function tva() {
        return (int) (($this->totalPriceHt())*$this->tvaPercent()/10000);
    }

    public function totalPriceTTC() {
        return (int) ($this->totalPriceHt()+$this->tva());
    }

}
