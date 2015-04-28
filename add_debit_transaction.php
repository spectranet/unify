<?php
require_once '/usr/share/pear/XML/RPC.php';

$count = 0;
if (($handle = fopen("debit_data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $count++;
	if(isset($data[0])){
        	$can_id = trim($data[0]);
		echo $can_id."\t";
        }else{
		echo "Error! In CAN ID";
		exit;
	}
	if(isset($data[1])){
        	$paid_amount = trim($data[1]);
		echo $paid_amount."\t";
        }else{
		echo "Error! In Amount";
		exit;
	}

	if(isset($data[2])){
                $desc = trim($data[2]);
                echo $desc."\t";
        }else{
                echo "Error! In Trans Desc";
                exit;
        }

	if(isset($data[3])){
                $instument_desc = trim($data[3]);
                echo $instument_desc."\t";
        }else{
                echo "Error! In Instument Desc";
                exit;
        }

	$get_acc = getAccountDetails($can_id);	
	$account_no = $get_acc['actno'];
	echo $account_no."\t";
	$output = addPayment($account_no,$paid_amount,$desc,$instument_desc);
	print_r($output);
	echo "\n";
 }// close loop
fclose($handle);
}// close if

function addPayment($account_no,$paid_amount,$desc,$instument_desc,$xmlRPC=null){
$params23 = array(new XML_RPC_Value($account_no , 'int'), 
	new XML_RPC_Value($paid_amount, 'double'),  
	new XML_RPC_Value('C', 'string'),
	new XML_RPC_Value(date('Ymd\TH:i:s'), 'dateTime.iso8601'),
	new XML_RPC_Value('INR', 'string'),
	new XML_RPC_Value(8, 'int'),
	new XML_RPC_Value($instument_desc, 'string'), 
	new XML_RPC_Value($desc, 'string')
	);

$msg1 = new XML_RPC_Message('unify.addTransaction', $params23);
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
	$addp = XML_RPC_decode($val1);
	}else
        {
            echo 'Fault Code: ' . $resp1->faultCode() . "\n";
            echo 'Fault Reason: ' . $resp1->faultString() . "\n";
        }
return $addp;
}


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
        }
        else
        {
            echo 'Fault Code: ' . $resp1->faultCode() . "\n";
            echo 'Fault Reason: ' . $resp1->faultString() . "\n";
        }
return $result;
}

?>
