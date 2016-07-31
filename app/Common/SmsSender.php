<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 17/08/2015
 * Time: 14:02
 */

namespace App\Common;

use App\Common\SmsFreeMobile;
use App\Common\SmsApiCom;
use App\Common\SmsOvh;
use App\Sms;

class SmsSender
{
    private $provider;
    private $message;
    private $destinataire;

    public function __construct($message, $destinataire)
    {
        $this->message = $message;
        $this->destinataire = $destinataire;
        $this->provider = env('SMS_PROVIDER');
    }

    public function send() {
        if($this->provider == 'free') {
            $sms = new SmsFreeMobile();
        } elseif ($this->provider == 'smsapi.com') {
            $sms = new SmsApiCom();
        }  elseif ($this->provider == 'ovh') {
            $sms = new SmsOvh();
        } else {
            throw new \Exception("Provider SMS Inconnue!");
        }

        try {
            $results = $sms->send($this->message, $this->destinataire);
            $this->saveResults($results);
        } catch (\Exception $e) {
            throw new \Exception("Erreur sur envoi de SMS: ".$e->getCode().") ".$e->getMessage());
        }
    }

    private function saveResults($results) {
        foreach ($results as $result) {
            $sms = new Sms();
            $sms->provider = $this->provider;
            $sms->user_id = auth()->user()->id;
            $sms->message = $this->message;
            $sms->number = $this->destinataire;
            $sms->result = $result;
            $sms->save();
        }
    }
}