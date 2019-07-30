<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "../php/Database.php";
$db = new Database();

$tag = isset($_POST['tag'])? htmlspecialchars($_POST['tag']) : false;

$tag_obj = $db->getTagByNazva($tag);

if($tag_obj->getId()>0){
    echo "yes";
}else{
    echo "no";
}
