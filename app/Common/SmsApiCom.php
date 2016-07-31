<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 17/08/2015
 * Time: 14:02
 */

namespace App\Common;

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;

class SmsApiCom
{


    public function send($message, $destinataire) {
        $client = new Client(env('SMSAPICOM_USER'));
        $client->setPasswordHash(env('SMSAPICOM_MD5_PASS'));

        $smsapi = new SmsFactory;
        $smsapi->setClient($client);

        try {
            $actionSend = $smsapi->actionSend();

            $actionSend->setTo('33'.$destinataire);
            $actionSend->setText($message);
            $actionSend->setSender('Info');


            $response = $actionSend->execute();

            $results = array();
            foreach ($response->getList() as $status) {
                array_push($results, $status->getNumber() . ',' . $status->getPoints() . ',' . $status->getStatus());
            }
            return $results;
        } catch (SmsapiException $exception) {
            throw new \Exception('ERROR: ' . $exception->getMessage());
        }
    }
}