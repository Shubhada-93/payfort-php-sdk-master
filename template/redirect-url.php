<?php
$merchant_reference='5000-'.time();
$requestParams = array(
'merchant_reference' => $merchant_reference,
'access_code' => '7leCwrdyaAsT68IaSLbe',
'command' => 'PURCHASE',
'merchant_identifier' => 'a894b168',
'amount' => '10000',
'currency' => 'AED',
'language' => 'en',
'customer_email' => 'test@payfort.com',
'order_description' => 'iPhone 6-S',
'return_url'          => 'http://localhost/payfort-php-sdk-master/template/success.php'
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

$redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
echo "<html xmlns='https://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
echo "<form action='$redirectUrl' method='post' name='frm'>\n";
foreach ($requestParams as $a => $b) {
    echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
}
echo "\t<script type='text/javascript'>\n";
echo "\t\tdocument.frm.submit();\n";
echo "\t</script>\n";
echo "</form>\n</body>\n</html>";