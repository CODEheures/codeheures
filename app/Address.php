<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'type', 'address', 'complement', 'zipCode', 'town'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
