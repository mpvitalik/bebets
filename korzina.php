<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$type = isset($_GET['type'])? htmlspecialchars($_GET['type']) : die("Error");

switch ($type){
    case "buyonevip":
        $data['user_id'] = (int)$user->getId();
        $data['email'] = isset($_GET['email'])? htmlspecialchars($_GET['email']) : "";
        $data['type'] = "buyonevip";
        $data['details'] = isset($_GET['id'])? intval($_GET['id']) : die("Error");
        $data['summa'] = 1000;
        $id_zakaz = $db->zakazBuyOneItem($data);
        $db->insertPodpiska($data['email']);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=VIP-прогноз");
        break;

    case "buyoneexpress":
        $data['user_id'] = (int)$user->getId();
        $data['email'] = isset($_GET['email'])? htmlspecialchars($_GET['email']) : "";
        $data['type'] = "buyoneexpress";
        $data['details'] = 0;
        $data['summa'] = 5000;
        $id_zakaz = $db->zakazBuyOneItem($data);
        $db->insertPodpiska($data['email']);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=Экспресс");
        break;

    case "paket_one":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "paket_one";
        $data['summa'] = 2500;
        $id_zakaz = $db->zakazBuyPaket($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=ПАКЕТ №1");
        break;

    case "paket_two":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "paket_two";
        $data['summa'] = 7500;
        $id_zakaz = $db->zakazBuyPaket($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=ПАКЕТ №2");
        break;

    case "paket_three":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "paket_three";
        $data['summa'] = 12000;
        $id_zakaz = $db->zakazBuyPaket($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=ПАКЕТ №3");
        break;

    case "systema_one":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "systema_one";
        $data['details'] = 0;
        $data['summa'] = 5000;
        $id_zakaz = $db->zakazBuyOneItem($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=ПЕРЕКРЕСТНАЯ СИСТЕМА НА ФУТБОЛ");
        break;

    case "systema_two":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "systema_two";
        $data['details'] = 0;
        $data['summa'] = 7000;
        $id_zakaz = $db->zakazBuyOneItem($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=СИСТЕМА СТАВОК НА ВОЛЕЙБОЛ");
        break;

    case "systema_three":
        if($user->getId()==0){
            header("Location:register.php");
            die();
        }
        $data['user_id'] = (int)$user->getId();
        $data['email'] = $user->getEmail();
        $data['type'] = "systema_three";
        $data['details'] = 0;
        $data['summa'] = 10000;
        $id_zakaz = $db->zakazBuyOneItem($data);
        header("Location:https://sci.interkassa.com?ik_co_id=59f9bbcd3b1eaf8f0f8b4567&ik_pm_no=".$id_zakaz."&ik_am=".$data['summa']."&ik_cur=RUB&ik_desc=СИСТЕМА СТАВОК НА ГАНДБОЛ");
        break;

}