<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$data = array();
$data['idcomment'] = isset($_POST['idcomment'])? intval($_POST['idcomment']) : 0;
$data['idsubcomment'] = isset($_POST['idsubcomment'])? intval($_POST['idsubcomment']) : 0;
$data['replycomment'] = isset($_POST['replycomment'])? htmlspecialchars($_POST['replycomment']) : "";
$data['id_user'] = $user->getId();

$comment = $db->getPrognozCommentById($data['idcomment']);
$user_comment = $db->getUserById($comment->getIdUser());
$subcomment = $db->getPrognozCommentById($data['idsubcomment']);
$user_subcomment = $db->getUserById($subcomment->getIdUser());

$retval = array('saved'=>'no');
if($user->getId()>0){
    if($comment->getId()!=0 && strlen($data['replycomment'])!=0 && $subcomment->getId()==0){
        $comment_id = $db->insertReplyComment($data['id_user'],$comment->getIdPrognoz(),$data['idcomment'],$comment->getIdUser(),$data['replycomment'],$user_comment->getLogin(),$comment->getText());
        $replycomment = $db->getPrognozCommentById($comment_id);
        if($replycomment->getId()!=0){
            $retval['saved'] = 'yes';
            $retval['idreplycomment'] = $replycomment->getId();
            $retval['replycomment'] = $replycomment->getText();
            $retval['username'] = $user->getLogin();
            $retval['datee'] = $replycomment->getDatee();
            $retval['login_replycomment'] = $replycomment->getLoginReplycomment();
            $retval['text_replycomment'] = $replycomment->getTextReplycomment();
        }
    }elseif($comment->getId()!=0 && strlen($data['replycomment'])!=0 && $subcomment->getId()>0){
        $comment_id = $db->insertReplyComment($data['id_user'],$comment->getIdPrognoz(),$data['idcomment'],$subcomment->getIdUser(),$data['replycomment'],$user_subcomment->getLogin(),$subcomment->getText());
        $replycomment = $db->getPrognozCommentById($comment_id);
        if($replycomment->getId()!=0){
            $retval['saved'] = 'yes';
            $retval['idreplycomment'] = $replycomment->getId();
            $retval['replycomment'] = $replycomment->getText();
            $retval['username'] = $user->getLogin();
            $retval['datee'] = $replycomment->getDatee();
            $retval['login_replycomment'] = $replycomment->getLoginReplycomment();
            $retval['text_replycomment'] = $replycomment->getTextReplycomment();
        }
    }
}

$json_retval = json_encode($retval,JSON_UNESCAPED_UNICODE);
echo $json_retval;
