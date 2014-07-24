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
	
	public function sendSms($sender, $receiver, $msg) {
		$retVal = array();
		if($this->provider == null) {
			$retVal['error'] = true;
			$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Provider is not initialized. Please contact an administrator to check the module configuration.');
		} else {
			$retVal = $this->provider->sendSms($sender, $receiver, $msg);
		}
		return $retVal;
	}
}

?>