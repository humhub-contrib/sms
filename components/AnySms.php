<?php
/**
 * AnySms implements the interface to the Any Sms Provider Api.
 *
 * @see //sms/docs/any_sms_gateway_english.pdf
 *
 * @author Sebastian Stumpf
 *
 */
class AnySms {

	public $baseUrl;
	public $id;
	public $pass;
	public $gateway;
	public $test;
	
	function __construct() {
		$this->baseUrl = "https://www.any-sms.biz/gateway/send_sms.php";
		$this->id = HSetting::Get('username_anysms', 'sms');
		$this->pass = HSetting::Get('password_anysms', 'sms');
		$this->gateway = HSetting::Get('gateway_anysms', 'sms');
		$this->test = HSetting::Get('test_anysms', 'sms');
	}
	
	/**
	 * @see SmsProvider.sendSms(...)
	 */
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
		$retVal['error'] = $values['err'] != 0;
		switch($values['err']) {
			case 0:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS has been successfully sent.');
				break;
			case -1:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Invalid user id and/or password. Please contact an administrator to check the module configuration.');
				break;
			case -2:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Invalid IP address.');
				break;
			case -3:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'No sufficient credit available for sub-account.');
				break;
			case -4:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'No sufficient credit available for main-account.');
				break;
			case -5:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS has been rejected/couldn\'t be delivered.');
				break;
			case -6:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'Gateway isn\'t available for this network.');
				break;
			case -9:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS with identical message text has been sent too often within the last 180 secondsSMS with identical message text has been sent too often within the last 180 seconds.');
				break;
			case -18:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'SMS is lacking indication of price (premium number ads).');
				break;
			default:
				$retVal['statusMsg'] = Yii::t('SmsModule.base', 'An unknown error occurred.');
				break;
		}
		
		return $retVal;
	}
	
	/**
	 * Build SMS API Url. Please not that for AnySms, the text has to be in ISO-8859-15. 
	 */
	private function generateUrl($sender, $receiver, $msg) {
		
		$url = ($this->baseUrl)."?";
		$params = array(
				'id' => $this->id,
				'pass' => $this->pass,
				'gateway' => $this->gateway,
				'text' => mb_convert_encoding ($msg , "ISO-8859-15", "utf-8"),
				'nummer' => $receiver,
				'absender' => mb_convert_encoding ($sender , "ISO-8859-15", "utf-8"),
		);
		if(!empty($this->test)) {
			$params['test'] = $this->test;
		}
		// http_build_query url encodes the parameters
		$url .= http_build_query($params);
		return $url;
	}
	
	private function replaceUmlauts($str) {
		return strtr($str, array(
        'Ä' => 'Ae',
        'Ö' => 'Oe',
        'Ü' => 'Ue',
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
        'ß' => 'ss'
		));
	}
} 

?>