<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_GET['id'])? intval($_GET['id']) : die('Error, go back');
$action = isset($_GET['action'])? htmlspecialchars($_GET['action']) : die('Error, go back');


switch ($action){
    case "delete":
        $db->deleteMainPost($id);
        break;

    case "update":
        $num = isset($_GET['num'])? intval($_GET['num']) : die('Error, go back');
        if($num==1){
            $db->makeMainPost($id);
        }elseif($num==2){
            $db->makeMainPostSecond($id);
        }
        break;
}

/*switch ($num){
    case 1:
        if($action=="delete"){
            $db->deleteMainPost();
        }elseif ($action=="update"){
            $db->makeMainPost($id);
        }
        break;

    case 2:
        if($action=="delete"){
            $db->deleteMainPostSecond();
        }elseif ($action=="update"){
            $db->makeMainPostSecond($id);
        }
        break;
}*/


header("Location:mainposts.php");


