<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$prognozid = isset($_POST['prognozid'])? intval($_POST['prognozid']) : 0;
$comment_sort = isset($_POST['commentssort'])? htmlspecialchars($_POST['commentssort']) : "";
$razvernut_all_comments = isset($_POST['razvernut_all_comments'])? htmlspecialchars($_POST['razvernut_all_comments']) : "no";
$json_razvernut_subcoments = isset($_POST['json_razvernut_subcoments'])? $_POST['json_razvernut_subcoments'] : "[]";
$json_added_comments = isset($_POST['json_added_comments'])? $_POST['json_added_comments'] : "[]";

$razvernutie_subcoments = json_decode($json_razvernut_subcoments,true);
$added_comments = json_decode($json_added_comments,true);



if($comment_sort=="popular"){
    $comments = $db->getPrognozCommentsSortPopular($prognozid);
}else{
    $comments = $db->getPrognozComments($prognozid);
}

$text = "";
$comment_increment = 1;
foreach($comments as $comment){
    $hidecomment = "";
    if($comment_increment>10 && $razvernut_all_comments=="no"){
        $hidecomment = "hidecomment";
    }
    $text .= "<div class=\"$hidecomment\">";
    $text .= "<div class=\"comment\" id=\"".$comment['comment']->getId()."\">";
    $text .= "<p><span class=\"comment-login\">".$comment['comment']->getLogin().":</span> ".$comment['comment']->getText()."</p>";
    $text .= "</div>";
    $text .= "<p class=\"rightalign\" id=\"otvetp".$comment['comment']->getId()."\">";
    $text .= "<span class=\"date_comment\">".$comment['comment']->getDatee()."</span> ";
    $text .= "";

    if($user->getId()>0){
        $text .= "<a class=\"comment_otvetit\" id-comment=\"".$comment['comment']->getId()."\"><small>Ответить</small></a>&nbsp; ";
    }else{
        $text .= "<a class=\"comment_otvetit_notreg\"><small>Ответить</small></a>&nbsp; ";
    }

    $text .= "<a class=\"click_like\" data-type=\"like\" id-comment=\"".$comment['comment']->getId()."\"> ";
    $text .= "<i class=\"fa fa-thumbs-up grey\" aria-hidden=\"true\"></i> ";
    $text .= "<span class=\"colorgreen likecount\" id-comment=\"".$comment['comment']->getId()."\"> ".count($comment['likes'])."</span>&nbsp; ";
    $text .= "</a>";
    $text .= "<a class=\"click_like\" data-type=\"dislike\" id-comment=\"".$comment['comment']->getId()."\"> ";
    $text .= "<i class=\"fa fa-thumbs-down grey\" aria-hidden=\"true\"></i> ";
    $text .= "<span class=\"colorred dislikecount\" id-comment=\"".$comment['comment']->getId()."\"> ".count($comment['dislikes'])."</span> ";
    $text .= "</a></p>";
    $text .= "<div class=\"subcoments_list\" id-comment=\"".$comment['comment']->getId()."\">";

    $subcomment_increment = 1;
    $count_added_comments = checkCountAddedComent($comment['comment_childs'],$added_comments);

    foreach($comment['comment_childs'] as $comment_child){
        $hidesubcomment = "";
        if($subcomment_increment>2 && !in_array($comment['comment']->getId(),$razvernutie_subcoments) && !in_array($comment_child['comment']->getId(),$added_comments)){
            $hidesubcomment = "hidesubcomment";
        }

        $text .= "<div class=\"".$hidesubcomment."\" id-comment=\"".$comment['comment']->getId()."\">";
        $text .= "<div class=\"subcomment\">";
        if($comment_child['comment']->getLoginReplycomment()!="" && $comment_child['comment']->getTextReplycomment()!=""){
            $text .= "<span class=\"written_comment\">".$comment_child['comment']->getLoginReplycomment().": ".$comment_child['comment']->getTextReplycomment()."</span>";
        }
        $text .= "<p><span class=\"comment-login\">";
        $text .= "<i class=\"fa fa-reply\" aria-hidden=\"true\"></i> ".$comment_child['comment']->getLogin().":</span> ".$comment_child['comment']->getText();
        $text .= "</p></div>";
        $text .= "<p class=\"rightalign\" id=\"otvetp".$comment_child['comment']->getId()."\">";
        $text .= "<span class=\"date_comment\">".$comment_child['comment']->getDatee()."</span> ";

        if($user->getId()>0){
            $text .= "<a class=\"subcomment_otvetit\" id-comment=\"".$comment['comment']->getId()."\" id-subcomment=\"".$comment_child['comment']->getId()."\"><small>Ответить</small></a>&nbsp; ";
        }else{
            $text .= "<a class=\"comment_otvetit_notreg\"><small>Ответить</small></a>&nbsp; ";
        }


        $text .= "<a class=\"click_like\" data-type=\"like\" id-comment=\"".$comment_child['comment']->getId()."\">";
        $text .= "<i class=\"fa fa-thumbs-up grey\" aria-hidden=\"true\"></i> ";
        $text .= "<span class=\"colorgreen likecount\" id-comment=\"".$comment_child['comment']->getId()."\"> ".count($comment_child['likes'])."</span>&nbsp; ";
        $text .= "</a>";
        $text .= "<a class=\"click_like\" data-type=\"dislike\" id-comment=\"".$comment_child['comment']->getId()."\">";
        $text .= "<i class=\"fa fa-thumbs-down grey\" aria-hidden=\"true\"></i> ";
        $text .= "<span class=\"colorred dislikecount\" id-comment=\"".$comment_child['comment']->getId()."\"> ".count($comment_child['dislikes'])."</span> ";
        $text .= "</a></p></div>";


        if ($subcomment_increment > 2 && $subcomment_increment == count($comment['comment_childs'])-$count_added_comments && !in_array($comment['comment']->getId(), $razvernutie_subcoments)) {
            $text .= "<div class=\"razvernytsub_div\" style=\"font-family:'Roboto',sans-serif;\"><a class=\"razvernut_subcoments\" id-comment=\"" . $comment['comment']->getId() . "\"><small>Развернуть комментарии</small></a></div>";
        }


        $subcomment_increment++;

    }


    $text .= "</div></div>";

    if($comment_increment>10 && $comment_increment==count($comments) && $razvernut_all_comments=="no"){
        $text .= "<div class=\"razvernytcoment_div\" style=\"font-family:'Roboto',sans-serif;\">";
        $text .= "<a class=\"razvernut_all_comment\"><small>Развернуть остальные комментарии</small></a>";
        $text .= "</div>";
    }

    $comment_increment++;
}

echo $text;


function checkCountAddedComent($arr_comments,$arr_added_comments){
    $count_comments = 0;
    foreach ($arr_comments as $com){
        if(in_array($com['comment']->getId(),$arr_added_comments)){
            $count_comments++;
        }
    }
    return $count_comments;
}

