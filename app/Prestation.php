<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $fillable = ['name', 'description', 'duration', 'isPublished', 'isObsolete', 'url'];

    public function consommations() {
        return $this->hasMany('App\Consommation');
    }

    public function canEdit() {
        if(!$this->isPublished){
            return true;
        }
        return false;
    }
}
