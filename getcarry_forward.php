<?php 
require_once '/usr/share/pear/XML/RPC.php'; 

$acc_ids = array('0047-1003-FTTH-000784','0024-0991-FTTH-000813','0008-0999-FTTH-000795','0008-0999-FTTH-000794','0024-0991-FOC--000812','0047-1003-FTTH-000998','0047-1003-FTTH-001004','0008-0999-FTTH-001010','0008-0999-FTTH-000995','0047-1003-FOC--000800');

echo "actid \t billPeriod \t subsno \t rcTopUp \t nrcTopUp \t fup \t carryForward \t fupTotal\r\n";
foreach($acc_ids as $account_id){
$get_subs = getSubscriptions($account_id);

 $actno =  $get_subs[0]['actno'];
#exit;
$from_date =  date("Ymd\TH:i:s",strtotime("20150301"));
$to_date =  date("Ymd\TH:i:s",strtotime("20150401"));

$getvol = getquota($actno,$from_date,$to_date);
if(!empty($getvol[0]['actid'])){
echo $getvol[0]['actid']."\t".$getvol[0]['billPeriod']."\t".$getvol[0]['subsno']."\t".$getvol[0]['rcTopUp']."\t".$getvol[0]['nrcTopUp']."\t".$getvol[0]['fup']."\t".$getvol[0]['carryForward']."\t".$getvol[0]['fupTotal']."\r\n";
}
}


function getSubscriptions($account_id){
$params = array(new XML_RPC_Value($account_id, 'string'));
$msg = new XML_RPC_Message('unify.getSubscriptions', $params);
$cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli->setCredentials('ftth_spectra','ftth_spectra');
$resp = $cli->send($msg);
if (!($resp->faultCode()))
{
$val = $resp->value();
$Subscription_detail = XML_RPC_decode($val);
#return $Subscription_detail;
}else
{
    echo 'Fault Code: ' . $resp->faultCode() . "\n";
    echo 'Fault Reason: ' . $resp->faultString() . "\n";
    $Subscription_detail=  $resp->faultString();
}
return $Subscription_detail;
}

function getquota($actno,$from_date,$to_date){ 
$params = array(  new XML_RPC_Value($actno, 'int'), # int account no
#		  new XML_RPC_Value($from_date, 'dateTime.iso8601'),  # date Bill Start date
		  new XML_RPC_Value($from_date, 'string'),
                  new XML_RPC_Value($to_date, 'string')  # date Bill end date
          );
$msg1 = new XML_RPC_Message('unify.getVolumeQuotaDetails', $params); 
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66'); 
$cli1->setCredentials('ftth_spectra','ftth_spectra'); 
$resp1 = $cli1->send($msg1); 
 ####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify.getVolumeQuotaDetails request param:\n" . $msg1->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify.getVolumeQuotaDetails response:\n" . $resp1->serialize ()."<br>";
// echo $FTTH_LOG;
        if (!$resp1)  
        { 
            $result = 'Communication error: ' . $cli1->errstr; 
            return $result; 
        } 
 
        if (!($resp1->faultCode()))  
        { 
        $val1 = $resp1->value(); 
        $result = XML_RPC_decode($val1); 
        } 
        else 
        { 
            echo 'Fault Code: ' . $resp1->faultCode() . "\n"; 
            echo 'Fault Reason: ' . $resp1->faultString() . "\n"; 
	   
        } 
return $result; 
} 


?>
