<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$id = isset($_POST['id'])? intval($_POST['id']) : die("Error, go back");
$action = isset($_POST['action'])? htmlspecialchars($_POST['action']) : die("Error, go back");
$user = $db->getUserById($id);
if($user->getId()==0){
    die("Error");
}
$data = array();
$data['user_id'] = $user->getId();
$data['email'] = $user->getEmail();
$data['details'] = 0;
$data['summa'] = 0;

switch ($action){
    case "paket1":
        $data['type'] = "paket_one";
        $db->zakazBuyOneItemAdmin($data);
        break;
    case "paket2":
        $data['type'] = "paket_two";
        $db->zakazBuyOneItemAdmin($data);
        break;
    case "paket3":
        $data['type'] = "paket_three";
        $db->zakazBuyOneItemAdmin($data);
        break;
    case "obnulit":
        $db->obnulitPaketAdmin($data['user_id']);
        break;
    case "deleteuser":
        $db->deleteUserById($data['user_id']);
        break;
}

echo "ok";
