<?php

namespace humhub\modules\sms\components;

use Yii;
use humhub\models\Setting;

/**
 * Seven implements the interface to the Seven Sms Provider Api.
 *
 * @see https://www.seven.io/en/docs/gateway/http-api/sms-dispatch/
 *
 * @author seven communications GmbH & Co. KG
 *
 */
class Sms77
{
    public $baseUrl;
    public $apiKey;

    public function __construct()
    {
        $this->baseUrl = "https://gateway.seven.io/api/sms";
        $this->apiKey = Setting::Get('apikey_sms77', 'sms');
    }

    /**
     * @see SmsProvider.sendSms(...)
     */
    public function sendSms($sender, $receiver, $msg)
    {
        $url = $this->generateUrl($sender, $receiver, $msg);
        $handle = fopen($url, "rb");
        $retVal = [];
        if ($handle == false) {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Could not open connection to SMS-Provider, please contact an administrator.');
        } else {
            $serverResponse = stream_get_contents($handle);
            $retVal = $this->interpretResponse($serverResponse);
        }
        return $retVal;
    }

    /**
     * Interpret a string response from the server and convert to a predefined array.
     * @param string $response the server response to a send sms.
     * @return array[string] an array containing following keys: {error, statusMsg, furtherInfo}, where error is true/false, statusMsg the status message and furtherInfo an array with further information
     *
     */
    private function interpretResponse($response)
    {
        $json = json_decode($response, true);

        switch ((int)$json['success']) {
            case 100:
                $success = true;
                $msg = 'SMS has been successfully sent.';
                break;
            case 101:
                $msg = 'Transmission to at least one recipient failed.';
                break;
            case 201:
                $msg = 'Sender invalid. A maximum of 11 alphanumeric or 16 numeric characters are allowed.';
                break;
            case 202:
                $msg = 'Recipient number invalid.';
                break;
            case 301:
                $msg = 'Variable to not set.';
                break;
            case 305:
                $msg = 'Variable text not set.';
                break;
            case 401:
                $msg = 'Variable text is too long.';
                break;
            case 402:
                $msg = 'Reload Lock – this SMS has already been sent within the last 180 seconds.';
                break;
            case 403:
                $msg = 'Max. limit per day reached for this number.';
                break;
            case 500:
                $msg = 'Too little credit available.';
                break;
            case 600:
                $msg = 'Carrier delivery failed.';
                break;
            case 700:
                $msg = 'Unknown error.';
                break;
            case 900:
                $msg = 'Authentication failed. Please check your api key.';
                break;
            case 903:
                $msg = 'Server IP is wrong.';
                break;
            default:
                $msg = 'An unknown error occurred.';
                break;
        }

        $i = 1;
        foreach ($json['messages'] as $message) {
            foreach ($message as $key => $value) {
                $json['message_' . $i . '_' . $key] =
                    is_array($value) ? implode(',', $value) : $value;
            }

            $i++;
        }
        unset($json['messages']);

        $retVal = [
            'error' => !isset($success),
            'furtherInfo' => $json,
            'statusMsg' => Yii::t('SmsModule.base', $msg),
        ];

        return $retVal;
    }

    /**
     * Build SMS API Url
     */
    private function generateUrl($sender, $receiver, $msg)
    {

        $url = $this->baseUrl . "?";
        $url .= http_build_query([
            'p' => $this->apiKey,
            'json' => 1,
            'SentWith' => 'HumHub',
            'to' => $receiver,
            'text' => $msg,
            'from' => $sender,
        ]);
        return $url;
    }

}
