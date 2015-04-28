<?php
require_once '/usr/share/pear/XML/RPC.php';
 
echo $account_id = "0019-0991-DELH-028018";
echo "<br>";
echo $start_date =  date("Ymd\TH:i:s",strtotime("20140820"));
echo "<br>";
echo $to_date =  date("Ymd\TH:i:s",strtotime("20140822"));

	$params23 = array(new XML_RPC_Value($start_date, 'dateTime.iso8601'),  # date from date
		  new XML_RPC_Value($to_date, 'dateTime.iso8601'),  # date to date
	          new XML_RPC_Value($account_id, 'string') # string account id
		  );

$msg1 = new XML_RPC_Message('unify.getSessionHistory', $params23);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);
if (!$resp1)
{
    echo 'Communication error: ' . $cli1->errstr;
}
if (!($resp1->faultCode()))
{
$val1 = $resp1->value();
echo "<hr><h1>getSessionHistory:</h1>";
$getSessionHistory = XML_RPC_decode($val1);
#return $getSessionHistory;
echo "<hr><h1>getSessionHistory:</h1>";
print_r($getSessionHistory);
}

?>
