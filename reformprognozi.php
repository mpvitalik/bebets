<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();
$prognozi = $db->getAllPrognozi();
$i = 1;
foreach ($prognozi as $prognoz){
    $date_sort = DateTime::createFromFormat('Y.d.m H:i', $prognoz->getYear().".".$prognoz->getDate()." ".$prognoz->getTime());
    $date_string = $date_sort->format("Y-m-d H:i:s");
    $db->changeDateSortPrognoz($prognoz->getId(),$date_string);
    echo $i." - ".$date_string;
    echo "<br>";
    $i++;
}
?>