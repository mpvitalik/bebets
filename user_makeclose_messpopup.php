<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$data = array();
$id_page = isset($_POST['idpage'])? intval($_POST['idpage']) : 0;
$typepage = isset($_POST['typepage'])? htmlspecialchars($_POST['typepage']) : "";
$id_user = $user->getId();

if($user->getId()!=0 && $id_page!=0 && $typepage!=""){
    if($typepage=="post"){
        $db->makereadUserPostComments($id_page,$id_user);
    }elseif($typepage=="prognoz"){
        $db->makereadUserPrognozComments($id_page,$id_user);
    }

}

