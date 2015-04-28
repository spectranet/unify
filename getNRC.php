<?php
require_once '/usr/share/pear/XML/RPC.php';

echo    $actid = "0000-0000-TEST-000031";
        $getClosed = true;
echo        $to_date = date("Ymd\TH:i:s");
echo        $from_date = date("Ymd\TH:i:s", strtotime("-6 months"));
        $get_nrc = getNRC($actid,$getClosed,$from_date,$to_date);
        print_r($get_nrc);

function getNRC($actid,$getClosed,$from_date,$to_date){
$params = array(new XML_RPC_Value($actid, 'string'),
        new XML_RPC_Value($getClosed, 'boolean'),
        new XML_RPC_Value($from_date, 'dateTime.iso8601'),
        new XML_RPC_Value($to_date, 'dateTime.iso8601'),
        );

$msg1 = new XML_RPC_Message('unify.getNRCsForAccount', $params);
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
$NRCsForAccount1 = XML_RPC_decode($val1);
echo "<hr><h1>getNRCsForAccount:</h1>";
print_r($NRCsForAccount1);
//return $NRCsForAccount1;
}

}


?>
