<?php

class SmsProvider {
	
	public $provider;
	
	function __construct() {
		$providerClass = HSetting::Get('provider', 'sms');
		if(class_exists($providerClass)) {
			$this->provider = new $providerClass();
		} else {
			$this->provider = null;
		}
	}
	
	/**
	 * Send a sms from sender to receiver with the initialized provider.
	 * If you make changes in $sender or $receiver, overwrite them in the return value array.
	 * 
	 * @param numeric $sender
	 * @param alphanumeric $receiver
	 * @param string $msg
	 * @return array { 'sender' => numeric, 'receiver' => alphanumeric, 'error' => bool, 'statusMsg' => string }
	 */
	public function sendSms($sender, $receiver, $msg) {
		$retVal = array();
		if($this->provider == null) {
			$retVal['error'] = true;
			$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Provider is not initialized. Please contact an administrator to check the module configuration.');
		} else {
			$retVal = $this->provider->sendSms($sender, $receiver, $msg);
		}
		if(!array_key_exists('sender', $retVal)) {
			$retVal['sender'] = $sender;
		}
		if(!array_key_exists('receiver', $retVal)) {
			$retVal['receiver'] = $receiver;
		}
		
		return $retVal;
	}
}

?>