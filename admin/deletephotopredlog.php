<?php
session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}


require_once "../php/Database.php";
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : intval($_POST['id']);
$db->deletePhotoPredlogPost($id);

header("Location:predlogpost.php?id=".$id);
die();