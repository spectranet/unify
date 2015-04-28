<?php
require_once '/usr/share/pear/XML/RPC.php';

$account_no = "1865830";
$paid_amount = "1";
$paymentmode = "C";                                    
$ePGTxnID = "123456789";                                    


$output = addPayment($account_no,$paid_amount,$paymentmode,$ePGTxnID);
print_r($output);

function addPayment($account_no,$paid_amount,$paymentmode,$ePGTxnID,$xmlRPC=null){
$params23 = array(new XML_RPC_Value($account_no , 'int'), 
	new XML_RPC_Value($paid_amount, 'double'),  
	new XML_RPC_Value($paymentmode, 'string'),
	new XML_RPC_Value(date('Ymd\TH:i:s'), 'dateTime.iso8601'),
	new XML_RPC_Value('INR', 'string'),
	new XML_RPC_Value(8, 'int'),
	new XML_RPC_Value($ePGTxnID, 'string'), 
	new XML_RPC_Value('Online Payment', 'string')
	);

$msg1 = new XML_RPC_Message('unify.addTransaction', $params23);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);
print_r($resp1);
if (!$resp1)
{
    echo 'Communication error: ' . $cli1->errstr;
}
if (!($resp1->faultCode()))
{
$val1 = $resp1->value();
$addp = XML_RPC_decode($val1);
return $addp;
echo "<hr><h1>ADD Payment:</h1>";
print_r($addp);
}
}

?>
