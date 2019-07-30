<?php


session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : die("Error, go back");


$db->deleteUserPrognoz($id);
header("Location:chat.php");