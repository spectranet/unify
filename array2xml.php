<?php
class array2xml {
 var $output = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 function array2xml($array, $root = 'root', $element = 'element') { 
 $this->output .= $this->make($array, $root, $element);
 }
 function make($array, $root, $element) {
 $xml = "<{$root}>\n";
 foreach ($array as $key => $value) {
 if (is_array($value)) {
 $xml .= $this->make($value, $element, $key);
 } else {
 if (is_numeric($key)) {
 $xml .= "<{$root}>{$value}</{$root}>\n";
 } else {
 $xml .= "<{$key}>{$value}</{$key}>\n";
 }
 }
 }
 $xml .= "</{$root}>\n"; 
 return $xml;
 }
}
?>

