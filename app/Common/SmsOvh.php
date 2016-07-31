<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 17/08/2015
 * Time: 14:02
 */

namespace App\Common;

use Ovh\Api;

class SmsOvh
{


    public function send($message, $destinataire) {
        $endpoint = 'ovh-eu';
        $applicationKey = env('OVH_SMS_APP_KEY');
        $applicationSecret = env('OVH_SMS_APP_SECRET');
        $consumer_key = env('OVH_SMS_CONSUMER_KEY');

        $conn = new Api(    $applicationKey,
            $applicationSecret,
            $endpoint,
            $consumer_key);

        try {
            $smsServices = $conn->get('/sms/');
            //        foreach ($smsServices as $smsService) {
            //            dd($smsService);
            //        }
            $content = (object)array(
                "charset" => "UTF-8",
                "class" => "phoneDisplay",
                "coding" => "7bit",
                "message" => $message,
                "noStopClause" => true,
                "priority" => "high",
                "receivers" => ['+33' . $destinataire],
                "senderForResponse" => true,
                "validityPeriod" => 2880
            );
            $resultPostJob = $conn->post('/sms/' . $smsServices[0] . '/jobs/', $content);

            $results = array();

            $result = 'credit: ' . $resultPostJob['totalCreditsRemoved'];
            if (count($resultPostJob['invalidReceivers']) > 0) {
                $result = $result . ',invalid: ' . $resultPostJob['invalidReceivers'][0];
            }
            if (count($resultPostJob['ids']) > 0) {
                $result = $result . ',id: ' . $resultPostJob['ids'][0];
            }
            if (count($resultPostJob['validReceivers']) > 0) {
                $result = $result . ',valid: ' . $resultPostJob['validReceivers'][0];
            }
            array_push($results, $result);

            return $results;
        } catch (\Exception $exception) {
            throw new \Exception('ERROR: ' . $exception->getMessage());
        }
    }
}