<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "../php/Database.php";
$db = new Database();

$tag = isset($_POST['tag'])? htmlspecialchars($_POST['tag']) : false;

$tags = $db->getTagsByLikeTagname($tag);

$tags_str = "";
foreach($tags as $tag){
    $tags_str .= "<option value=\"".$tag->getNazva()."\">";
}

echo $tags_str;