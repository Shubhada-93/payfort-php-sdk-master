<?php

    $redirectUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
    $return_url = 'enter_your_return_url_here';

    $requestParams = array(
        'command' => 'PURCHASE',
        'access_code' => '7leCwrdyaAsT68IaSLbe',
        'merchant_identifier' => 'a894b168',
        'merchant_reference' =>  '5000-'.time(),
        'amount' => "100",
        'currency' => 'AED',
        'language' => 'en',
        'customer_email' => 'shubhadamaratkar.1993@gmail.com',
        'token_name' => 'ali',
        'return_url' => 'http://localhost/payfort-php-sdk-master/template/',
        'card_security_code' => '123',
    );

    // calculating signature
    $shaString = '';
    ksort($requestParams);
    $SHARequestPhrase   = '09zIXJLQgiyXALEcgRyeSs)_';
    $SHAResponsePhrase   = '82z5yJZQOSW7zJBz18MIbt!_';
    $SHAType       = 'sha256';
    foreach ($requestParams as $k => $v) {
        $shaString .= "$k=$v";
    }
    
    if ($signType == 'request') 
        $shaString = $SHARequestPhrase . $shaString . $SHARequestPhrase;
    else 
        $shaString = $SHAResponsePhrase . $shaString . $SHAResponsePhrase;

    $signature = hash($SHAType, $shaString);

    $requestParams['signature'] = hash($SHAType, $shaString);

    // calling payfort api using curl
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=UTF-8',
            //'Accept: application/json, application/*+json',
            //'Connection:keep-alive'
    ));
    curl_setopt($ch, CURLOPT_URL, $redirectUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects     
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // The number of seconds to wait while trying to connect
    //curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['apiCallTimeout']); // timeout in seconds
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams));

    $response = curl_exec($ch);

    curl_close($ch);
echo $response;
    return $response;