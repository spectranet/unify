<?php
require_once '/usr/share/pear/XML/RPC.php';

							$amount_bill    = "0";
							$rcClassList[]  = new XML_RPC_Value("210=350");
							$rcAmountList[] = new XML_RPC_Value("210=$amount_bill");

			$params2 = array(new XML_RPC_Value("inventumtest", 'string'),#java.lang.String domid,
                                 			new XML_RPC_Value("SUNITtest5", 'string'),		#java.lang.String actid,
							#new XML_RPC_Value('SUNITtest2', 'string'),			#java.lang.String actid,
                                 			new XML_RPC_Value("Test account", 'string'),	#java.lang.String actname,
                                 			new XML_RPC_Value("123456", 'string'),				#java.lang.String password,
                                 			new XML_RPC_Value("New Delhi", 'string'),		#java.lang.String address,
                                 			new XML_RPC_Value("19", 'int'),			#int cityno,
                                 			new XML_RPC_Value('1', 'int'),					#java.lang.Integer countryno,
                                 			new XML_RPC_Value('110020', 'string'),		#java.lang.String pin,
                                 			new XML_RPC_Value('9899726915', 'string'),		#java.lang.String phone,
                                 			new XML_RPC_Value('9899726915', 'string'),		#java.lang.String fax,
                                 			new XML_RPC_Value('amit.dubey@spectranet.in', 'string'),		#java.lang.String email,
                                 			new XML_RPC_Value('http://www.spectranet.in', 'string'),	#java.lang.String web,
							new XML_RPC_Value('remarks', 'string'),				#java.lang.String remarks,
                                 			new XML_RPC_Value('caf_id', 'string'),			#java.lang.String externalid,
                                 			new XML_RPC_Value('9899726915', 'string'),		#java.lang.String mobileno,
                                 			new XML_RPC_Value('SUNIT', 'string'),		#java.lang.String fname,
                                 			new XML_RPC_Value('TEST5', 'string'),		#java.lang.String lname,
							new XML_RPC_Value(date('Ymd\TH:i:s'), 'dateTime.iso8601'), 		#java.util.Date billDate,
                                                 	new XML_RPC_Value('M', 'string'),				#java.lang.String billCyclePeriod,
                                                 	new XML_RPC_Value('1', 'int'),					#int billCycleDuration,
							new XML_RPC_Value('Enterprise-Citycom', 'string'),		#java.lang.String invoiceTemplate,
                                                 	new XML_RPC_Value('1', 'string'),				#java.lang.String receiptTemplate,
                                                 	new XML_RPC_Value('Enterprise Citycom profile', 'string'),	#java.lang.String billProfile,
                                                 	new XML_RPC_Value('BIA5', 'string'),		#java.lang.String pkgid,
                                                 	new XML_RPC_Value(date('Ymd\T00:00:00'), 'dateTime.iso8601'),	#java.util.Date startdt,
                                                 	new XML_RPC_Value('0', 'int'),					#java.lang.Integer sessioncount,
                                                 	new XML_RPC_Value('1', 'int'),					#java.lang.Integer authtype,
                                                 	new XML_RPC_Value('1', 'int'),					#java.lang.Integer ipbinding,
                                                 	new XML_RPC_Value('0', 'int'),					#java.lang.Integer macbinding
							new XML_RPC_Value($rcClassList, 'array'),	                #java.lang.String[] rcClassList,
                                 		 	new XML_RPC_Value($rcAmountList, 'array'),	                #java.lang.String[] rcAmountList,
							new XML_RPC_Value('inventumtest', 'string'), #java.lang.String pod,
							new XML_RPC_Value('1', 'string'),	                        #java.lang.String device
							new XML_RPC_Value('1', 'string'),	                        #java.lang.String portno
							new XML_RPC_Value('1', 'string'),	                        #java.lang.String lastmileno
							new XML_RPC_Value('1', 'string'),	                        #java.lang.String connectivitythroughlist
							new XML_RPC_Value('inventumtest', 'string'), #java.lang.String primarypodcode,
							new XML_RPC_Value('', 'string'), 				#java.lang.String secondarypodcode
							new XML_RPC_Value('', 'string'),	                        #java.lang.String raddeptcode,
							new XML_RPC_Value('BIA', 'string'),	#java.lang.String customertype,
							new XML_RPC_Value('Delhi', 'string'),	                        #java.lang.String revenuecity


							);		
						#print_r($params2);			
						$msg = new XML_RPC_Message('unify.saveNewPostPayAccountWithSubscription', $params2);
						$cli = new XML_RPC_Client('/unifyv3/xmlRPC.do', '203.122.58.66');
						$cli->setCredentials('ftth_spectra','ftth_spectra');
						$resp = $cli->send($msg);
						####################  Logging #############
						$BIA_LOG = "\n######################################\n";
						$BIA_LOG .= "unify.saveNewPostPayAccountWithSubscription:\n" . $msg->serialize ();
						$BIA_LOG .= "\n######################################\n";
						$BIA_LOG .= "unify.saveNewPostPayAccountWithSubscription Response:\n" . $resp->serialize ();
						echo $BIA_LOG;
if (!$resp)
{
    echo 'Communication error: ' . $cli->errstr;
}
if (!($resp->faultCode()))
{
$val1 = $resp->value();
$addp = XML_RPC_decode($val1);
echo "<hr><h1>ADD User:</h1>";
print_r($addp);
}

?>

