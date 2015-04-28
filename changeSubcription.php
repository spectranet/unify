<?php
require_once '/usr/share/pear/XML/RPC.php';

	$subno = "2088067";
	$pkgid = "AdvantageUL_QCP";
        $start_date = date("Ymd\TH:i:s", strtotime("23-02-2015 17:00:00"));
        $get_nrc = changeSubscription($subno,$pkgid,$start_date);
 #       print_r($get_nrc);

function changeSubscription($subno,$pkgid,$start_date){

$params = array(new XML_RPC_Value($subno, 'int'),
        new XML_RPC_Value($pkgid, 'string'),
        new XML_RPC_Value($start_date, 'dateTime.iso8601'),
	new XML_RPC_Value(1, 'int'),
	new XML_RPC_Value(0, 'int'),
	new XML_RPC_Value(0, 'int'),
	new XML_RPC_Value(0, 'int'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),	
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
	new XML_RPC_Value(" ", 'string'),
        );

$msg1 = new XML_RPC_Message('unify.changeSubscription', $params);
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
$NRCsForAccount1 = XML_RPC_decode($val1);
echo "<hr><h1>changeSubscription:</h1>";
print_r($NRCsForAccount1);
//return $NRCsForAccount1;
}

}


?>
