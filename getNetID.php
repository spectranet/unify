<?php
require_once '/usr/share/pear/XML/RPC.php';
 
#echo $account_id = "0019-0991-SMS-012138";
#echo "<br>";
echo $account_id = "0000-0000-TEST-000031";
echo "<br>";
$output = getNetID($account_id);
//print_r($output);

function getNetID($account_id){
$temp = explode("-",$account_id);
$username = $temp[count($temp)-1]; 
#exit;
$params = array(new XML_RPC_Value($account_id, 'string'));
$msg = new XML_RPC_Message('unify.getSubscriptions', $params);
$cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli->setCredentials('ftth_spectra','ftth_spectra');
$resp = $cli->send($msg);
if (!$resp)
{
    echo 'Communication error: ' . $cli1->errstr;
}
	if (!($resp->faultCode()))
	{
	$val = $resp->value();
	$getSubs = XML_RPC_decode($val);
	 #print_r($getSubs);
	  for($i = 0; $i < count($getSubs); $i++)
	   {
		$subsno = $getSubs[$i]['subsno'];
		$params1 = array(new XML_RPC_Value($subsno, 'int'));
		$msg1 = new XML_RPC_Message('unify.getNetIDs', $params1);
		$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
		$cli1->setCredentials('ftth_spectra','ftth_spectra');
		$resp1 = $cli1->send($msg1);
		if (!($resp1->faultCode()))
		{
		        $val1 = $resp1->value();
		        $getNetid = XML_RPC_decode($val1);
			#print_r($getNetid);
			#exit;
			for($j = 0; $j < count($getNetid); $j++)
			{
				if($getNetid[$j]['devid'] == "AC_ALLIAS" && $getNetid[$j]['attr'] == "UPWD"){
					echo "Username: ".$getNetid[$j]['value']."<br>";
					echo "Password: ".$getNetid[$j]['value1'];
					$params2 = array(new XML_RPC_Value($subsno, 'int'),
					new XML_RPC_Value($getNetid[$j]['attr'], 'string'),
					new XML_RPC_Value($getNetid[$j]['devid'], 'string'),
					new XML_RPC_Value($username, 'string'),
					new XML_RPC_Value($username, 'string')
					);
			                $msg2 = new XML_RPC_Message('unify.alterNetIDValues', $params2);
			                $cli2 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
			                $cli2->setCredentials('ftth_spectra','ftth_spectra');
			                $resp2 = $cli2->send($msg2);
					if (!$resp2)
					{
					    echo 'Communication error: ' . $cli1->errstr;
					}
			                if (!($resp2->faultCode()))
			                {
                        		$val2 = $resp2->value();
		                        $changeNetid = XML_RPC_decode($val2);
				        #print_r($changeNetid);
					echo "<br>";
					if($changeNetid == '0') echo "Username: $username and Password: $username successfully changed.";
					else echo "Username and Password not changed.";
					}
					
				}
			}
		}
		#echo "<hr>";
	  }//for loop
     }// If resp
}

?>
