<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

if(!isset($_SESSION['zakladki'])){
    $_SESSION['zakladki'] = "shown";
}