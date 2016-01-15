<?php
//header("Access-Control-Allow-Origin: http://192.168.0.150:8080");
header('Access-Control-Allow-Origin:*');
$a = array(1,2,3);
echo 'jsonp = '.json_encode($a);
