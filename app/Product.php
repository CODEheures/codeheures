<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['description', 'type', 'value', 'price', 'unit', 'isObsolete', 'reservedForUserId', 'tva', 'url'];

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function lineQuote() {
        return $this->hasMany('App\LineQuote');
    }

    public function canEdit() {
        if($this->lineQuote()->count() > 0 || $this->purchases()->count() > 0){
            return false;
        }

        return true;
    }
}