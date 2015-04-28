<?php
require_once '/usr/share/pear/XML/RPC.php';

	$level = "S"; //Set to A or S to mean apply at account level or subscription level
	$actno = "1871426"; 	// represents Account no
	$bucno = "111"; 	// represents unit credit No.
	$subno = "2091020"; // represents subscription no
	$start_date =  date("Ymd\TH:i:s",strtotime("20150302")); // represents unit credit start Date 


$params = array(
        new XML_RPC_Value($level, 'string'),	// java.lang.String level
	new XML_RPC_Value($actno, 'int'),	// int actno
	new XML_RPC_Value($bucno, 'int'),
	new XML_RPC_Value($subno, 'int'),	// int subsno
	new XML_RPC_Value($start_date, 'dateTime.iso8601'),  // java.util.Date createdt
        );

$msg1 = new XML_RPC_Message('unify.saveAccountUnitcredit', $params);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);

####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify.saveAccountUnitcredit request param:\n" . $msg1->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify.saveAccountUnitcredit response:\n" . $resp1->serialize ()."<br>";
 echo $FTTH_LOG;

if (!$resp1)
{
    echo 'Communication error: ' . $cli1->errstr;
}
if (!($resp1->faultCode()))
{
$val1 = $resp1->value();
$response = XML_RPC_decode($val1);
}



?>
