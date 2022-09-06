<?php

	/********************************************
	Module contains calls to PayPal APIs
	********************************************/
	if (session_id() == "")
	session_start();

	if(isset($_GET['token']) && !isset($_GET['PayerID'])){
		session_unset();
	}

	//Seller Sandbox Credentials- Sample credentials already provided
	// define("PP_USER_SANDBOX", "supersandy_api1.gmail.com");
	// define("PP_PASSWORD_SANDBOX", "1400525332");
	// define("PP_SIGNATURE_SANDBOX", "AdUaGhfPganVo2IfGf2Ctordn94OASnvL6qF4D-pnHb6hEQCLBWKbzmq");

	define("PP_USER_SANDBOX", "admin-facilitator_api1.ieloboost.com");
	define("PP_PASSWORD_SANDBOX", "FCLJ6F9JMPLFYEJU");
	define("PP_SIGNATURE_SANDBOX", "AFcWxV21C7fd0v3bYYYRCpSSRl31A.64Bfwx.61kw1R.loVlHE6ggXb4");

	// define("PP_USER_SANDBOX", "djro1605_api1.gmail.com");
	// define("PP_PASSWORD_SANDBOX", "MS9MALCNMXY58ZZ3");
	// define("PP_SIGNATURE_SANDBOX", "AFcWxV21C7fd0v3bYYYRCpSSRI31AVBZwOtJN.ph-QGIsuhAb1MIvEeT");

	//Seller Live credentials.
	define("PP_USER","admin_api1.ieloboost.com");
	define("PP_PASSWORD", "62X55R7W7HSEZYND");
	define("PP_SIGNATURE","AFcWxV21C7fd0v3bYYYRCpSSRl31AMnGXhgpQjdh7z-pbyce16hxCbh7");

	//Set this constant EXPRESS_MARK = true to skip review page
	define("EXPRESS_MARK", true);

	//Set this constant ADDRESS_OVERRIDE = true to prevent from changing the shipping address
	define("ADDRESS_OVERRIDE", true);

	//Set this constant NOSHIPPING = 1 to hide shipping options/addresss
	define("NOSHIPPING", 1);

	//Set this constant USERACTION_FLAG = true to skip review page
	define("USERACTION_FLAG", false);

	//Based on the USERACTION_FLAG assign the page
	if(USERACTION_FLAG){
		$page = home_url('/boosting-purchase');
	} else {
		$page = home_url('/boosting-purchase');
	}

	//The URL in your application where Paypal returns control to -after success (RETURN_URL) using Express Checkout Mark Flow
	define("RETURN_URL_MARK", home_url('/boosting-purchase'));
	define("RETURN_URL", home_url('/boosting-purchase'));
	define("CANCEL_URL", home_url());

	//Whether Sandbox environment is being used, Keep it true for testing
	define("SANDBOX_FLAG", false);

	if(SANDBOX_FLAG){
		$merchantID=PP_USER_SANDBOX;  /* Use Sandbox merchant id when testing in Sandbox */
		$env= 'sandbox';
	}
	else {
		$merchantID=PP_USER;  /* Use Live merchant ID for production environment */
		$env='production';
	}

	//Proxy Config
	define("PROXY_HOST", "127.0.0.1");
	define("PROXY_PORT", "808");

	//In-Context in Express Checkout URLs for Sandbox
	define("PP_CHECKOUT_URL_SANDBOX", "https://www.sandbox.paypal.com/checkoutnow?token=");
	define("PP_NVP_ENDPOINT_SANDBOX","https://api-3t.sandbox.paypal.com/nvp");

	//Express Checkout URLs for Sandbox
	//define("PP_CHECKOUT_URL_SANDBOX", "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
	//define("PP_NVP_ENDPOINT_SANDBOX","https://api-3t.sandbox.paypal.com/nvp");

	//In-Context in Express Checkout URLs for Live
	define("PP_CHECKOUT_URL_LIVE","https://www.paypal.com/checkoutnow?token=");
	define("PP_NVP_ENDPOINT_LIVE","https://api-3t.paypal.com/nvp");

	//Express Checkout URLs for Live
	//define("PP_CHECKOUT_URL_LIVE","https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
	//define("PP_NVP_ENDPOINT_LIVE","https://api-3t.paypal.com/nvp");

	//Version of the APIs
	define("API_VERSION", "109.0");

	//ButtonSource Tracker Code
	define("SBN_CODE","PP-DemoPortal-EC-IC-php");

	// Use values from config.php
	$PROXY_HOST = PROXY_HOST;
	$PROXY_PORT = PROXY_PORT;
	$SandboxFlag = SANDBOX_FLAG;


	if($SandboxFlag)  //API Credentials and URLs for Sandbox
	{
		$API_UserName=PP_USER_SANDBOX;
		$API_Password=PP_PASSWORD_SANDBOX;
		$API_Signature=PP_SIGNATURE_SANDBOX;
		$API_Endpoint = PP_NVP_ENDPOINT_SANDBOX;
		$PAYPAL_URL = PP_CHECKOUT_URL_SANDBOX;
	}
	else  // API Credentials and URLs for Live
	{
		$API_UserName=PP_USER;
		$API_Password=PP_PASSWORD;
		$API_Signature=PP_SIGNATURE;
		$API_Endpoint = PP_NVP_ENDPOINT_LIVE;
		$PAYPAL_URL = PP_CHECKOUT_URL_LIVE;
	}

	// BN Code 	is only applicable for partners
	$sBNCode = SBN_CODE;

	$version=API_VERSION;


	/*
	* Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
	* Inputs:
	*		parameterArray:     the item details, prices and taxes
	*		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	*		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	*/
	function CallShortcutExpressCheckout( $paramsArray, $returnURL, $cancelURL)
	{
		//------------------------------------------------------------------------------------------------------------------------------------
		// Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation
		// For more information on the customizing the parameters passed refer: https://developer.paypal.com/docs/classic/express-checkout/integration-guide/ECCustomizing/

		//Mandatory parameters for SetExpressCheckout API call
		if(isset($paramsArray["PAYMENTREQUEST_0_AMT"]))
		{
			$nvpstr = "&PAYMENTREQUEST_0_AMT=". $paramsArray["PAYMENTREQUEST_0_AMT"];
			$_SESSION["Payment_Amount"]= $paramsArray["PAYMENTREQUEST_0_AMT"];
		}

		if(isset($paramsArray["paymentType"]))
		{
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" .  $paramsArray["paymentType"];
			$_SESSION["PaymentType"] = $paramsArray["paymentType"];
		}

		if(isset($returnURL))
		$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;

		if(isset($cancelURL))
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;

		//Optional parameters for SetExpressCheckout API call
		if(isset($paramsArray["L_PAYMENTREQUEST_0_NAME0"]))
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_NAME0=" . $paramsArray["L_PAYMENTREQUEST_0_NAME0"];

		if(isset($paramsArray["L_PAYMENTREQUEST_0_NUMBER0"]))
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_NUMBER0=" . $paramsArray["L_PAYMENTREQUEST_0_NUMBER0"];

		if(isset($paramsArray["L_PAYMENTREQUEST_0_DESC0"]))
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_DESC0=" . $paramsArray["L_PAYMENTREQUEST_0_DESC0"];

		if(isset($paramsArray["L_PAYMENTREQUEST_0_AMT0"]))
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_AMT0=" . $paramsArray["L_PAYMENTREQUEST_0_AMT0"];

		if(isset($paramsArray["L_PAYMENTREQUEST_0_QTY0"]))
		$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_QTY0=" . $paramsArray["L_PAYMENTREQUEST_0_QTY0"];

		if(isset($paramsArray["LOGOIMG"]))
		$nvpstr = $nvpstr . "&LOGOIMG=". $paramsArray["LOGOIMG"];

		if(isset($paramsArray["NOSHIPPING"]))
		$nvpstr = $nvpstr . "&NOSHIPPING=". $paramsArray["NOSHIPPING"];

		if(isset($paramsArray["BRANDNAME"]))
		$nvpstr = $nvpstr . "&BRANDNAME=". $paramsArray["BRANDNAME"];

		if(isset($paramsArray["PAYMENTREQUEST_0_NOTIFYURL"]))
		$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_NOTIFYURL=". $paramsArray["PAYMENTREQUEST_0_NOTIFYURL"];


		/*
		* Make the API call to PayPal
		* If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.
		* If an error occured, show the resulting errors
		*/
	    $resArray=hash_call("SetExpressCheckout", $nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$token = urldecode($resArray["TOKEN"]);
			$_SESSION['TOKEN']=$token;
		}
	    return $resArray;
	}

	/*
	* Purpose: 	Returns Payers and Payment Details based on returned TOKEN
	* Inputs:
	*		token:     token number returned from SetExpressCheckout
	*/
	function CallExpressCheckoutDetails($token)
	{
		$nvpstr = "&TOKEN=". $token;
		$resArray=hash_call("GetExpressCheckoutDetails", $nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$_SESSION['PAYERID'] =	$resArray['PAYERID'];
		}
		return $resArray;
	}

	/*
	* Purpose: 	Prepares the parameters for the DoExpressCheckoutPayment API Call.
	* Inputs:   FinalPaymentAmount:	The total transaction amount.
	* Returns: 	The NVP Collection object of the DoExpressCheckoutPayment Call Response.
	*/
	function CallConfirmPayment( $FinalPaymentAmt )
	{
		/* Gather the information to make the final call to finalize the PayPal payment.  The variable nvpstr
         * holds the name value pairs
		 */

		//mandatory parameters in DoExpressCheckoutPayment call
		if(isset($_SESSION['TOKEN']))
		$nvpstr = '&TOKEN=' . urlencode($_SESSION['TOKEN']);

		if(isset($_SESSION['PAYERID']))
		$nvpstr .= '&PAYERID=' . urlencode($_SESSION['PAYERID']);

		if(isset($_SESSION['PaymentType']))
		$nvpstr .= '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode($_SESSION['PaymentType']);

		if(isset($_SERVER['SERVER_NAME']))
		$nvpstr .= '&IPADDRESS=' . urlencode($_SERVER['SERVER_NAME']);

		$nvpstr .= '&PAYMENTREQUEST_0_AMT=' . $FinalPaymentAmt;


		 /* Make the call to PayPal to finalize payment
          * If an error occured, show the resulting errors
		  */


		$resArray=hash_call("DoExpressCheckoutPayment", $nvpstr);

		/* Display the API response back to the browser.
		 * If the response from PayPal was a success, display the response parameters'
		 * If the response was an error, display the errors received using APIError.php.
		 */
		$ack = strtoupper($resArray["ACK"]);

		return $resArray;
	}

	/*
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	*/
	function hash_call($methodName,$nvpStr)
	{
		//declaring of global variables
		global $API_Endpoint, $version , $API_UserName, $API_Password, $API_Signature;
		global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
		global $gv_ApiErrorURL;
		global $sBNCode;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION ,CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);

	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
		if($USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, $PROXY_HOST. ":" . $PROXY_PORT);

		//NVPRequest for submitting to server
		$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($version) . "&PWD=" . urlencode($API_Password) . "&USER=" . urlencode($API_UserName) . "&SIGNATURE=" . urlencode($API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($sBNCode);

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		//getting response from server
		$response = curl_exec($ch);

		//convrting NVPResponse to an Associative Array
		$nvpResArray=deformatNVP($response);
		$nvpReqArray=deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch))
		{
			// moving to display page to display curl errors
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);

			  //Execute the Error handling module to display errors.
		}
		else
		{
			 //closing the curl
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	/*
	* Purpose: Redirects to PayPal.com site.
	* Inputs:  NVP string.
	*  Returns:
	*/
	function RedirectToPayPal ( $token )
	{
		global $PAYPAL_URL;

		// Redirect to paypal.com here
		// With useraction=commit user will see "Pay Now" on Paypal website and when user clicks "Pay Now" and returns to our website we can call DoExpressCheckoutPayment API without asking the user
		$payPalURL = $PAYPAL_URL. $token ;
		if($_SESSION['EXPRESS_MARK'] == 'ECMark'){
			$payPalURL = $payPalURL. '&useraction=commit';
		} else {
		if(USERACTION_FLAG)
			$payPalURL = $payPalURL. '&useraction=commit';
		}

		header("Location:".$payPalURL);
		exit;
	}


	/*
	  * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	  */
	function deformatNVP($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();

		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}

?>
