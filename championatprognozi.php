<?php


$nav = "championats";
$active_paket = $db->getActivePaket($user->getId());

/*----------Pagination---------*/
$parts_url = parse_url($_SERVER['REQUEST_URI']);
$page = 1;
if(isset($parts_url['query'])){
    parse_str($parts_url['query'], $get_array);
    if(isset($get_array['p'])){
        $page = intval($get_array['p']);
        if($page<1){
            $page = 1;
        }
    }

}

/*----------End pagination---------*/
$championat = $championatprognoz;
$freeprognozi = $db->getChampionatprognoziSite($championat->getId(),$page);
$pages_result = $db->pagesResultChampionatPrognoziSite($championat->getId());
$pages = ceil($pages_result/30);
if($page>$pages && $pages!=0){
    $page=$pages;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Бесплатные прогнозы на футбол сегодня от профессионалов - Bebets.ru</title>
    <meta name="description" content="Бесплатные прогнозы на футбол от экспертов сайта bebets.ru с высокой проходимостью и возможностью заработать на ставках в букмекерских конторах">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9 pdrightcomp-no">
            <h1>Бесплатные прогнозы на <?=$championat->getNazva()?></h1>
            <div class="bgfreeprognozi">
                <?php if(isset($is_mobile) && $is_mobile==true):?> <!--MOBILE ver-->

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
                                    <a href="<?=$freeprognoz->getSsilka()?>.html">
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

                <?php else:?>

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
                                            <?php endif;?><br>
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
                                            <div class="bgtdfreeprognoz <?=$bgclass_vipprognoz?>">&nbsp;</div>
                                        <?php endif;?>
                                    </td>
                                </tr>

                                <?php $incrfreeprognoz++;?>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                <?php endif;?>

            </div>
            <?php if($pages>0):?>
                <div class="pagination">
                    <p class="counter"> Стр. <b><?=$page?></b> из <?=$pages?> </p>
                    <ul class="pagination-list pagination">
                        <?php if($page>1):?>
                            <li class="">
                                <a title="Первая стр." href="<?=$championat->getSsilka()?>-prognozi.html?p=1" class="pagenav"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                            </li>
                            <li class="">
                                <a title="Предыдущая стр." href="<?=$championat->getSsilka()?>-prognozi.html?p=<?=$page-1;?>" class="pagenav"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                        <?php endif;?>
                        <?php if($page<$pages):?>
                            <li class="">
                                <a title="Следующая стр." href="<?=$championat->getSsilka()?>-prognozi.html?p=<?=$page+1;?>" class="pagenav"><i class="fa fa-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a title="Последняя стр." href="<?=$championat->getSsilka()?>-prognozi.html?p=<?=$pages;?>" class="pagenav"><i class="fa fa-fast-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            <?php endif;?>
            <hr>
            <div class="allrobotofamily">
                <?=$championat->getTextPrognoziBottom()?>
            </div>
            <br>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>

<?php require_once "footer.php";?>
</body>
</html>