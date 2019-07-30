<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$data = array();
$data['id_prognoz'] = isset($_POST['idprognoz'])? intval($_POST['idprognoz']) : 0;
$data['comment'] = isset($_POST['comment'])? htmlspecialchars($_POST['comment']) : "";
$data['id_user'] = $user->getId();

$db->makeCommentPrognozCookie($data);