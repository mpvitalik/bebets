<?php
session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}


require_once "../php/Database.php";
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : die("Error, go back");
$status = isset($_GET['status'])? $_GET['status'] : die("Error, go back");
$page = isset($_GET['p'])? intval($_GET['p']) : die("Error, go back");
$type = isset($_GET['type'])? $_GET['type'] : die("Error, go back");

$championatprognoz = $db->getChampionatprognozById($id);


$db->changeStatusChampionatPrognoz($id,$status);

header("Location:championat-prognozi.php?id_champ=".$championatprognoz->getIdChampionat()."&type=".$type."&p=".$page);
die();