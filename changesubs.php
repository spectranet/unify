<?php
require_once '/usr/share/pear/XML/RPC.php';

	$subno = "2089016";
	$pkgid = "BIA5";
        $get_response = changeSubs($subno,$pkgid);
 #       print_r($get_response);

function changeSubs($subno,$pkgid){

$rcClassList[]  = new XML_RPC_Value("210=350"); // BIA 5
$nrc[] = new XML_RPC_Value("159","int"); // BIAOTC

$params = array(
        new XML_RPC_Value($pkgid, 'string'),	// java.lang.String pkgid
	new XML_RPC_Value($subno, 'int'),	//int subsno
	new XML_RPC_Value(false, 'boolean'),	// boolean creditUnusedQuotaOrValidity
	new XML_RPC_Value($rcClassList, 'array'),	// java.lang.String[] rateClassList
	new XML_RPC_Value($nrc, 'array'),	// int[] ignoredNRC
#	new XML_RPC_Value('159', 'int'),
        );

$msg1 = new XML_RPC_Message('unify.changeSubs', $params);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);

####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify.changeSubs request param:\n" . $msg1->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify.changeSubs response:\n" . $resp1->serialize ()."<br>";
 echo $FTTH_LOG;

if (!$resp1)
{
    echo 'Communication error: ' . $cli1->errstr;
}
if (!($resp1->faultCode()))
{
$val1 = $resp1->value();
$response = XML_RPC_decode($val1);
//echo "<hr><h1>changeSubs:</h1>";
//print_r($response);
//return $NRCsForAccount1;
}

}


?>
