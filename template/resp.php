<?php
//print_r($_GET);
//print_r($_POST);
$redirectUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
$fortParams = array_merge($_GET, $_POST);

$requestParams = array(
    'merchant_reference' =>  $fortParams['merchant_reference'],
    'access_code' => '7leCwrdyaAsT68IaSLbe',
    'command' => 'PURCHASE',
    'merchant_identifier' => 'a894b168',
    'customer_ip'         => $_SERVER['REMOTE_ADDR'],
    'amount' => "100",
    'currency' => 'AED',
    'customer_email' => 'shubhadamaratkar.1993@gmail.com',
    'customer_name'       => 'John Doe',
    'token_name' => $fortParams['token_name'],
    'language' => 'en',
    'return_url'=> 'http://localhost/payfort-php-sdk-master/template/success.php',
    
);
$shaString = '';
ksort($requestParams);
foreach ($requestParams as $key => $value) {
    $shaString .= "$key=$value";
}
$SHARequestPhrase   = '09zIXJLQgiyXALEcgRyeSs)_';
$SHAResponsePhrase   = '82z5yJZQOSW7zJBz18MIbt!_';
$SHAType       = 'sha256';
// make sure to fill your sha request pass phrase
$shaString = $SHARequestPhrase . $shaString . $SHARequestPhrase;
$signature = hash($SHAType, $shaString);
// your request signature
$requestParams['signature'] = $signature;
$requestParams=json_encode($requestParams);

        $result = file_get_contents('https://sbpaymentservices.payfort.com/FortAPI/paymentApi', null, stream_context_create(array(
                'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json' . "\r\n"
                . 'Content-Length: ' . strlen($requestParams) . "\r\n",
                'content' => $requestParams,
                ),
            )
        ));

        $result=json_decode($result,true);
        
        //$Params = array_merge($_GET, $_POST);
       // print_r($result);
        
        $response_code = $result['response_code'];
                            if ($response_code == '20064' && isset($result['3ds_url'])) {
                               echo $success = true;
                                
                                echo "<html><body onLoad=\"javascript: window.top.location.href ='" . $result['3ds_url'] . "'\"></body></html>";
                                exit;
                                //header('location:'.$params['3ds_url']);
                            }