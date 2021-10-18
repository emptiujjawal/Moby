<?php 
/**
 * Interation with patym 
 * - Gratification amount transfer
 * 
 * @api https://github.com/Paytm-Payments/Paytm_Gratification_Kit/tree/master/Php
 * 
 **/ 

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included

require_once("Paytm_lib/encdec_paytm.php");

class Paytm
{
	
	function __construct(){

	}

	public function transferAmountToPaytm($order_id, $ip_address, $payee_phone_number, $sales_wallet_guid, $transfer_amount) {
		$checkSum = "";
		$paramList = array();
		$paramList['request'] = array( 'requestType' =>'NULL',
			'merchantGuid' => '02a19538-183b-48f8-801d-e237faee5da6',
			'merchantOrderId' => $order_id,     
			'salesWalletGuid'=> $sales_wallet_guid,
			'payeeEmailId'=>'',
			'payeePhoneNumber'=>$payee_phone_number,
			'payeeSsoId'=>'',
			'appliedToNewUsers'=>'N',
			'amount'=> $transfer_amount,
			'currencyCode'=>'INR');

		$paramList['metadata'] = 'Testing Data';
		$paramList['ipAddress'] = $ip_address;
		$paramList['operationType'] = 'SALES_TO_USER_CREDIT';
		$paramList['platformName'] = 'PayTM';

		$data_string = json_encode($paramList); 

		$checkSum = getChecksumFromString($data_string,'W6%ENIVDm&XxZ7@d');

		$ch = curl_init();                    // initiate curl
		$url = "https://trust.paytm.in/wallet-web/salesToUserCredit"; // where you want to post data

		$headers = array('Content-Type:application/json','mid:02a19538-183b-48f8-801d-e237faee5da6','checksumhash:'.$checkSum);

		$ch = curl_init();  // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output_s = curl_exec ($ch); // execute
		$info = curl_getinfo($ch);
		// print_r($info)."<br />";
		$output = json_decode($output_s);
		$response = [];
		$response["status"] = $output->status;
		$response["transaction_id"] = $output->response->walletSysTransactionId;
		$response["status_message"] = $output->statusMessage;
		$response["status_code"] = $output->statusCode;
		return $response;
	}
}

?>