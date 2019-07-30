<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "systema";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$active_paket = $db->getActivePaket($user->getId());
$otherpage = $db->getOtherPageById(1);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404 страницы не существует - Bebets.ru</title>
    <meta name="description" content="404 страницы не существует - Bebets.ru">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <h2>404 - страницы не существует</h2>
            <a href="/">На Главную</a>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
</body>
</html>