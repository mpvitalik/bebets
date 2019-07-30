<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
//$url = "https://terrikon.com/football/england/championship/matches";

$url = "https://terrikon.com/football/england/championship/";


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);


$output = curl_exec($ch);
curl_close($ch); 

var_dump($output);