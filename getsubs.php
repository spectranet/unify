<?php
require_once '/usr/share/pear/XML/RPC.php';

$account_id = "0024-0991-FTTH-000813";
getSubscriptions($account_id);

function getSubscriptions($account_id){
$params = array(new XML_RPC_Value($account_id, 'string'));
$msg = new XML_RPC_Message('unify.getSubscriptions', $params);
$cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli->setCredentials('ftth_spectra','ftth_spectra');
$resp = $cli->send($msg);
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
echo "<hr><h1>Subscription Details:</h1>";
#echo $subsno=$Subscription_detail[0]['subsno'];
print_r($Subscription_detail);
}
else
{
    echo 'Fault Code: ' . $resp->faultCode() . "\n";
    echo 'Fault Reason: ' . $resp->faultString() . "\n";
    $Subscription_detail=  $resp->faultString();
    echo "subscription:";
    print_r($Subscription_detail);
}
}

?>
