<?php


session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : die("Error, go back");
$type = isset($_GET['type'])? $_GET['type'] : die("Error, go back!");


$prognoz = $db->getPrognozById($id);

$db->deletePrognoz($id);

if($prognoz->getIdChampionat()>0){
    header("Location:championat-prognozi.php?type=".$type."&id_champ=".$prognoz->getIdChampionat());
}else{
    header("Location:prognozi.php?type=".$type);
}
