<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "../php/Database.php";
$db = new Database();

$ssilka = isset($_POST['ssilka'])? htmlspecialchars($_POST['ssilka']) : false;
$type = isset($_POST['type'])? htmlspecialchars($_POST['type']) : false;


$exists_post = $db->isSsilkaExistPost($ssilka);

$exists_prognoz = $db->isSsilkaExistPrognoz($ssilka);

$exists_tag = $db->isSsilkaExistTag($ssilka);

$exist_championat = $db->isSsilkaExistChampionat($ssilka);
$exist_championat_vsetyri = $db->isSsilkaExistChampionat(str_replace('-vse-turi','',$ssilka));

if($exists_post || $exists_prognoz || $exists_tag || $exist_championat || $exist_championat_vsetyri){
    echo "no";
}else{
    echo "yes";
}
