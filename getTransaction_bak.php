<?php
require_once '/usr/share/pear/XML/RPC.php';
function gettransaction($canid,$from_date,$to_date){
				/****************** Get Accout Detail **************/	
			        $params = array(new XML_RPC_Value($canid, 'string'));
		        	$msg = new XML_RPC_Message('unify.getAccountDetails', $params);
			        $cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', '203.122.58.66');
			        $cli->setCredentials('ftth_spectra','ftth_spectra');
			        $resp = $cli->send($msg);
				if (!$resp){
	                		echo $error = 'Communication error: ' . $cli->errstr;
					exit;
        			}
		        	if (!($resp->faultCode())){
		                	$val = $resp->value();
	        		        $data = XML_RPC_decode($val);
					#print_r($data);
					#echo "<hr>";
	        		}else {
			                echo $error = 'Fault Code: ' . $resp->faultCode() . "\n";
        	        		echo $error .= 'Fault Reason: ' . $resp->faultString() . "\n";
					exit;
        			}
				/****************** Get Transaction Detail **************/
				$paramss= array( 'limit' => new XML_RPC_Value('30'),
				                 'order' => new XML_RPC_Value('desc'),
				                 'fromDate' => new XML_RPC_Value($from_date),
						 'todate' => new XML_RPC_Value($to_date));
				$parm=array(new XML_RPC_Value($data['actno'], 'int'),
				            new XML_RPC_Value($paramss, 'struct'));
				$msg2 = new XML_RPC_Message('unify.getTransactions', $parm);
				$cli2 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
				$cli2->setCredentials('ftth_spectra','ftth_spectra');
				$resp2 = $cli2->send($msg2);
				 ####### Loging Start ####################

                                                $FINANCE_LOG1 = "\n######################################\n";
                                                $FINANCE_LOG1 .= "unify.getTransactions:\n" . $msg1->serialize ();
                                                $FINANCE_LOG1 .= "\n######################################\n";
                                                $FINANCE_LOG1 .= "unify.getTransactions:\n" . $resp1->serialize ();
                                                
                                 ################# Loging End ########################

				if (!$resp2)
				{
				   echo 'Communication error: ' . $cli2->errstr;
				}
				if (!($resp2->faultCode()))
				{
				$val2 = $resp2->value();
				$Transaction_detail = XML_RPC_decode($val2);
				return $Transaction_detail;
				}
}// End of Function

$res_date = "2014-12-12";
echo $from_date = date('Ymd\TH:i:s', strtotime($res_date));
echo "\n";
echo $to_date = date('Ymd\TH:i:s', strtotime("+2 months",strtotime($res_date)));
$canid="1871426";
$get_txn = gettransaction($canid,$from_date,$to_date);
print_r($get_txn);
echo "<hr>";
echo $FINANCE_LOG1;
?>
