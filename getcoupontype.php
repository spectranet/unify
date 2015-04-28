<?php 
require_once '/usr/share/pear/XML/RPC.php'; 

$domno ="2222";
$subsno = "2045472";
$pkgno = "728";
$obj[] = new XML_RPC_Value($subsno=$pkgno);


$getvol = getcoupon($domno,$subsno);
print_r($getvol); 
 

function getcoupon($domno,$subsno){ 
$params = array(  new XML_RPC_Value($domno, 'int'), # int account no
		  new XML_RPC_Value('true', 'boolean'),  # date from date
		  new XML_RPC_Value($obj, 'array')
          );
$msg1 = new XML_RPC_Message('unify.getCouponTypes', $params); 
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

?>
