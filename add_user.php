<?php
require_once '/usr/share/pear/XML/RPC.php';

$domid="PUNE-WAKA-ELMWOODS";
$actid="139695";
$name="Abhinav Gupta";
$password="PA_88288";
$address="B ,403 ,4 ,ELMWOODS C&D WING ,Near Govind Garden ,Wakad ,Pimple Saudagar , ,Maharashtra ,Pune ,411027";
$mobile="";
$email="abhinavgupta03@gmail.com";
$web = "http://www.spectranet.in";

$params = array(new XML_RPC_Value($domid, 'string'),    # domid
                new XML_RPC_Value($actid, 'string'),       # actid
                new XML_RPC_Value($name, 'string'),             # actname
                new XML_RPC_Value($password, 'string'),                  # password
                new XML_RPC_Value($address, 'string'),   # address
                new XML_RPC_Value('55', 'int'),         # cityno
                new XML_RPC_Value('1', 'int'),        # countryno
                new XML_RPC_Value('411027', 'string'),                  # pin
                new XML_RPC_Value($mobile, 'string'), # phone
                new XML_RPC_Value($mobile, 'string'),     # fax
                new XML_RPC_Value($email, 'string'),  # email
                new XML_RPC_Value($web, 'string'),           # web
                new XML_RPC_Value(2, 'int'),                            # actcat
                new XML_RPC_Value('remark done', 'string'),                 # remarks
                new XML_RPC_Value('1425', 'string'),                        # externalid
                new XML_RPC_Value('9158086308','string'),     # mobileno
                new XML_RPC_Value('Abhinav','string'),      # First Name
                new XML_RPC_Value('Gupta','string')      # Last Name
             );
#print_r($params);

$msg1 = new XML_RPC_Message('unify.saveNewAccount', $params);
$cli1 = new XML_RPC_Client('/unifyv3/xmlRPC.do', 'http://203.122.58.66');
$cli1->setCredentials('ftth_spectra','ftth_spectra');
$resp1 = $cli1->send($msg1);

####################  Logging #############
 $FTTH_LOG = "\n######################################\n<br>";
 $FTTH_LOG .= "unify. request param:\n" . $msg1->serialize ()."<br>";
 $FTTH_LOG .= "\n######################################\n<br>";
 $FTTH_LOG .= "unify. response:\n" . $resp1->serialize ()."<br>";
 echo $FTTH_LOG;


        if (!$resp1)
        {
            echo $result = 'Communication error: ' . $cli1->errstr;
            exit;
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


?>
