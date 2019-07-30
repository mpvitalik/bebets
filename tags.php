<?php


$nav = "tags";


$active_paket = $db->getActivePaket($user->getId());

/*----------Pagination---------*/
$parts_url = parse_url($_SERVER['REQUEST_URI']);
if(isset($parts_url['query'])){
    parse_str($parts_url['query'], $get_array);
    if(isset($get_array['p'])){
        $tag_posts = $db->getTagPrognoziAndPosts($tag->getNazva(),$get_array['p']);
    }else{
        $tag_posts = $db->getTagPrognoziAndPosts($tag->getNazva(),1);
    }
}else{
    $tag_posts = $db->getTagPrognoziAndPosts($tag->getNazva(),1);
}
/*----------End pagination---------*/

$page = isset($get_array['p'])? intval($get_array['p']) : 1;
$posts = $tag_posts['posts'];
$pages_result = $tag_posts['count'];
$pages = ceil($pages_result/5);
if($page>$pages && $pages!=0){
    $page=$pages;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$tag->getNazva()?> - Bebets.ru</title>
    <meta name="description" content="<?=$tag->getDescription()?>">

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <h1><?=$tag->getNazva()?></h1>
            <?php foreach($posts as $post):?>
                <a href="<?=$post->getSsilka()?>.html" class="black">
                    <p class="bigtag_list"><?=$post->getNazva()?></p>
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
                    <p class="counter"> Стр. <b><?=$page?></b> из <?=$pages?> </p>
                    <ul class="pagination-list pagination">
                        <?php if($page>1):?>
                            <li class="">
                                <a title="Первая стр." href="<?=$tag->getSsilka()?>.html?p=1" class="pagenav"><i class="fa fa-fast-backward" aria-hidden="true"></i></a>
                            </li>
                            <li class="">
                                <a title="Предыдущая стр." href="<?=$tag->getSsilka()?>.html?p=<?=$page-1;?>" class="pagenav"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                        <?php endif;?>
                        <?php if($page<$pages):?>
                            <li class="">
                                <a title="Следующая стр." href="<?=$tag->getSsilka()?>.html?p=<?=$page+1;?>" class="pagenav"><i class="fa fa-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a title="Последняя стр." href="<?=$tag->getSsilka()?>.html?p=<?=$pages;?>" class="pagenav"><i class="fa fa-fast-forward" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            <?php endif;?>
            <hr>
            <div class="row">
                <div class="col-md-12 allrobotofamily">
                    <?=$tag->getText()?>
                </div>
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