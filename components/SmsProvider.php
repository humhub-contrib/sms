<?php

namespace humhub\modules\sms\components;

use Yii;
use humhub\models\Setting;

/**
 * SmsProvider is the general class to use to send a sms via the set provider in the settings.
 * The request to send a sms is redirected to the specific provider class instance initialized from the settings (provider : sms) in the constructor.
 * 
 * @author Sebastian Stumpf
 *
 */
class SmsProvider
{

    /** The specific provider, the incoming requests will be redirected to. * */
    public $provider;

    /**
     * Constructor initialized the specific provider from the settings.
     */
    function __construct()
    {
        $providerClass = 'humhub\\modules\\sms\\components\\' . Setting::Get('provider', 'sms');

        if (class_exists($providerClass)) {
            $this->provider = new $providerClass();
        } else {
            $this->provider = null;
        }
    }

    /**
     * Send a sms from sender to receiver with the initialized specific provider.
     * If $sender or $receiver are changed in the specific provider, overwrite them in its return value.
     * 
     * @param numeric $sender the sender, alphanumeric
     * @param alphanumeric $receiver the receiver, will be normalized with normalize()
     * @param string $msg the message
     * @return array { 'sender' => string, 'receiver' => alphanumeric, 'error' => bool, 'statusMsg' => string } ann array with information about the sent sms
     */
    public function sendSms($sender, $receiver, $msg)
    {

        $retVal = array();
        $normReceiver = $this->normalize($receiver);
        if ($this->provider == null) {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Provider is not initialized. Please contact an administrator to check the module configuration.');
        } else if (empty($sender)) {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Sender is invalid.');
        } else if (empty($normReceiver) || strlen($normReceiver) < 2) {
            $retVal['error'] = true;
            $retVal['statusMsg'] = Yii::t('SmsModule.base', 'Receiver is invalid.');
        } else {
            $retVal = $this->provider->sendSms($sender, $normReceiver, $msg);
        }
        if (!array_key_exists('sender', $retVal)) {
            $retVal['sender'] = $sender;
        }
        if (!array_key_exists('receiver', $retVal)) {
            $retVal['receiver'] = $normReceiver;
        }

        return $retVal;
    }

    /**
     * This function normalizes a given number by removing all non digits and replacing the first '+' (international number) with 00.
     * Example:
     * 
     * d := digit
     * c := any non numeric character
     * p := + character
     * 
     * p(d*c*)* -> 00d*
     * (d*c*)* -> d*
     * 
     * @param string $number
     * @return string
     */
    public function normalize($number = null)
    {
        if (empty($number)) {
            return $number;
        }
        $normalized = preg_replace("/[^0-9|+]/", "", $number);
        $prefix = $normalized[0] == '+' ? "00" : "";
        $normalized = $prefix . preg_replace("/[+]/", "", $normalized);
        return $normalized;
    }

}

?>