<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "index";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$mainpost = $db->getMainPost();
$mainpost_second = $db->getMainPostSecond();

$express = $db->getExpresstById(1);
$freeprognozi = $db->getPrognoziIndex();

$active_paket = $db->getActivePaket($user->getId());



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Купить платные прогнозы на футбол у капперов на сегодня - Bebets.ru</title>
    <meta name="description" content="Группа профессиональных капперов разрабатывает и продает прогнозы на футбол с гарантией в различных вариациях - как ординарами, так и экспрессами.">
    <meta name="yandex-verification" content="498563e2e1c99c4f" />

	<?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>

	<div class="row">
        <div class="col-md-9 pdrightcomp-no">
            <?php if($mainpost->getId()>0):?>
                <div class="mainnew" style="background-image:url('<?=$mainpost->getImg()?>');" data-href="<?=$mainpost->getSsilka()?>.html">
                    <div class="mainnew-text">
                        <p><a href="<?=$mainpost->getSsilka()?>.html">
	                        	<?=$mainpost->getNazva()?>
                        	</a>
                        </p>
                        <a href="news.php" class="maintnew-allnews">Все новости</a>
                    </div>
                </div>
            <?php endif;?>
            <?php if($express->getShow()=="yes"):?>
                <div class="mainnew" style="background-image:url('<?=$express->getImg()?>');" data-href="express-today.php">
                    <div class="mainnew-text">
                        <a href="express-today.php" class="hoverwhite">
                            <p>
	                        	<?=$express->getNazva()?>
                            </p>
                        </a>
                    </div>
                </div>
            <?php else:?>
                <div class="mainnew" style="background-image:url('<?=$mainpost_second->getImg()?>');" data-href="<?=$mainpost_second->getSsilka()?>.html">
                    <div class="mainnew-text">
                        <p><a href="<?=$mainpost_second->getSsilka()?>.html">
	                        	<?=$mainpost_second->getNazva()?>
                        	</a>
                        </p>
                        <a href="news.php" class="maintnew-allnews">Все новости</a>
                    </div>
                </div>
            <?php endif;?>

            <?php if(isset($is_mobile) && $is_mobile==true):?> <!--MOBILE ver-->

	            <div class="bgfreeprognozi mttop10">

					<div class="mobfreeprognozhead">
						<div class="row">
							<div class="col-xs-9 pdleft20">
								Событие
							</div>
							<div class="col-xs-3 centered" >
								Коеф.
							</div>
						</div>
					</div>
					<?php $incrfreeprognoz = 0;?>
					<?php foreach ($freeprognozi as $freeprognoz):?>
						<?php if($incrfreeprognoz==5):?>
							<div class="mobgetexpressinlist">
								<a href="express-today.php" class="btngetgrognoztable">
									Получить экспресс на сегодня
								</a>
							</div>

							<?php $incrfreeprognoz = 0;?>
						<?php endif;?>

						<?php
                            $bgclass_vipprognoz = "";
                            if($freeprognoz->getType()=="vip"){
                                $bgclass_vipprognoz = "vipbgprognoz_mob";
                            }
                        ?>
						<div class="mobfreeprognoz <?=$bgclass_vipprognoz?>">
							<div class="row">
								<div class="col-xs-9 pdleft20">
									<a href="<?=$freeprognoz->getSsilka()?>.html" >
										<?=$freeprognoz->getNazva()?>
									</a>
									<?php if($freeprognoz->getType()=="vip"):?>
                                        <b>- VIP</b>
                                    <?php endif;?>

									<br>
									<span class="matchinlist"><?=$freeprognoz->getMatchnazva()?></span><br>
									<span class="font12"><?=$freeprognoz->getTime()?> &nbsp; <?=$freeprognoz->getDate()?></span>
									&nbsp;&nbsp;
									<span class="font12">
                                        <?php if($freeprognoz->getProshel()=="yes"):?>
											<span class="glyphicon glyphicon-ok green"></span> Прошел
										<?php elseif($freeprognoz->getProshel()=="no"):?>
											<span class="glyphicon glyphicon-remove black"></span> Не прошел
										<?php endif;?>
                                    </span>
								</div>
								<div class="col-xs-3 centered" >
									<?=$freeprognoz->getKoeficient()?>
                                    <br>
                                    <?php if($freeprognoz->getType()=="vip" && $freeprognoz->getProshel()==""):?>
                                        <?php if(isset($active_paket) && $active_paket['name']!=false):?>
                                            <a href="<?=$freeprognoz->getSsilka()?>.html" class="vipmob">Смотр.</a>
                                        <?php else:?>
                                            <a href="<?=$freeprognoz->getSsilka()?>.html" class="vipmob">Купить</a>
                                        <?php endif;?>
                                    <?php endif;?>   
								</div>
							</div>
						</div>
						<?php $incrfreeprognoz++;?>
					<?php endforeach;?>


					<p class="centered font20"><a href="prognozi.php">Все прогнозы</a></p><br>
            	</div>
            	<br>


            <?php endif;?>

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

			<?php if(isset($is_mobile) && $is_mobile==false):?> <!--COMPUTER ver-->
            	<div class="bgfreeprognozi mttop10">
	                <div class="table-responsive">
	                    <table class="table">
	                        <thead>
	                        <tr>
	                            <th>Дата</th>
	                            <th>Время</th>
	                            <th>Событие</th>
	                            <th>Коэф.</th>
	                            <th>Проход</th>
	                        </tr>
	                        </thead>
	                        <tbody>
	                        <?php $incrfreeprognoz = 0;?>
	                        <?php foreach ($freeprognozi as $freeprognoz):?>

	                            <?php if($incrfreeprognoz==5):?>
	                                <tr>
	                                    <td colspan="5"><div class="centered"><a href="express-today.php" class="btngetgrognoztable">Получить экспресс на сегодня</a></div></td>
	                                </tr>
	                                <?php $incrfreeprognoz = 0;?>
	                            <?php endif;?>

	                            <?php
                                    $bgclass_vipprognoz = "";
                                    if($freeprognoz->getType()=="vip"){
                                        $bgclass_vipprognoz = "vipbgprognoz";
                                    }
                                ?>

	                            <tr class="">
	                                <td width="80px">
	                                    <div class="bgtdfreeprognoz pdtdfreeprognoz <?=$bgclass_vipprognoz?>"><?=$freeprognoz->getDate()?></div>
	                                </td>
	                                <td width="80px">
	                                    <div class="bgtdfreeprognoz pdtdfreeprognoz <?=$bgclass_vipprognoz?>"><?=$freeprognoz->getTime()?></div>
	                                </td>
	                                <td>
	                                    <div class="bgtdfreeprognoz <?=$bgclass_vipprognoz?>">
	                                        <a href="<?=$freeprognoz->getSsilka()?>.html"><?=$freeprognoz->getNazva()?></a>
	                                        <?php if($freeprognoz->getType()=="vip"):?>
	                                            <b>- VIP</b>
	                                        <?php endif;?>
	                                        <br>
	                                        <span class="matchinlist"><?=$freeprognoz->getMatchnazva()?></span>
	                                    </div>
	                                </td>
	                                <td width="80px"><div class="bgtdfreeprognoz pdtdfreeprognoz <?=$bgclass_vipprognoz?>"><?=$freeprognoz->getKoeficient()?></div></td>
	                                <td width="100px">

	                                        <?php if($freeprognoz->getProshel()=="yes"):?>
	                                            <div class="bgtdfreeprognoz pdtdfreeprognoz <?=$bgclass_vipprognoz?>">
	                                                <span class="glyphicon glyphicon-ok green"></span>
	                                                Прошел
	                                            </div>
	                                        <?php elseif ($freeprognoz->getProshel()=="no"):?>
	                                            <div class="bgtdfreeprognoz pdtdfreeprognoz <?=$bgclass_vipprognoz?>">
	                                                Не прошел
	                                            </div>
	                                        <?php elseif ($freeprognoz->getType()=="vip"):?>
	                                            <?php if(isset($active_paket) && $active_paket['name']!=false):?>
	                                                <a href="<?=$freeprognoz->getSsilka()?>.html" class="btnbuyprognoz">Смотреть</a>
	                                            <?php else:?>
	                                                <a href="<?=$freeprognoz->getSsilka()?>.html" class="btnbuyprognoz">Купить</a>
	                                            <?php endif;?>
	                                        <?php else:?>
	                                            <div class="bgtdfreeprognoz <?=$bgclass_vipprognoz?>">
	                                                &nbsp;
	                                            </div>
	                                        <?php endif;?>

	                                </td>
	                            </tr>

	                            <?php $incrfreeprognoz++;?>
	                        <?php endforeach;?>
	                        </tbody>
	                    </table>
	                </div>
	                <p class="centered font20"><a href="prognozi.php">Все прогнозы</a></p><br>
	            </div>
            <?php endif;?>
            
            
            <br>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
<script>
    $('.mainnew').click(function(){
        var loc = $(this).attr('data-href');
        location.href = loc;
    });
</script>
</body>
</html>