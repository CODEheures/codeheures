<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Product extends Model
{
    protected $fillable = ['description', 'type', 'value', 'price', 'unit', 'isObsolete', 'reservedForUserId', 'tva', 'url'];

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function lineQuotes() {
        return $this->hasMany('App\LineQuote');
    }

    public function canEdit() {
        if($this->lineQuotes()->count() > 0 || $this->purchases()->count() > 0){
            return false;
        }

        return true;
    }

    public function getReservedUser() {
        $user = User::where('id', '=', $this->reservedForUserId)->first();
        return $user;
    }
}