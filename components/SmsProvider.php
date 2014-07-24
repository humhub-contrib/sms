<?php

class SmsProvider {
	
	public $provider;
	
	function __construct() {
		$providerClass = HSetting::Get('provider', 'sms');
		try {
			$this->provider = new $providerClass();
		} catch (Exception $e) {
			$this->provider = null;
		}
	}
	
	public function sendSms($sender, $receiver, $msg) {
		$retVal = array();
		if($this->provider == null) {
			$retVal['error'] = true;
			$retVal['statusMsg'] = 'Provider is not initialized.';
		} else {
			$retVal = $this->provider->sendSms($sender, $receiver, $msg);
		}
		return $retVal;
	}
}

?>