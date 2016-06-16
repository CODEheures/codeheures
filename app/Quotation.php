<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quotation extends Model
{
    private $min_sms_code = 312789;
    private $max_sms_code = 745632;
    private $max_sms_tentative_code = 2;
    private $max_time_validity = 15;

    protected $fillable = ['validity', 'user_id', 'isPublished', 'isViewed', 'isOrdered', 'isArchived', 'sms_code', 'sms_validity', 'sms_tentatives', 'orderDate', 'downPercentPayment', 'phoneUsedForOrder'];

    public function __construct(array $attributes =[]) {
        parent::__construct($attributes);

        if((int)env('QUOTATION_MAX_SMS_TENTATIVE_CODE') > 0){
            $this->max_sms_tentative_code = (int)env('QUOTATION_MAX_SMS_TENTATIVE_CODE');
        }

        if((int)env('QUOTATION_MAX_TIME_VALIDITY') > 0){
            $this->max_time_validity = (int)env('QUOTATION_MAX_TIME_VALIDITY');
        }
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function lineQuotes() {
        return $this->hasMany('App\LineQuote');
    }

    public function getPublicNumber() {
        return $this->created_at->format('Ymd') .'-'. sprintf('%03d',$this->id);
    }

    public function canEdit() {
        if(!$this->isPublished) {
            return true;
        }
        return false;
    }

    public function canPublish() {
        if($this->lineQuotes()->count() > 0 && !$this->isPublished) {
            return true;
        }
        return false;
    }

    public function canUnpublish() {
        if(!$this->isViewed && $this->isPublished){
            return true;
        }
        return false;
    }

    public function canArchive() {
        if($this->isOrdered){
            return true;
        } elseif ($this->validity < Carbon::today()->format('Y-m-d')) {
            return true;
        }
        return false;
    }

    public function canDelete() {
        if (!$this->isOrdered && $this->validity < Carbon::today()->format('Y-m-d')){
            return true;
        } elseif (!$this->isPublished) {
            return true;
        }
        return false;
    }

    public function canPurchase() {
        if(
            $this->user_id == auth()->user()->id
            && $this->isPublished
            && $this->validity >= Carbon::today()->format('Y-m-d')
            && !$this->isOrdered
        ) {
            return true;
        }
        return false;
    }

    public function getMinSmsCode() {
        return $this->min_sms_code;
    }

    public function getMaxSmsCode() {
        return $this->max_sms_code;
    }

    public function getMaxSmsTentativeCode() {
        return $this->max_sms_tentative_code;
    }

    public function getLeftTimeCodeValidity() {
        return Carbon::parse($this->sms_validity)->addMinute($this->max_time_validity)->diffInSeconds(Carbon::now());
    }

    public function timeElpasedCode() {
        return Carbon::parse($this->sms_validity)->addMinute($this->max_time_validity)->lt(Carbon::now());
    }

    public function hasValidCode() {
        if (
            is_integer($this->sms_code)
            && $this->sms_code >= $this->min_sms_code
            && $this->sms_code <= $this->max_sms_code
            && !$this->timeElpasedCode()
            && $this->sms_tentatives <= $this->max_sms_tentative_code
        ) {
            return true;
        }

        return false;
    }

    public function canHaveNewCode() {
        if(
            $this->sms_code === null
            || ($this->sms_code != null && $this->timeElpasedCode())
        ){
            return true;
        }
        return false;
    }

}
