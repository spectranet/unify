<?php 
require_once '/usr/share/pear/XML/RPC.php'; 
include("array2xml.php");


function getNewAccountList($from_date,$to_date){ 
$params = array(  new XML_RPC_Value($from_date, 'dateTime.iso8601'),
                  new XML_RPC_Value($to_date, 'dateTime.iso8601')  # date Bill end date
          );
$msg1 = new XML_RPC_Message('unify.getNewAccountList', $params); 
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66'); 
$cli1->setCredentials('ftth_spectra','ftth_spectra'); 
$resp1 = $cli1->send($msg1); 
 ####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify.getNewAccountList request param:\n" . $msg1->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify.getNewAccountList response:\n" . $resp1->serialize ()."<br>";
# echo $FTTH_LOG;
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



echo "<br> Start Date: ";
echo $from_date =  date("Ymd\TH:i:s",strtotime("20150331"));
echo "<br> End Date: ";
echo $to_date =  date("Ymd\TH:i:s",strtotime("20150401"));

echo "<hr><h1>API getNewAccountList:</h1>";
$getvol = getNewAccountList($from_date,$to_date);
print_r($getvol); 
#$xml = new array2xml($getvol, "getNewAccountList");
#print_r($xml->output);

?>
