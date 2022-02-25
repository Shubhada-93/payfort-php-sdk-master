
<?php
$merchant_reference='5000-'.time();
$arrData              = array(
    'merchant_identifier' => 'a894b168',
    'access_code'         => '7leCwrdyaAsT68IaSLbe',
    'merchant_reference'  => $merchant_reference,
    'service_command'     => 'TOKENIZATION',
    'language'            => 'en',
    'return_url'          => 'http://localhost/payfort-php-sdk-master/template/resp.php',
);

$shaString = '';
    ksort($arrData);
    $SHARequestPhrase   = '09zIXJLQgiyXALEcgRyeSs)_';
    $SHAResponsePhrase   = '82z5yJZQOSW7zJBz18MIbt!_';
    $SHAType       = 'sha256';
    foreach ($arrData as $k => $v) {
        $shaString .= "$k=$v";
    }
    $signType='request';
    if ($signType == 'request') 
        $shaString = $SHARequestPhrase . $shaString . $SHARequestPhrase;
    else 
        $shaString = $SHAResponsePhrase . $shaString . $SHAResponsePhrase;

    $signature = hash($SHAType, $shaString);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Fort Request</title>
</head>
<body>
<iframe  style="border:5px dotted red" name="myframe" src = "" width="400" height="600">
</iframe>
<form action="https://sbcheckout.payfort.com/FortAPI/paymentPage" method="post" target="myframe">
<INPUT type="hidden" NAME="service_command" value="TOKENIZATION">
<INPUT type="hidden" NAME="language" value="en">
<INPUT type="hidden" NAME="merchant_identifier" value="a894b168">
<INPUT type="hidden" NAME="access_code" value="7leCwrdyaAsT68IaSLbe">
<INPUT type="hidden" NAME="signature" value="<?php echo $signature;?>">
<INPUT type="hidden" NAME="return_url" value="http://localhost/payfort-php-sdk-master/template/resp.php">
<INPUT type="hidden" NAME="merchant_reference" value="<?php echo $merchant_reference;?>">
<input value="Send" type="submit" id="form1">
</form>
</body>
</html>