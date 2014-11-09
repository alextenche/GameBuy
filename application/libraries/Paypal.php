<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Paypal {
	function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature) {
		// set up API credentials, PayPal end point, and API version.
		$API_UserName = urlencode($PayPalApiUsername);
		$API_Password = urlencode($PayPalApiPassword);
		$API_Signature = urlencode($PayPalApiSignature);
		
		$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';
		
		$API_Endpoint = "https://api-3t".$paypalmode."paypal.com/nvp";
		$version = urlencode('109.0');
		
		// set the curl parameters
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		 // turning off the server and peer verification(TrustManager Concept)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		// set the API operation, NVPRequest for submitting to server
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

		// set the request(nvpreq) as a POST FIELD for curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
		// getting response from server
		$httpResponse = curl_exec($ch);

		if(!$httpResponse) {
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
		}
		
		// Extract the RefundTransaction response details
		$httpResponseAr = explode("&", $httpResponse);

		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}

		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}

		return $httpParsedResponseAr;
	}
}