<?php

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);
if($user->getId()==0){
    header("Location:index.php");
    die();
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$dd = $db->deleteCookieFromDb($user_session,$user_agent,$user->getId());
$db->unsetUserCookie();
header("Location:index.php");