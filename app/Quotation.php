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

    protected $fillable = [
        'validity',
        'user_id',
        'isPublished',
        'isViewed',
        'isOrdered',
        'isRefused',
        'isArchived',
        'sms_code',
        'sms_validity',
        'sms_tentatives',
        'orderDate',
        'downPercentPayment',
        'phoneUsedForOrder'
    ];

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

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function invoices() {
        return $this->hasMany('App\Invoice');
    }

    public function getPublicNumber() {
        return $this->created_at->format('Ymd') .'-'. sprintf('%0'.env('NB_CHIFFRES_VISIBLES_NUM_DEVIS').'d',$this->id);
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

    public function haveDownPercent() {
        return ($this->downPercentPayment && $this->downPercentPayment > 0);
    }

    public function haveDownInvoice() {
        $result = false;
        foreach ($this->invoices as $invoice){
            $invoice->isDown ? $result = true : null;
        }
        return $result;
    }

    public function getDownInvoiceAttribute() {
        $result = null;
        foreach ($this->invoices as $invoice){
            $invoice->isDown ? $result = $invoice : null;
        }
        return $result;
    }

    public function getSoldInvoiceAttribute() {
        $result = null;
        foreach ($this->invoices as $invoice){
            $invoice->isSold ? $result = $invoice : null;
        }
        return $result;
    }

    public function getSoldPercentAttribute() {
        $result = 100;
        foreach ($this->invoices as $invoice){
            !$invoice->isSold ? $result = $result - $invoice->percent : null;
        }
        return $result;
    }

    public function nextIntermediateInvoiceNumber() {
        $result = 1;
        foreach ($this->invoices as $invoice){
            $invoice->isIntermediate ? $result++ : null;
        }
        return $result;
    }

    public function canHaveNewIntermediateInvoice() {
        $result = 0;
        if($this->haveDownPercent() && !$this->haveDownInvoice()) {
            return false;
        }
        foreach ($this->invoices as $invoice){
            if($invoice->isSold || !$invoice->isPayed) {
                return false;
            } else {
                $result = $result + $invoice->percent;
            }
        }
        return ($result<70);
    }

    public function canGenerateSoldInvoice() {
        $result = true;
        if($this->haveDownPercent() && !$this->haveDownInvoice()) {
            return false;
        }
        foreach ($this->invoices as $invoice){
            $invoice->isSold ? $result = false : null;
            !$invoice->isSold && $invoice->isPayed == false ? $result = false : null;
        }
        return $result;
    }

    public function haveSoldInvoice() {
        $result = false;
        foreach ($this->invoices as $invoice){
            $invoice->isSold ? $result = true : null;
        }
        return $result;
    }

    public function canArchive() {
        if($this->isOrdered && $this->haveSoldInvoice()){
            foreach ($this->invoices as $invoice){
                if(!$invoice->isPayed){
                    return false;
                }
            }
            return true;
        } elseif ($this->validity < Carbon::today()->format('Y-m-d')) {
            return true;
        } elseif ($this->isRefused) {
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

    public function canCancel() {
        if ($this->isOrdered){
            foreach ($this->invoices as $invoice) {
                if($invoice->isPayed == true) { return false; }
            }
            return true;
        } else {
            return false;
        }
    }

    public function canPurchase() {
        if(
            $this->user_id == auth()->user()->id
            && $this->isPublished
            && $this->validity >= Carbon::today()->format('Y-m-d')
            && !$this->isOrdered
            && !$this->isRefused
        ) {
            return true;
        }
        return false;
    }

    public function canRefuse() {
        if(
            $this->user_id == auth()->user()->id
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

    public function totalPrice($tva=false) {
        $totalPrice = 0;
        foreach($this->lineQuotes as $lineQuote){
            if ($tva) {
                $totalPrice += $lineQuote->totalPriceTTC();
            } else {
                $totalPrice += $lineQuote->totalPriceHt();
            }
        }
        return (int) $totalPrice;
    }

    public function remise() {
        $totalRemise = 0;
        foreach($this->lineQuotes as $lineQuote){
            $totalRemise += $lineQuote->remise();
        }
        return (int) $totalRemise;
    }

    public function totalPercent($tva=false, $percent) {
        $totalPercent = 0;
        foreach($this->lineQuotes as $lineQuote){
            if ($tva) {
                $totalPercent += $lineQuote->totalPriceTTC()*$percent;
            } else {
                $totalPercent += $lineQuote->totalPriceHt()*$percent;
            }
        }
        return (int) ($totalPercent/100);
    }

    public function totalSoldPrice($tva=false) {
        $totalDowns = 0;
        foreach($this->invoices as $invoice){
            if ($tva) {
                $totalDowns = $totalDowns + $invoice->amountTTC;
            } else {
                $totalDowns = $totalDowns + $invoice->amountHT;
            }
        }
        $totalSold = $this->totalPrice($tva)-$totalDowns;
        return (int) $totalSold;
    }
}
