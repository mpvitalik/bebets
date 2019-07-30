<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);
if($user->getId()>0){
    header("Location:index.php");
    die();
}

$id_user = isset($_GET['id_user'])? intval($_GET['id_user']) : 0;
if($id_user!=0){
    $user = $db->getUserById($id_user);
    $email = $user->getEmail();
    $kodpodtverzdenia = $user->getKodpodtverzdenia();
    if($user->getId()!=0){
        mail($email, 'Bebets.ru - Подтверждение email', "Для подтверждения email-адреса перейдите по ссылке: <a href='http://bebets.ru/podtverditemail.php?id_user=".$id_user."&kod=".$kodpodtverzdenia."'>Подтвердить</a>",'Content-Type: text/html; charset=UTF-8');
    }
}
header("Location:podtverditemail.php");