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
    <title>Системы и стратегии игры в букмекерских конторах - Bebets.ru</title>
    <meta name="description" content="С помощью систем игры в букмекерских конторах разработанных нашими экспертами вы сможете не только узнать как обыграть букмекеров, но и сделать это.">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <div>
                <div class="paket1">
                    <div class="paket-inside">
                        <div class="name-paket">Система №1</div>
                        <div class="description-paket">Перекрестная система<br> на футбол</div>
                        <div class="price-paket">5000р</div>
                        <form method="get" action="korzina.php" class="centered">
                            <input type="hidden" name="type" value="systema_one">
                            <button href="#" class="oformit-podpisku">Купить<br> систему</button>
                        </form>
                    </div>
                </div>
                <div class="paket2">
                    <div class="paket-inside">
                        <div class="name-paket">Система №2</div>
                        <div class="description-paket">Система ставок<br> на волейбол</div>
                        <div class="price-paket">7000р</div>
                        <form method="get" action="korzina.php" class="centered">
                            <input type="hidden" name="type" value="systema_two">
                            <button href="#" class="oformit-podpisku">Купить<br> систему</button>
                        </form>
                    </div>
                </div>
                <div class="paket3">
                    <div class="paket-inside">
                        <div class="name-paket">Система №3</div>
                        <div class="description-paket">Система ставок<br> на гандбол</div>
                        <div class="price-paket">10 000р</div>
                        <form method="get" action="korzina.php" class="centered">
                            <input type="hidden" name="type" value="systema_three">
                            <button href="#" class="oformit-podpisku">Купить<br> систему</button>
                        </form>
                    </div>
                </div>
            </div>
            <h1>Системы игры </h1>
            <div class="robotofamily">
                <?=$otherpage->getText();?>
            </div>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
</body>
</html>