<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_POST['id'])? intval($_POST['id']) : die("Error, go back");
$type = isset($_POST['type'])? $_POST['type'] : die("Error, go back");


$showing = "error";
if($type=="championatprognoz"){
    $showing = $db->changeChampionatPrognozShowingmain($id);
}
echo $showing;