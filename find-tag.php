<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "news";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);

$tag = isset($_GET['tag'])? htmlspecialchars($_GET['tag']) : "";
$page = isset($_GET['p'])? intval($_GET['p']) : 1;
if($page<1){
    $page = 1;
}

$tag_posts = $db->getTagPrognoziAndPosts($tag,$page);
$posts = $tag_posts['posts'];
$pages_result = $tag_posts['count'];
$pages = ceil($pages_result/21);
if($page>$pages && $pages!=0){
    $page=$pages;
}


$active_paket = $db->getActivePaket($user->getId());


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Бонусы букмекерских контор, акции, новости от БК - Bebets.ru</title>
    <meta name="description" content="Лучшие и свежие бонусные предложения от букмекеров при регистрации и за первый депозит, акции, оперативные новости вы можете найти в этом разделе.">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <h1>Тег: <?=$tag?></h1>
            <?php foreach($posts as $post):?>
                <a href="<?=$post->getSsilka()?>.html" class="black">
                    <h2><?=$post->getNazva()?></h2>
                </a>
                <p class="font12">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    Опубликовано: <?php
                    $date_p = new DateTime($post->getDateSort());
                    echo $date_p->format("d.m.Y");
                    unset($date_p);
                    ?> &nbsp;&nbsp;| &nbsp;&nbsp;
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    Просмотров:  <?=$post->getViews()?>
                </p>
                <br>
                <a href="<?=$post->getSsilka()?>.html" class="podrobnee">Подробнее</a>
                <hr>
            <?php endforeach;?>
            <?php if($pages>0):?>
                <div class="pagination">
                    <p class="counter"> Стр. <span class="orange"><?=$page?></span> из <?=$pages?> </p>
                    <ul class="pagination-list pagination">
                        <?php if($page>1):?>
                            <li class="">
                                <a title="Первая стр." href="find-tag.php?p=1&tag=<?=$tag?>" class="pagenav"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                            </li>
                            <li class="">
                                <a title="Предыдущая стр." href="news.php?p=<?=$page-1;?>&tag=<?=$tag?>" class="pagenav"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                        <?php endif;?>
                        <?php if($page<$pages):?>
                            <li class="">
                                <a title="Следующая стр." href="news.php?p=<?=$page+1;?>&tag=<?=$tag?>" class="pagenav"><i class="fa fa-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a title="Последняя стр." href="news.php?p=<?=$pages;?>&tag=<?=$tag?>" class="pagenav"><i class="fa fa-fast-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
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