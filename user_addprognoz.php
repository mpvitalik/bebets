<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

if($user->getId()>0){
    $data = array();
    $data['championat'] = isset($_POST['userprognoz_championat'])? htmlspecialchars($_POST['userprognoz_championat']) : "";
    $data['time'] = isset($_POST['userprognoz_time'])? htmlspecialchars($_POST['userprognoz_time']) : "";
    $data['komandi'] = isset($_POST['userprognoz_komandi'])? htmlspecialchars($_POST['userprognoz_komandi']) : "";
    $data['prognoz'] = isset($_POST['userprognoz_prognoz'])? htmlspecialchars($_POST['userprognoz_prognoz']) : "";
    $data['koef'] = isset($_POST['userprognoz_koef'])? htmlspecialchars($_POST['userprognoz_koef']) : "";
    $data['user_id'] = $user->getId();

    if(strlen($data['championat'])>0 && strlen($data['time'])>0 && strlen($data['komandi'])>0 && strlen($data['prognoz'])>0 && strlen($data['koef'])>0){
        $insert_data = $db->insertUserPrognoz($data);
        $insert_id = $insert_data['insert_id'];

        unset($insert_data['insert_id']);
        unset($insert_data['user_id']);

        $insert_data['name'] = $user->getLogin();
        $insert_data['error'] = "no";
        $json_ret = json_encode($insert_data,JSON_UNESCAPED_UNICODE);
        echo $json_ret;

    }else{
        $json_ret = json_encode(array('error'=>'yes','dd'=>'dd'),JSON_UNESCAPED_UNICODE);
        echo $json_ret;
    }
}else{
    $json_ret = json_encode(array('error'=>'yes'),JSON_UNESCAPED_UNICODE);
    echo $json_ret;
}

