<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$type_response = isset($_GET['type_response'])? htmlspecialchars($_GET['type_response']) : "";
$ik_pm_no = isset($_GET['ik_pm_no'])? intval($_GET['ik_pm_no']) : false;

if($ik_pm_no!=false){
    $zakaz = $db->getZakazById($ik_pm_no);
}


$active_paket = $db->getActivePaket($user->getId());

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
        <?php if(isset($type_response) && $type_response=="success"):?>
            Оплата прошла успено!
        <?php else:?>
            Оплата не осуществлена!
        <?php endif;?>
    </title>
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <?php if(isset($type_response) && $type_response=="success"):?>
                <h1>Ваша оплата прошла успешно!</h1>
                <?php if(isset($zakaz) && $zakaz->getType()=="buyonevip"):?>
                    <h2>VIP прогноз отправлен на Ваш e-mail</h2>
                <?php elseif(isset($zakaz) && $zakaz->getType()=="buyoneexpress"):?>
                    <h2>Экспресс отправлен на Ваш e-mail</h2>
                <?php elseif(isset($zakaz) && ($zakaz->getType()=="systema_one" || $zakaz->getType()=="systema_two" || $zakaz->getType()=="systema_three")):?>
                    <h2>Система отправлена на Ваш email</h2>
                <?php endif;?>
            <?php elseif (isset($type_response) && $type_response=="fail"):?>
                <h1>Ваша оплата была неуспешной! Попробуйте еще раз.</h1>
            <?php else:?>
                <h1>Оплата не осуществлена!</h1>
            <?php endif;?>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
</body>
</html>