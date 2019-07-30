<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "prognoz";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$page = isset($_GET['p'])? intval($_GET['p']) : 1;
if($page<1){
    $page = 1;
}
$pages_result = $db->pagesResultPrognoziFrontend("all");
$pages = ceil($pages_result/30);
if($page>$pages && $pages!=0){
    $page=$pages;
}

$freeprognozi = $db->getPrognozi($page);

$active_paket = $db->getActivePaket($user->getId());


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
            <h1>Бесплатные прогнозы на футбол</h1>
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
                                <a title="Первая стр." href="prognozi.php?p=1" class="pagenav"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                            </li>
                            <li class="">
                                <a title="Предыдущая стр." href="prognozi.php?p=<?=$page-1;?>" class="pagenav"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                        <?php endif;?>
                        <?php if($page<$pages):?>
                            <li class="">
                                <a title="Следующая стр." href="prognozi.php?p=<?=$page+1;?>" class="pagenav"><i class="fa fa-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a title="Последняя стр." href="prognozi.php?p=<?=$pages;?>" class="pagenav"><i class="fa fa-fast-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            <?php endif;?>

            <div class="allrobotofamily">
                <p>Прогнозы на футбол бесплатно сегодня — это раздел нашего сайта, где представлены прогнозы от профессионалов, которые являются следствием нашей системы отбора. Каждый из экспертов дает ряд прогнозов на футбол (определенный чемпионат). В дальнейшем эти прогнозы проходят через ряд фильтров и лучшие из них отбираются в экспресс и мини-экспресс. Остальные идут в раздел бесплатных прогнозов. То есть по факту - это остаточный продукт деятельности нашего аналитического отдела.
                </p>
                <h2>Проходимость бесплатных прогнозов</h2>
                <p>Проходимость таких прогнозов достаточно высокая. В среднем из 10 матчей проходит семь прогнозов. Это составляет 70 процентов от общего числа. Другой вопрос, что даже при высокой проходимости прогнозов, быть стабильно в плюсе, играя в букмекерской конторе, если не знаешь принципов управления финансами, сложно. В случае с платными экспрессами - это значительно проще, ведь коэффициент в этом случае в районе 3.00. Сложность же пользования бесплатными прогнозами в том, что коэффициенты распределяются неравномерно - от 1.30 до 1.80 (а бывает и выше). И не совсем понятно, какими суммами оперировать.</p>
                <h2>Доходность бесплатных прогнозов на сегодня</h2>
                <p>Разница между проходимостью прогнозов и доходностью высокая. Проходимость - это количество матчей, которое прошло от общего количества. Как правило, она имеет мало общего с доходностью. Доходность - процент, который вы заработали от общей суммы капиталовложений. Например, вы сделали ставок на общую сумму 1000 у.е., а назад вернулось 1500 у.е. Значит, ваша доходность составила 50 процентов. В первую очередь это зависит от коэффициентов ваших матчей. К примеру, если у вас прошло восемь матчей из 10, но коэффициенты были, к примеру, 1.2. То выходит вот, что. С одного выигранного матча вы вернули при ставке в 100 у.е. - 120, всего выигрышных матчей восемь. Соответственно 120х8=960. То есть, при высокой проходимости (80%) вы получили даже не плюс, а минус.</p>
                <h3>Как пользоваться бесплатными прогнозами</h3>
                <p>Так как же тогда зарабатывать, используя бесплатные прогнозы? Мы вам предлагаем вариант ставки равными частями. Разбивайте 10 матчей на пары - то есть у вас должны получиться двойные экспрессы, и ставьте одинаковые суммы. Отталкиваясь от третей части банка. Например, у вас банк в 3000 у.е., значит, вы пользуетесь тысячей.
                </p>
                <p>Еще более оптимально разбивать по времени и ставить догоном. Но не всегда для этого есть возможность использовать все матчи, ведь многие из них начинаются в одно время или пересекаются.
                Наш средний коэффициент бесплатных прогнозов получается 1.40-1.45. Разбив 10 матчей на пары, вы получите пять экспрессов с коэффициентами 2.00. При проходе трех экспрессов из пяти вы получите на выходе 600 у.е. при поставленных 500.</p>
                <h4>Бесплатные прогнозы только на сегодня?</h4>
                <p>Нет. Мы стараемся давать прогнозы на один-два дня наперед, чтобы у игроков была общая картина и понимание какие коэффициенты будут не только сегодня, а и завтра, а то и послезавтра. Согласитесь, таким образом, проще составить план игры. А план вам категорически необходим, если вы хотите быть "в плюсе" в букмекерской конторе.</p>
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