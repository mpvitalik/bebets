<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "otzivi";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$active_paket = $db->getActivePaket($user->getId());

$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$otzivi = $db->getOtzivi($page);
$pages_result = $db->pagesResultOtzivi();
$pages = ceil($pages_result/30);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Отзывы о лучших капперах и прогнозистах - Bebets.ru</title>
    <meta name="description" content="Здесь вы можете почитать отзывы наших клиентов о сотрудничестве с нашей компанией.">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <h1>Отзывы клиентов</h1>
            <?php foreach($otzivi as $otziv):?>
                <a href="<?=$otziv->getImg()?>" class="fancybox" rel="gallery">
                    <img src="<?=$otziv->getImg()?>" class="imgotziv">
                </a>
            <?php endforeach;?>
            <br>
            <?php if($pages>0):?>
                <div class="pagination">
                    <p class="counter"> Стр. <span class="orange"><?=$page?></span> из <?=$pages?> </p>
                    <ul class="pagination-list pagination">
                        <?php if($page>1):?>
                            <li class="">
                                <a title="Первая стр." href="otzivi.php?p=1" class="pagenav"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                            </li>
                            <li class="">
                                <a title="Предыдущая стр." href="otzivi.php?p=<?=$page-1;?>" class="pagenav"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                        <?php endif;?>
                        <?php if($page<$pages):?>
                            <li class="">
                                <a title="Следующая стр." href="otzivi.php?p=<?=$page+1;?>" class="pagenav"><i class="fa fa-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a title="Последняя стр." href="otzivi.php?p=<?=$pages;?>" class="pagenav"><i class="fa fa-fast-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
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
</body>
</html>