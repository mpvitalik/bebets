<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "expresstoday";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$express = $db->getExpresstById(1);

$active_paket = $db->getActivePaket($user->getId());
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ЖБ-экспресс на футбол на сегодняшние матчи - Bebets.ru</title>
    <meta name="description" content="Купить экспресс на футбол с гарантиями возврата денег в случае проигрыша вы можете в этом разделе. Экспресс на сегодня с коэффициентом в районе 3.00.">
    <meta property="og:image"   content="" />
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <?php if($express->getShow()=="yes"):?>
                <h1><?=$express->getNazva()?></h1>
                <p class="font12">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    Дата: <?php
                    $date_p = new DateTime();
                    echo $date_p->format("d.m.Y");
                    unset($date_p);
                    ?>
                </p>

                <?php if($express->getImg()!=""):?>
                    <img src="<?=$express->getImg()?>" class="img-responsive" />
                <?php endif;?>

                <div class="robotofamily">
                    <p><?=$express->getDescription()?></p>
                </div>

                <?php if(isset($active_paket) && $active_paket['name']!=false && 
                	($active_paket['name']=="paket_three" || $active_paket['name']=="paket_two")):?>
                    <div class="robotofamily">
                        <?=$express->getText()?>
                    </div>
                <?php else:?>
                    <div class="bgform col-md-8 col-md-offset-2" style="margin-bottom: 30px;">
                        <p class="fontbuy_in_form">Купить экспресс</p>
                        <form class="pdsideform">
                            <div class="form-group">
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                                       value="<?php if($user->getEmail()!="") echo $user->getEmail();?>" >
                            </div>
                            <input type="hidden" name="type" id="type" value="buyoneexpress">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="agreeemail">Я подтверждаю, что ввел e-mail правильно . Ознакомлен с <a href="oferta.php">офертой</a>
                                </label>
                            </div>
                            <button type="button" class="btnorange" id="submitemail">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;
                                Оплатить
                            </button>
                        </form><br>
                    </div>
                <?php endif;?>
            <?php else:?>
                <h1>Експресс еще не готов!</h1>
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