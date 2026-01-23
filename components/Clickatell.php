<?php

namespace humhub\modules\sms\components;

use Yii;

/**
 * Clickatell implements the interface to the Clickatell Sms Provider Api.
 *
 * @see //sms/docs/clickatell_http_sms_api.pdf
 *
 * @author Sebastian Stumpf
 *
 */
class Clickatell
{
    public $baseUrl;
    public $apiKey;

    public function __construct()
    {
        $this->baseUrl = "https://platform.clickatell.com/messages/http/send";
        $this->apiKey = Yii::$app->getModule('sms')->settings->get('apiKey_clickatell');
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

        $values = [];
        foreach (explode("\n", $response) as $line) {
            $keyValuePair = explode(":", $line);
            if (count($keyValuePair) >= 2) {
                $values[$keyValuePair[0]] = $keyValuePair[1];
            }
        }

        $retVal = [];
        $retVal['furtherInfo'] = $values;

        if (array_key_exists('ERR', $values)) {
            $retVal['error'] = true;
            $errorInfo = explode(", ", $values['ERR']);
            if (count($errorInfo) >= 2) {
                $retVal['statusMsg'] = $errorInfo[1];
            } else {
                $retVal['statusMsg'] = $values['ERR'];
            }
        } elseif (array_key_exists('ID')) {
            $retVal['error'] = false;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS has been successfully sent.');
        } else {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
        }

        return $retVal;
    }

    /**
     * Build SMS API Url
     */
    private function generateUrl($sender, $receiver, $msg)
    {

        $url = ($this->baseUrl) . "?";
        $url .= http_build_query([
            'apiKey' => $this->apiKey,
            'to' => $receiver,
            'content' => $msg,
        ]);
        return $url;
    }

}
