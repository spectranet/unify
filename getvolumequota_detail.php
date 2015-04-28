<?php 
require_once '/usr/share/pear/XML/RPC.php'; 

echo "Parameters<br> Account no: ";
#echo $actno = "1865829";
echo $actno = "1845423";
echo "<br> Bill Start Date: ";
echo $from_date =  date("Ymd\TH:i:s",strtotime("20150301"));
echo "<br> Bill End Date: ";
echo $to_date =  date("Ymd\TH:i:s",strtotime("20150401"));

echo "<hr><h1>API getVolumeQuotaDetails:</h1>"; 
$getvol = getquota($actno,$from_date,$to_date);
print_r($getvol); 
 

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
 echo $FTTH_LOG;
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

?>
