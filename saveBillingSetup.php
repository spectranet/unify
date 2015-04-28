<?php
require_once '/usr/share/pear/XML/RPC.php';

$bill_date = date("Ymd\TH:i:s",strtotime("20150401"));
$params = array(new XML_RPC_Value($bill_date, 'dateTime.iso8601'),            #java.util.Date billDate,
                new XML_RPC_Value('M', 'string'),                          #java.lang.String billCyclePeriod,
                new XML_RPC_Value('1', 'int'),            #int billCycleDuration,
                new XML_RPC_Value('true', 'boolean'),            #boolean runInvoice,
                new XML_RPC_Value('1871426', 'int'),            #java.lang.Integer actno,
                new XML_RPC_Value('72', 'int'),            #java.lang.Integer itno,
                new XML_RPC_Value('73', 'int'),            #java.lang.Integer rtno,
                new XML_RPC_Value('128', 'int'),             #java.lang.Integer bpno
		new XML_RPC_Value('bill-profile', 'string')			#java.lang.String skipZeroValueInvoice
		);

$msg = new XML_RPC_Message('unify.saveBillingSetup', $params);
$cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli->setCredentials('ftth_spectra','ftth_spectra');
$resp = $cli->send($msg);

####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify.saveBillingSetup request param:\n" . $msg->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify.saveBillingSetup response:\n" . $resp->serialize ()."<br>";
 echo $FTTH_LOG;

if (!$resp)
{
$result = 'Communication error: ' . $cli->errstr;
return $result;
}
if (!($resp->faultCode()))
{
$val = $resp->value();
$Subscription_detail = XML_RPC_decode($val);
#return $Subscription_detail;
echo "<hr><h1>saveBillingSetup:</h1>";
print_r($Subscription_detail);
}
else
{
    echo 'Fault Code: ' . $resp->faultCode() . "\n";
    echo 'Fault Reason: ' . $resp->faultString() . "\n";
    $Subscription_detail=  $resp->faultString();
    echo "Error saveBillingSetup:";
    print_r($Subscription_detail);
}

?>
