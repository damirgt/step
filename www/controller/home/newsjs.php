<?php
header('Content-Type: application/x-javascript; charset: utf-8');
$n = array("Время" => date("h"), "Минут" => date("i"), "Секунд" => date("s"));
//$n = array("" => date("h").":".date("i").":".date("s"));

echo "Привет";

print_r($n);                          
/*echo json_encode($n); */
?>						