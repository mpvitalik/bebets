<?php


session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$post_id = isset($_GET['post_id'])? intval($_GET['post_id']) : die("Error, go back");
$comment_id = isset($_GET['comment_id'])? intval($_GET['comment_id']) : die("Error, go back");

$db->deleteComment($comment_id);
header("Location:comments.php?id=$post_id");