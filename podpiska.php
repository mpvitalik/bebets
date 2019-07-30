<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "podpiska";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$active_paket = $db->getActivePaket($user->getId());
$otherpage = $db->getOtherPageById(2);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Купить подписку - платные прогнозы на футбол - Bebets.ru</title>
    <meta name="description" content="Выберите и купите подписку на прогнозы футбольных матчей в удобном для вас формате и оставайтесь “в плюсе” вместе с нами.">

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
                        <div class="name-paket">Пакет №1</div>
                        <div class="description-paket"><span class="lightblue">VIP-прогнозы</span><br> на 2 недели</div>
                        <div class="price-paket">2500р</div>
                        <?php if(isset($active_paket) && $active_paket['name']!=false && ($active_paket['name']=="paket_one" || $active_paket['name']=="paket_two" || $active_paket['name']=="paket_three")):?>
                            <form class="centered">
                                <button type="button" class="oformit-podpisku"><i class="fa fa-check green" aria-hidden="true"></i>Подписка<br> оформлена</button>
                            </form>
                        <?php else:?>
                            <form method="get" action="korzina.php" class="centered">
                                <input type="hidden" name="type" value="paket_one">
                                <button type="submit" class="oformit-podpisku">Оформить<br> подписку</button>
                            </form>
                        <?php endif;?>
                    </div>
                </div>
                <div class="paket2">
                    <div class="paket-inside">
                        <div class="name-paket">Пакет №2</div>
                        <div class="description-paket">
                            <span class="lightblue">VIP-прогнозы+</span><br><span class="green">экспрессы</span><br> на 2 недели
                        </div>
                        <div class="price-paket">7500р</div>
                        <?php if(isset($active_paket) && $active_paket['name']!=false && ($active_paket['name']=="paket_two" || $active_paket['name']=="paket_three")):?>
                            <form class="centered">
                                <button type="button" class="oformit-podpisku"><i class="fa fa-check green" aria-hidden="true"></i>Подписка<br> оформлена</button>
                            </form>
                        <?php else:?>
                            <form method="get" action="korzina.php" class="centered">
                                <input type="hidden" name="type" value="paket_two">
                                <button type="submit" class="oformit-podpisku">Оформить<br> подписку</button>
                            </form>
                        <?php endif;?>
                    </div>
                </div>
                <div class="paket3">
                    <div class="paket-inside">
                        <div class="name-paket">Пакет №3</div>
                        <div class="description-paket">Месяц<br> бесплатных<br> <span class="lightblue">VIP-прогнозов+</span><br> <span class="green">экспрессы</span></div>
                        <div class="price-paket">12 000р</div>
                        <?php if(isset($active_paket) && $active_paket['name']!=false && $active_paket['name']=="paket_three"):?>
                            <form class="centered">
                                <button type="button" class="oformit-podpisku"><i class="fa fa-check green" aria-hidden="true"></i>Подписка<br> оформлена</button>
                            </form>
                        <?php else:?>
                            <form method="get" action="korzina.php" class="centered">
                                <input type="hidden" name="type" value="paket_three">
                                <button type="submit" class="oformit-podpisku">Оформить<br> подписку</button>
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <h1>Подписка</h1>
            <div class="robotofamily">
                <?=$otherpage->getText();?>
                <div>
                    <?php if(isset($active_paket) && $active_paket['name']!=false && ($active_paket['name']=="paket_one" || $active_paket['name']=="paket_two" || $active_paket['name']=="paket_three")):?>
                        <a class="btngetgrognoztable"><i class="fa fa-check green" aria-hidden="true"></i> Пакет №1 - Подписка оформлена</a>
                    <?php else:?>
                        <a class="btngetgrognoztable" href="korzina.php?type=paket_one">Пакет №1 - оформить подписку</a>
                    <?php endif;?>

                </div>
                <br>
                <?=$otherpage->getText2();?>
                <div>
                    <?php if(isset($active_paket) && $active_paket['name']!=false && ($active_paket['name']=="paket_two" || $active_paket['name']=="paket_three")):?>
                        <a class="btngetgrognoztable"><i class="fa fa-check green" aria-hidden="true"></i> Пакет №2 - Подписка оформлена</a>
                    <?php else:?>
                        <a class="btngetgrognoztable" href="korzina.php?type=paket_two">Пакет №2 - оформить подписку</a>
                    <?php endif;?>
                </div>
                <br>
                <?=$otherpage->getText3();?>
                <div>
                    <?php if(isset($active_paket) && $active_paket['name']!=false && $active_paket['name']=="paket_three"):?>
                        <a class="btngetgrognoztable"><i class="fa fa-check green" aria-hidden="true"></i> Пакет №3 - Подписка оформлена</a>
                    <?php else:?>
                        <a class="btngetgrognoztable" href="korzina.php?type=paket_three">Пакет №3 - оформить подписку</a>
                    <?php endif;?>
                </div>
                <br>
                <div class="rightalignpodpiska">
                    <img src="images/garantia.png" class="garantiaimg">
                </div>
                <div>&nbsp;</div>

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