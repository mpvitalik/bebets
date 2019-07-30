<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

require_once "php/Database.php";
$db = new Database();

$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);


if($user->getId()!=0){
    $prognozi = $db->getUnreadUserPrognoziComments($user->getId());
    $posts = $db->getUnreadUserPostComments($user->getId());

    $obshiy_arr = array_merge($prognozi, $posts);
    uasort($obshiy_arr,"mySortPrognoziAndPosts");
    $new_obshiy_arr = array_slice($obshiy_arr,0,3);

    $text = "";

    foreach ($new_obshiy_arr as $arr_item){
        $nazva_ssilka = $arr_item->getNazva();
        if(mb_strlen($arr_item->getNazva(), 'utf-8')>28){
            $nazva_ssilka = mb_substr($nazva_ssilka, 0, 27,'utf-8');
            $nazva_ssilka .= "..";
        }
        $text .= "<div class=\"message_popup\" page=\"".$arr_item->getClassType().$arr_item->getId()."\">";
        $text .= "<img src=\"images/closeicon.png\" class=\"close_new_message_popup\" type-page=\"".$arr_item->getClassType()."\" id-page=\"".$arr_item->getId()."\">";
        $text .= "<p class=\"mess_popup_header\">У вас новый ответ:</p>";
        $text .= "<p><a href=\"".$arr_item->getSsilka().".html\">".$nazva_ssilka."</a></p>";
        $text .= "</div>";
    }

    echo $text;

}


function mySortPrognoziAndPosts($f1,$f2)
{
    $date_f1 = DateTime::createFromFormat('Y-m-d H:i:s', $f1->getDateSort());
    $date_f2 = DateTime::createFromFormat('Y-m-d H:i:s', $f2->getDateSort());

    if($date_f1 > $date_f2) return -1;
    elseif($date_f1 < $date_f2) return 1;
    else return 0;
}
