<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = ['provider', 'user_id', 'number', 'message', 'result'];

    public function user() {
        return $this->belongsTo('App\User');
    }

}
