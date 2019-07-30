<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$data = array();
$data['idcomment'] = isset($_POST['idcomment'])? intval($_POST['idcomment']) : 0;
$data['datatype'] = isset($_POST['datatype'])? htmlspecialchars($_POST['datatype']) : "";
$data['id_user'] = $user->getId();

if($user->getId()>0){
    $user_likedislike_this_comment_early = $db->getPrognozCommentUserLikeDislike($data['id_user'],$data['idcomment']);
    if($user_likedislike_this_comment_early->getId()!=0){
        if($data['datatype']=="like" || $data['datatype']=="dislike"){
            $db->updatePrognozCommentLikeDislike($data['id_user'],$data['idcomment'],$data['datatype']);
        }
    }else{
        if($data['datatype']=="like" || $data['datatype']=="dislike"){
            $db->insertPrognozCommentLikeDislike($data['id_user'],$data['idcomment'],$data['datatype']);
        }
    }
}

$comment_likesdislikes = $db->getCommentLikesDislikes($data['idcomment']);
$likes_dislikes = array(
    "likes"=>count($comment_likesdislikes['likes']),
    "dislikes"=>count($comment_likesdislikes['dislikes'])
);

$json_arr = json_encode($likes_dislikes,JSON_UNESCAPED_UNICODE);
echo $json_arr;
