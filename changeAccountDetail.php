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

function changeAccountDetails($account_id,$fname,$lname,$phone,$email,$password){
$params = array(new XML_RPC_Value($account_id, 'string'),		#java.lang.String actid,
                new XML_RPC_Value($fname, 'string'),    	        #java.lang.String fname,
                new XML_RPC_Value($lname, 'string'),                	#java.lang.String lname,
		new XML_RPC_Value($phone, 'string'),                	#java.lang.String phone,
		new XML_RPC_Value($email, 'string'),                	#java.lang.String email,
		new XML_RPC_Value($password, 'string')                	#java.lang.String password
);
$msg1 = new XML_RPC_Message('unify.changeAccountDetails', $params);
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
        }
        else
        {
            echo 'Fault Code: ' . $resp1->faultCode() . "\n";
            echo 'Fault Reason: ' . $resp1->faultString() . "\n";
        }
return $result;
}

$account_id = "8588826409";
$get_acc = getAccountDetails($account_id);
#print_r($get_acc);
echo $get_acc['email'];
echo "\nAfter Change Email id :\n";
$fname = $get_acc['fname'];
$lname = $get_acc['lname'];
$phone = $get_acc['phone'];
#$email = $get_acc[email];
$email = "amit.dubey1@spectranet.in";
$password = $get_acc['password'];
$getresp = changeAccountDetails($account_id,$fname,$lname,$phone,$email,$password);
if($getresp == 0){ 
	$get_acc = getAccountDetails($account_id);
	echo $get_acc['email'];
}else{
	echo "Not Change Email id";
}
?>

