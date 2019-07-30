<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "../php/Database.php";
$db = new Database();


if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = array();
    $data['nazva'] = $_POST['nazva'];
    $data['championatid'] = (int)$_POST['championatid'];

    $db->insertChampioncomanda($data);
    header("Location:changechampionat.php?id=".$data['championatid']);
    die();

}



?>