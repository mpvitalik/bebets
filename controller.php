<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "news";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$ssilka = isset($_GET['ssilka'])? htmlspecialchars($_GET['ssilka']) : false;
$post = $db->getPostBySsilka($ssilka);
$prognoz = $db->getPrognozBySsilka($ssilka);
$tag = $db->getTagBySsilka($ssilka);
$championat = $db->getChampionatBySsilka($ssilka);
$championatvseturi = $db->getChampionatBySsilka(str_replace("-vse-turi","",$ssilka));


if($post->getId()>0){
    require_once "new.php";
}elseif($prognoz->getId()>0){
    require_once "prognoz.php";
}elseif($tag->getId()>0){
    require_once "tags.php";
}elseif($championat->getId()>0){
    require_once "championat.php";
}elseif($championatvseturi->getId()>0){
    require_once "championatturi.php";
}else{
    header("Location:error-page.php");
}