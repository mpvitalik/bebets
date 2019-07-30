<?php
/*header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
$nav = "news";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);*/

//$id = isset($_GET['id']) ? intval($_GET['id']) : die("Error post");
//$post = $db->getPostById($id);
//$ssilka = isset($_GET['ssilka'])? htmlspecialchars($_GET['ssilka']) : false;
//$post = $db->getPostBySsilka($ssilka);
if($post->getId()>0){
    $db->incrementPost($post->getId());
    $post->setViews($post->getViews()+1);
}
$active_paket = $db->getActivePaket($user->getId());

$description = str_replace("'",'', $post->getNazva());
$description = str_replace('"','', $description);

$tags = explode(";", $post->getTags());
$newtags = array();
foreach($tags as $tag){
    if($tag!="" && $tag!=" " && $tag!="  "){
        $newtag = $db->getTagByNazva($tag);
        if($newtag->getId()>0){
            $newtags[] = $newtag;
        }
    }
}

$scroll = isset($_COOKIE['scrollfromtop'])? intval($_COOKIE['scrollfromtop']) : 0;
$comment_sort = isset($_COOKIE['comment_sort'])? htmlspecialchars($_COOKIE['comment_sort']) : "";
if(isset($_COOKIE['scrollfromtop']) || isset($_COOKIE['comment_sort'])){
    $db->unsetSortCommentsCookie();
}

$user_unread_comments = $db->getUnreadUserThisPostComments($user->getId(),$post->getId());
if(count($user_unread_comments)>0){
    $db->makereadUserPostComments($post->getId(),$user->getId());
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$post->getNazva()?> - Bebets.ru</title>
    <meta name="description" content="<?=$description?>. Лучшие и свежие бонусные предложения от букмекеров при регистрации и за первый депозит.">
    <?php /*if($post->getImg()!=""):?>
	    <meta property="og:image"   content="<?=$post->getImg()?>" />
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

            <h1><?=$post->getNazva()?></h1>

            <p class="font12">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                Опубликовано: <?php
                $date_p = new DateTime($post->getDate());
                echo $date_p->format("d.m.Y");
                unset($date_p);
                ?> &nbsp;&nbsp;| &nbsp;&nbsp;
                <i class="fa fa-eye" aria-hidden="true"></i>
                Просмотров: <?=$post->getViews()?>
            </p>

            <?php if($post->getImg()!=""):?>
                <img class="img-responsive" src="<?=$post->getImg()?>">
            <?php endif;?>
            <br>
            <div class="robotofamily" id="textinsert">
                <h2 class="bold font16 mt0"><?=$post->getDescription()?></h2>
                <?=$post->getText()?>
            </div>
            <p>Теги:
                <?php $tag_inctement = 1;?>
                <?php foreach($newtags as $tag):?>
                    <a href="<?=$tag->getSsilka()?>.html"><?=$tag->getNazva()?></a><?php
                    if($tag_inctement<count($newtags)){
                        echo ",";
                    }
                    $tag_inctement++;
                    ?>
                <?php endforeach;?>
            </p>
            <br>
            <div class="centered">
                <a href="express-today.php" class="btngetgrognoztable">Получить экспресс на сегодня</a>
            </div><br><br>

            <?php
                if($comment_sort=="popular"){
                    $comments = $db->getPostCommentsSortPopular($post->getId());
                }else{
                    $comments = $db->getPostComments($post->getId());
                }
            ?>
            <div class="row robotofamily">
                <div class="col-md-10 col-md-offset-1">
                    <hr>
                    <p class="font16">Комментарии</p>
                    <form class="centered">
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="comment" style="font-family: 'Roboto', sans-serif;"></textarea>
                        </div>
                        <div class="rightalign">
                            <?php if($user->getId()>0):?>
                                <button type="button" class="btn-leavecomment" post-id="<?=$post->getId()?>">Написать</button>
                            <?php else:?>
                                <button type="button" class="btn-leavecomment-notreg" post-id="<?=$post->getId()?>">Написать</button>
                            <?php endif;?>
                        </div>
                    </form>
                    <hr>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
                            <?php if($comment_sort=="popular"):?>
                                По популярности
                            <?php else:?>
                                По дате
                            <?php endif;?>
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a class="sort_comment" data-sort="date">По дате</a></li>
                            <li><a class="sort_comment" data-sort="popular">По популярности</a></li>
                        </ul>
                    </div>
                    <div id="insert-ajax-comments">
                        <?php $comment_increment = 1;?>
                        <?php foreach($comments as $comment):?>
                            <div class="<?php if($comment_increment>10)echo "hidecomment";?>">
                                <div class="comment" id="comment<?=$comment['comment']->getId()?>">
                                    <p>
                                        <span class="comment-login"><?=$comment['comment']->getLogin()?>:</span>
                                        <?=$comment['comment']->getText()?>
                                    </p>
                                </div>
                                <p class="rightalign" id="otvetp<?=$comment['comment']->getId()?>">
                                    <span class="date_comment"><?=$comment['comment']->getDatee()?></span>
                                    <?php if($user->getId()>0):?>
                                        <a class="comment_otvetit" id-comment="<?=$comment['comment']->getId()?>"><small>Ответить</small></a>&nbsp;
                                    <?php else:?>
                                        <a class="comment_otvetit_notreg"><small>Ответить</small></a>&nbsp;
                                    <?php endif;?>
                                    <a class="click_like" data-type="like" id-comment="<?=$comment['comment']->getId()?>">
                                        <i class="fa fa-thumbs-up grey" aria-hidden="true"></i>
                                        <span class="colorgreen likecount" id-comment="<?=$comment['comment']->getId()?>"><?=count($comment['likes'])?></span>&nbsp;
                                    </a>
                                    <a class="click_like" data-type="dislike" id-comment="<?=$comment['comment']->getId()?>">
                                        <i class="fa fa-thumbs-down grey" aria-hidden="true"></i>
                                        <span class="colorred dislikecount" id-comment="<?=$comment['comment']->getId()?>"><?=count($comment['dislikes'])?></span>
                                    </a>
                                </p>
                                <div class="subcoments_list" id-comment="<?=$comment['comment']->getId()?>">
                                    <?php $subcomment_increment = 1;?>
                                    <?php foreach($comment['comment_childs'] as $comment_child):?>
                                        <div class="<?php if($subcomment_increment>2)echo "hidesubcomment";?>" id-comment="<?=$comment['comment']->getId()?>">
                                            <div class="subcomment">
                                                <?php if($comment_child['comment']->getLoginReplycomment()!="" && $comment_child['comment']->getTextReplycomment()!=""):?>
                                                    <span class="written_comment"><?=$comment_child['comment']->getLoginReplycomment()?>: <?=$comment_child['comment']->getTextReplycomment()?></span>
                                                <?php endif;?>
                                                <p>
                                                        <span class="comment-login">
                                                            <i class="fa fa-reply" aria-hidden="true"></i>
                                                            <?=$comment_child['comment']->getLogin()?>:</span>
                                                    <?=$comment_child['comment']->getText()?>
                                                </p>
                                            </div>
                                            <p class="rightalign" id="otvetp<?=$comment_child['comment']->getId()?>">
                                                <span class="date_comment"><?=$comment_child['comment']->getDatee()?></span>
                                                <?php if($user->getId()>0):?>
                                                    <a class="subcomment_otvetit" id-comment="<?=$comment['comment']->getId()?>" id-subcomment="<?=$comment_child['comment']->getId()?>"><small>Ответить</small></a>&nbsp;
                                                <?php else:?>
                                                    <a class="comment_otvetit_notreg"><small>Ответить</small></a>&nbsp;
                                                <?php endif;?>
                                                <a class="click_like" data-type="like" id-comment="<?=$comment_child['comment']->getId()?>">
                                                    <i class="fa fa-thumbs-up grey" aria-hidden="true"></i>
                                                    <span class="colorgreen likecount" id-comment="<?=$comment_child['comment']->getId()?>"><?=count($comment_child['likes'])?></span>&nbsp;
                                                </a>
                                                <a class="click_like" data-type="dislike" id-comment="<?=$comment_child['comment']->getId()?>">
                                                    <i class="fa fa-thumbs-down grey" aria-hidden="true"></i>
                                                    <span class="colorred dislikecount" id-comment="<?=$comment_child['comment']->getId()?>"><?=count($comment_child['dislikes'])?></span>
                                                </a>
                                            </p>
                                        </div>
                                        <?php if($subcomment_increment>2 && $subcomment_increment==count($comment['comment_childs'])):?>
                                            <div class="razvernytsub_div" style="font-family:'Roboto',sans-serif;">
                                                <a class="razvernut_subcoments" id-comment="<?=$comment['comment']->getId()?>"><small>Развернуть комментарии</small></a>
                                            </div>
                                        <?php endif;?>
                                        <?php $subcomment_increment++;?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            <?php if($comment_increment>10 && $comment_increment==count($comments)):?>
                                <div class="razvernytcoment_div" style="font-family:'Roboto',sans-serif;">
                                    <a class="razvernut_all_comment"><small>Развернуть остальные комментарии</small></a>
                                </div>
                            <?php endif;?>
                            <?php $comment_increment++;?>
                        <?php endforeach;?>
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

<?php if($user->getId()>0):?>
    <div class="modal fade product_view" id="modal-leavecomment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="response-modal-golosovanie">
                            <p class="font16">Ответ на комментарий:</p>
                            <form class="centered">
                                <div class="form-group">
                                    <textarea class="form-control" rows="2" id="textcomment-modal" style="font-family: 'Roboto', sans-serif;"></textarea>
                                </div>
                                <div class="rightalign">
                                    <button type="button" id="btn-replycomment" class="btn-replycomment" post-id="<?=$post->getId()?>">Отправить</button>
                                </div>
                            </form><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php else:?>
    <div class="modal fade product_view" id="modal-golosovanie-notreg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="centered">
                                <p class="font16">Оставлять комментарии могут
                                    только зарегистрированные пользователи!</p>
                                <a href="register.php" class="orange font16">Регистрация</a> |
                                <a href="enter.php" class="orange font16">Вход</a>
                            </div><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif;?>


<script>
    var ssilkapost = "<?=$post->getSsilka()?>";
    var thispostid = <?=$post->getId()?>;
    var commentssort = "<?=$comment_sort?>";
    <?php if($scroll>0):?>
    document.documentElement.scrollTop = <?=$scroll?>;
    <?php endif;?>

</script>

<?php require_once "footer.php";?>
<script src="js/postcomments.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#textinsert iframe').css('width','100%');
        $('#textinsert table').addClass('table').css('width','100%');
        $('#textinsert img').css("width","auto").css('height','auto').addClass('img-responsive');
    });
</script>
</body>
</html>