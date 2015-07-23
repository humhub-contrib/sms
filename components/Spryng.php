<?php

namespace humhub\modules\sms\components;

use Yii;
use humhub\models\Setting;

/**
 * Spryng implements the interface to the Spryng Sms Provider Api.
 * 
 * @see //sms/docs/spryng_http_sms_api_v2.3.pdf
 * 
 * @author Sebastian Stumpf
 *
 */
class Spryng
{

    //required
    public $baseUrl;
    public $user_id;
    public $pass;
    // optional
    public $route;
    public $service;
    public $allowlong;

    function __construct()
    {
        $this->baseUrl = "https://www.spryng.nl/send.php";
        $this->user_id = Setting::Get('username_spryng', 'sms');
        $this->pass = Setting::Get('password_spryng', 'sms');
        $this->route = Setting::Get('route_spryng', 'sms');
        $this->service = Setting::Get('service_spryng', 'sms');
        $this->allowlong = Setting::Get('allowlong_spryng', 'sms');
    }

    /**
     * @see SmsProvider.sendSms(...)
     */
    public function sendSms($sender, $receiver, $msg)
    {
        $retVal = array();

        $spryngSender = $sender;
        $spryngReceiver = $receiver;
        if (!ctype_digit($sender)) {
            $spryngSender = substr($sender, 0, 11);
        }
        if (!ctype_digit($receiver) || substr($receiver, 0, 2) != "00") {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Receiver is not properly formatted, has to be in international format, either 00[...], or +[...].');
        } else {
            $spryngReceiver = substr($receiver, 1, strlen($receiver) - 2);
            $url = $this->generateUrl($spryngSender, $spryngReceiver, $msg);
            $handle = fopen($url, "rb");
            if ($handle == false) {
                $retVal['error'] = true;
                $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Could not open connection to SMS-Provider, please contact an administrator.');
            } else {
                $serverResponse = stream_get_contents($handle);
                $retVal = $this->interpretResponse($serverResponse);
            }
        }
        $retVal['sender'] = $spryngSender;
        $retVal['receiver'] = $spryngReceiver;
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

        $retVal = array();
        $retVal['error'] = $response != 1;

        if (empty($response)) {
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
        } else {
            switch ($response) {
                case 1:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS has been successfully sent.');
                    break;
                case 101:
                case 102:
                case 103:
                case 104:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Invalid user id and/or password. Please contact an administrator to check the module configuration.');
                    break;
                case 105:
                case 106:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Invalid destination.');
                    break;
                case 107:
                case 108:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Invalid sender.');
                    break;
                case 109:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Body too too short.');
                    break;
                case 110:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Body too long.');
                    break;
                case 200:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Security error. Please contact an administrator to check the module configuration.');
                    break;
                case 201:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Unknown route.');
                    break;
                case 202:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Route access violation.');
                    break;
                case 203:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Insufficent credits.');
                    break;
                case 800:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Technical error.');
                    break;
                default:
                    $retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
                    break;
            }
        }

        $retVal['furtherInfo'] = array($response => $retVal['statusMsg']);

        return $retVal;
    }

    /**
     * Build SMS API Url
     */
    private function generateUrl($sender, $receiver, $msg)
    {

        $url = ($this->baseUrl) . "?";

        $params = array(
            'OPERATION' => 'send',
            'USERNAME' => $this->user_id,
            'PASSWORD' => $this->pass,
            'DESTINATION' => $receiver,
            'SENDER' => $sender,
            'BODY' => $msg,
        );
        // for Spryng maxlength for alphanumeric sender values is 11
        if (!ctype_digit($sender)) {
            $params['SENDER'] = substr($sender, 0, 11);
        }
        if (!empty($this->service)) {
            $params['SERVICE'] = $this->service;
        }
        if (!empty($this->route)) {
            $params['ROUTE'] = $this->route;
        }
        if (!empty($this->allowlong)) {
            $params['ALLOWLONG'] = $this->allowlong;
        }

        $url .= http_build_query($params);

        return $url;
    }

}

?>