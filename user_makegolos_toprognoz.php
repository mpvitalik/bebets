<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$data = array();
$data['id_prognoz'] = isset($_POST['idprognoz'])? intval($_POST['idprognoz']) : 0;
$data['prohod'] = isset($_POST['prohod'])? htmlspecialchars($_POST['prohod']) : "";
$data['comment'] = isset($_POST['goloscomment'])? htmlspecialchars($_POST['goloscomment']) : "";
$data['id_user'] = $user->getId();

$retval = "";
if($user->getId()>0){
    $db->insertPrognozgolos($data);
    if($data['comment']!="" && $data['comment']!=" " && $data['comment']!="  "){
        $db->insertUserPrognozcomment($data);
    }
    $retval = "inserted";
}else{
    $db->makeGolosCookie($data);
    $retval = "not-registered";
}

echo $retval;