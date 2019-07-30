<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : die('Error, go back');
$action = isset($_GET['action'])? htmlspecialchars($_GET['action']) : die('Error, go back');

if($action=="yes"){
    $db->changeExpressStatus($id,"yes");
}elseif ($action=="no"){
    $db->changeExpressStatus($id,"no");
}

header("Location:express.php");


