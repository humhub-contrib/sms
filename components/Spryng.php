<?php

namespace humhub\modules\sms\components;

use humhub\components\SettingsManager;
use Yii;

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

    public function __construct()
    {
        $this->baseUrl = "https://www.spryng.nl/send.php";

        /* @var SettingsManager $settings */
        $settings = Yii::$app->getModule('sms')->settings;

        $this->user_id = $settings->get('username_spryng');
        $this->pass = $settings->get('password_spryng');
        $this->route = $settings->get('route_spryng');
        $this->service = $settings->get('service_spryng');
        $this->allowlong = $settings->get('allowlong_spryng');
    }

    /**
     * @see SmsProvider.sendSms(...)
     */
    public function sendSms($sender, $receiver, $msg)
    {
        $retVal = [];

        $spryngSender = $sender;
        $spryngReceiver = $receiver;
        if (!ctype_digit((string) $sender)) {
            $spryngSender = substr((string) $sender, 0, 11);
        }
        if (!ctype_digit((string) $receiver) || !str_starts_with((string) $receiver, "00")) {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Receiver is not properly formatted, has to be in international format, either 00[...], or +[...].');
        } else {
            $spryngReceiver = substr((string) $receiver, 1, strlen((string) $receiver) - 2);
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

        $retVal = [];
        $retVal['error'] = $response != 1;

        if (empty($response)) {
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
        } else {
            $retVal['statusMsg'] = match ($response) {
                1 => Yii::t('SmsModule.base', 'SMS has been successfully sent.'),
                101, 102, 103, 104 => Yii::t('SmsModule.base', 'Invalid user id and/or password. Please contact an administrator to check the module configuration.'),
                105, 106 => Yii::t('SmsModule.base', 'Invalid destination.'),
                107, 108 => Yii::t('SmsModule.base', 'Invalid sender.'),
                109 => Yii::t('SmsModule.base', 'Body too too short.'),
                110 => Yii::t('SmsModule.base', 'Body too long.'),
                200 => Yii::t('SmsModule.base', 'Security error. Please contact an administrator to check the module configuration.'),
                201 => Yii::t('SmsModule.base', 'Unknown route.'),
                202 => Yii::t('SmsModule.base', 'Route access violation.'),
                203 => Yii::t('SmsModule.base', 'Insufficent credits.'),
                800 => Yii::t('SmsModule.base', 'Technical error.'),
                default => Yii::t('SmsModule.base', 'An unknown error occurred.'),
            };
        }

        $retVal['furtherInfo'] = [$response => $retVal['statusMsg']];

        return $retVal;
    }

    /**
     * Build SMS API Url
     */
    private function generateUrl($sender, $receiver, $msg)
    {

        $url = ($this->baseUrl) . "?";

        $params = [
            'OPERATION' => 'send',
            'USERNAME' => $this->user_id,
            'PASSWORD' => $this->pass,
            'DESTINATION' => $receiver,
            'SENDER' => $sender,
            'BODY' => $msg,
        ];
        // for Spryng maxlength for alphanumeric sender values is 11
        if (!ctype_digit((string) $sender)) {
            $params['SENDER'] = substr((string) $sender, 0, 11);
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
