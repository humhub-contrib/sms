<?php

class Clickatell {

	public $baseUrl;
	public $api_id;
	public $user_id;
	public $pass;
	
	function __construct() {
		$this->baseUrl = "http://api.clickatell.com/http/sendmsg";
		$this->api_id = HSetting::Get('apiid_clickatell', 'sms');
		$this->user_id = HSetting::Get('username_clickatell', 'sms');
		$this->pass = HSetting::Get('password_clickatell', 'sms');
	}
	
	public function sendSms($sender, $receiver, $msg) {
		$url = $this->generateUrl($sender, $receiver, $msg);
		$handle = fopen($url, "rb");
		$retVal = array();
		if($handle == false) {
			$retVal['error'] = true;
			$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Could not open connection to SMS-Provider, please contact an administrator.');
		}
		else {
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
	private function interpretResponse($response) {
		
		$values = array();
		foreach(explode("\n", $response) as $line) {
			$keyValuePair = explode(":", $line);
			if(sizeof($keyValuePair) >= 2) {
				$values[$keyValuePair[0]] = $keyValuePair[1];
			} 
		}
		
		$retVal = array();
		$retVal['furtherInfo'] = $values;
		
		if(array_key_exists('ERR', $values)) {
			$retVal['error'] = true;
			$errorInfo = explode(", ", $values['ERR']);
			if(sizeof($errorInfo) >= 2) {
				$retVal['statusMsg'] = $errorInfo[1];
			}
			else {
				$retVal['statusMsg'] = $values['ERR'];
			}			
		} else if(array_key_exists('ID')) {
			$retVal['error'] = false;
			$retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS has been successfully sent.');
		}
		else {
			$retVal['error'] = true;
			$retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
		}
		
		return $retVal;
	}
	
	/**
	 * Build SMS API Url
	 */
	private function generateUrl($sender, $receiver, $msg) {

		$url = ($this->baseUrl)."?";
		$url .= http_build_query(array(
			'api_id' => $this->api_id,
			'user' => $this->user_id,
			'pass' => $this->pass,
			'to' => urlencode($receiver),
			'text' => urlencode($msg),
			'from' => urlencode($sender),
			'test' => 1
		));
		return $url;
	}
} 

?>