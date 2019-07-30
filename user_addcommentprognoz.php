<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$retval = array('saved'=>'no');
if($user->getId()>0){
    $data = array();
    $data['comment'] = isset($_POST['comment'])? htmlspecialchars($_POST['comment']) : "";
    $data['id_prognoz'] = isset($_POST['prognozid'])? intval($_POST['prognozid']) : 0;
    $data['id_user'] = $user->getId();

    if(strlen($data['comment'])>0){
        $insert_id = $db->insertUserPrognozcomment($data);
        $comment = $db->getPrognozCommentById($insert_id);
        if($comment->getId()>0){
            $retval['saved']='yes';
            $retval['idcomment'] = $comment->getId();
            $retval['text'] = $comment->getText();
            $retval['username'] = $user->getLogin();
            $retval['datee'] = $comment->getDatee();
        }
    }
}

echo json_encode($retval,JSON_UNESCAPED_UNICODE);