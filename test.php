<?php

$name = "amit dubey";
$pos = strpos($name,' ');
if($pos != ""){
$fname = substr($name,0,$pos);
$lname = substr($name,$pos+1);
}else{
$fname = $name;
$lname = "";
}
echo $fname." ".$lname;
?>
