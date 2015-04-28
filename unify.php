<?php
require_once '/usr/share/pear/XML/RPC.php';


function getAccountDetails($account_id){
$params = array(new XML_RPC_Value($account_id, 'string'));
$msg1 = new XML_RPC_Message('unify.getAccountDetails', $params);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);
	if (!$resp1) 
	{
	    $result = 'Communication error: ' . $cli1->errstr;
	    return $result;
	}

	if (!($resp1->faultCode())) 
	{
	$val1 = $resp1->value();
	$result = XML_RPC_decode($val1);
	#echo "<hr><h1>Account Details:</h1>";
	#print_r($account_detail);
	}
	else
	{
	    echo 'Fault Code: ' . $resp1->faultCode() . "\n";
	    echo 'Fault Reason: ' . $resp1->faultString() . "\n";
	}
return $result;
}

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
return $Subscription_detail;
#echo "<hr><h1>Subscription Details:</h1>";
#echo $subsno=$Subscription_detail[0]['subsno'];
#print_r($Subscription_detail);
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

function getTransactions($account_no){
$paramss= array( 'limit'      => new XML_RPC_Value('30'),
                 'order' => new XML_RPC_Value('desc'),
                 'fromDate'      => new XML_RPC_Value(date('Y-m-d', strtotime("today - 3 months"))));
$parm=array(new XML_RPC_Value($account_no, 'int'),
            new XML_RPC_Value($paramss, 'struct'));
$msg2 = new XML_RPC_Message('unify.getTransactions', $parm);
$cli2 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli2->setCredentials('ftth_spectra','ftth_spectra');
$resp2 = $cli2->send($msg2);
if (!$resp2)
{
   echo 'Communication error: ' . $cli2->errstr;
}
if (!($resp2->faultCode()))
{
$val2 = $resp2->value();
$Transaction_detail = XML_RPC_decode($val2);
#echo "<hr><h1>Transaction Details:</h1>";
#print_r($Transaction_detail);
return $Transaction_detail;
}
else
{
    echo 'Fault Code: ' . $resp->faultCode() . "\n";
    echo 'Fault Reason: ' . $resp->faultString() . "\n";
    $Transaction_detail=  $resp->faultString();
    echo "Transaction:";
    print_r($Transaction_detail);
}
}

function getRC($actid,$getClosed,$from_date,$to_date){
$params = array(new XML_RPC_Value($actid, 'string'),
        new XML_RPC_Value($getClosed, 'boolean'),
        new XML_RPC_Value($from_date, 'dateTime.iso8601'),
        new XML_RPC_Value($to_date, 'dateTime.iso8601'),
        );

$msg1 = new XML_RPC_Message('unify.getRCsForAccount', $params);
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
$RCsForAccount1 = XML_RPC_decode($val1);
return $RCsForAccount1;
#print_r($RCsForAccount1);
}
}

function getNRC($actid,$getClosed,$from_date,$to_date){
$params = array(new XML_RPC_Value($actid, 'string'),
        new XML_RPC_Value($getClosed, 'boolean'),
        new XML_RPC_Value($from_date, 'dateTime.iso8601'),
        new XML_RPC_Value($to_date, 'dateTime.iso8601'),
        );

$msg1 = new XML_RPC_Message('unify.getNRCsForAccount', $params);
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
#echo "<hr><h1>getNRCsForAccount:</h1>";
#print_r($RCsForAccount1);
return $NRCsForAccount1;
}

}

function getInvoices($actno){
$params = array(new XML_RPC_Value($actno, 'int'));

$msg1 = new XML_RPC_Message('unify.getInvoices', $params);
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
$invoices_list = XML_RPC_decode($val1);
return $invoices_list;
#echo "<hr><h1>getInvoiceDetail:</h1>";
#print_r($invoices_list);
}
}

function view_invoice($invoicenos){
$type = "HTML";	
$params = array(new XML_RPC_Value($invoicenos, 'int', $type, 'string'));
                $msg1 = new XML_RPC_Message('unify.getInvoice', $params);
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
                $InvoiceLineItem = XML_RPC_decode($val1);
#                echo "<hr><h1>getInvoiceLineItem:</h1>";
#                print_r($InvoiceLineItem[content]);
		
		return $InvoiceLineItem[content];
		}
}

function getAccountAuditTrail($actid,$dateStart,$dateEnd)
{
$params = array(new XML_RPC_Value($actid, 'string'),
	new XML_RPC_Value($dateStart, 'dateTime.iso8601'),
	new XML_RPC_Value($dateEnd, 'dateTime.iso8601'));

$msg1 = new XML_RPC_Message('unify.getAccountAuditTrail', $params);
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
$audit_trail = XML_RPC_decode($val1);
#echo "<hr><h1>getInvoiceDetail:</h1>";
#print_r($audit_trail);
return $audit_trail;
}

}


function getSessionHistory($account_id,$start_date,$to_date){
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
$getSessionHistory = XML_RPC_decode($val1);
return $getSessionHistory;
#echo "<hr><h1>getSessionHistory:</h1>";
#print_r($getSessionHistory);
}
/*echo "<table border=1>";
foreach ($getSessionHistory as $session1)
{
echo "<tr><td>";
echo $session1['start'];
echo "</td><td>";
echo $session1['lastupd'];
echo "</td><td>";
echo $session1['totalbytes'];
echo "</td></tr>";
}
*/

}

#$account_id="0008-0999-BANG-011376";
#$get_acc = getAccountDetails($account_id);
#$get_sub = getSubscriptions($account_id);
#print_r($get_acc);

?>
