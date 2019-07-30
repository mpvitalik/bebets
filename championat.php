<?php
/*header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
$nav = "prognozi";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);*/


//$id = isset($_GET['id']) ? intval($_GET['id']) : die("Error post");
//$prognoz = $db->getPrognozById($id);

//$ssilka = isset($_GET['ssilka'])? htmlspecialchars($_GET['ssilka']) : false;
//$prognoz = $db->getPrognozBySsilka($ssilka);
$nav = "championats";
if($championat->getId()>0){
    $db->incrementChampionat($championat->getId());
    $championat->setViews($championat->getViews()+1);
}
$active_paket = $db->getActivePaket($user->getId());

$description = str_replace("'",'', $championat->getDescription());
$description = str_replace('"','', $description);

$championat_prognozi = $db->getChampionatprognoziSite($championat->getId(),1);
$championat_prognozi = array_slice($championat_prognozi, 0,20);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$championat->getNazva()?>: турнирная таблица, календарь, прогнозы</title>
    <meta name="description" content="<?=$description?>">
    <?php /*if($prognoz->getImg()!=""):?>
        <meta property="og:image"   content="<?=$prognoz->getImg()?>" />
    <?php else:?>
        <meta property="og:image"   content="https://bebets.ru/images/logo_fb.jpg" />
	<?php endif;*/?>
    <meta property="og:image"   content="" />

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">

            <h1><?=$championat->getNazva()?></h1>
            <p class="font12">
                <i class="fa fa-eye" aria-hidden="true"></i>
                Просмотров: <?=$championat->getViews()?>
            </p>

            <?=$championat->getFullTablica()?>

            <!--<div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td></td>
                            <td>И</td>
                            <td class="colorgreen">В</td>
                            <td class="coloryellow">Н</td>
                            <td class="colorred">П</td>
                            <td>З</td>
                            <td>-</td>
                            <td>П</td>
                            <td>О</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1. Манчестер Сити</td>
                            <td>12</td>
                            <td class="colorgreen">10</td>
                            <td class="coloryellow">2</td>
                            <td class="colorred">0</td>
                            <td>36</td>
                            <td>-</td>
                            <td>5</td>
                            <td>32</td>
                        </tr>
                    </tbody>
                </table>
            </div>-->

            <div class="row">
                <div class="col-md-6">
                    <?=$championat->getLittleMatchi()?>
                    <div class="centered">
                        <a href="<?=$championat->getSsilka()?>-vse-turi.html" class="black font16">Смотреть все туры</a>
                    </div>
                    <!--<div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size:18px;margin-top:10px;">2 тур</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10.08.2018</td>
                                    <td>Манчестер Юн</td>
                                    <td>2:1</td>
                                    <td>Лестер</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>-->
                </div>
                <div class="col-md-6">
                    <div class="bgfreeprognozi block_champprognoz">
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
                        <?php foreach ($championat_prognozi as $championat_prognoz):?>
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
                            if($championat_prognoz->getType()=="vip"){
                                $bgclass_vipprognoz = "vipbgprognoz_mob";
                            }
                            ?>
                            <div class="mobfreeprognoz <?=$bgclass_vipprognoz?>">
                                <div class="row">
                                    <div class="col-xs-9 pdleft20">
                                        <a href="<?=$championat_prognoz->getSsilka()?>.html">
                                            <?=$championat_prognoz->getNazva()?>
                                        </a>
                                        <?php if($championat_prognoz->getType()=="vip"):?>
                                            <b>- VIP</b>
                                        <?php endif;?>

                                        <br>
                                        <span class="matchinlist"><?=$championat_prognoz->getMatchnazva()?></span><br>
                                        <span class="font12"><?=$championat_prognoz->getTime()?> &nbsp; <?=$championat_prognoz->getDate()?></span>
                                        &nbsp;&nbsp;
                                        <span class="font12">
                                        <?php if($championat_prognoz->getProshel()=="yes"):?>
                                            <span class="glyphicon glyphicon-ok green"></span> Прошел
                                        <?php elseif($championat_prognoz->getProshel()=="no"):?>
                                            <span class="glyphicon glyphicon-remove black"></span> Не прошел
                                        <?php endif;?>
                                    </span>
                                    </div>
                                    <div class="col-xs-3 centered" >
                                        <?=$championat_prognoz->getKoeficient()?>
                                        <br>
                                        <?php if($championat_prognoz->getType()=="vip" && $championat_prognoz->getProshel()==""):?>
                                            <?php if(isset($active_paket) && $active_paket['name']!=false):?>
                                                <a href="<?=$championat_prognoz->getSsilka()?>.html" class="vipmob">Смотр.</a>
                                            <?php else:?>
                                                <a href="<?=$championat_prognoz->getSsilka()?>.html" class="vipmob">Купить</a>
                                            <?php endif;?>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <?php $incrfreeprognoz++;?>
                        <?php endforeach;?>
                    </div>
                    <div class="centered mt10">
                        <a href="prognozi.php" class="black font16">Смотреть все прогнозы</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="allrobotofamily" id="textinsert">
                        <?=$championat->getText()?>
                    </div>
                </div>
            </div>


            <br><br>
        </div>
        <div class="col-md-3 pdleftcomp-no">
            <?php require_once "side.php";?>
        </div>
    </div>
</div>





<?php require_once "footer.php";?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#textinsert iframe').css('width','100%');
        $('#textinsert table').addClass('table').css('width','100%');
        $('#textinsert img').css("width","auto").css('height','auto').addClass('img-responsive');
    });

    $(document).ready(function(){
        $(".block_champprognoz").mCustomScrollbar({
            theme:"dark",
            scrollInertia:200
        });
    });
</script>

</body>
</html>
