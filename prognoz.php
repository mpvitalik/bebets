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
$nav = "prognoz";
if($prognoz->getId()>0){
    $db->incrementPrognoz($prognoz->getId());
    $prognoz->setViews($prognoz->getViews()+1);
}
$active_paket = $db->getActivePaket($user->getId());

$description = str_replace("'",'', $prognoz->getNazva());
$description = str_replace('"','', $description);

$other_prognozi_thisdate = $db->getPrognoziThisDate($prognoz->getId(),$prognoz->getDate(),$prognoz->getYear());

$golosovanie = $db->getPrognozgolosovanieAll($prognoz->getId(),$user->getId());

if($golosovanie['summagolosov']>0){
    $percent_prohod = ceil((count($golosovanie['prohod'])*100)/$golosovanie['summagolosov']);
}

$tags = explode(";", $prognoz->getTags());
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

$user_unread_comments = $db->getUnreadUserThisPrognozComments($user->getId(),$prognoz->getId());
if(count($user_unread_comments)>0){
    $db->makereadUserPrognozComments($prognoz->getId(),$user->getId());
}

$prognoz_banner = $db->getReklamaById(3);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$prognoz->getNazva()?> - Bebets.ru</title>
    <meta name="description" content="<?=$description?>. Прогнозы на футбол от лучших прогнозистов-капперов.">
    <?php /*if($prognoz->getImg()!=""):?>
        <meta property="og:image"   content="<?=$prognoz->getImg()?>" />
    <?php else:?>
        <meta property="og:image"   content="https://bebets.ru/images/logo_fb.jpg" />
	<?php endif;*/?>
     <meta property="og:image"   content="https://bebets.ru/images/fb_prognoz.png" />

    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">

            <h1><?=$prognoz->getNazva()?></h1>
            <p class="font12">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                Опубликовано: <?php
                $date_p = new DateTime($prognoz->getDatePublic());
                echo $date_p->format("d.m.Y");
                unset($date_p);
                ?> &nbsp;&nbsp;| &nbsp;&nbsp;
                <i class="fa fa-eye" aria-hidden="true"></i>
                Просмотров: <?=$prognoz->getViews()?>
            </p>
            <?php if($prognoz->getImg()!=""):?>
                <img class="img-responsive" src="<?=$prognoz->getImg()?>">
            <?php endif;?>
            <br>
            <p> <b>Коэффициент:</b> <?=$prognoz->getKoeficient()?><br>
                <b>Дата / Время начала события:</b> <?=$prognoz->getDate()?>/<?=$prognoz->getTime()?><br>
                <?=$prognoz->getMatchnazva()?>
            </p>

            <div class="robotofamily">
                <h2 class="bold font16 mt0"><?=$prognoz->getDescription()?></h2>
            </div>

            <?php if($prognoz->getType()=="vip"):?>
                <?php if((isset($active_paket) && $active_paket['name']!=false) || $prognoz->getProshel()=="yes" || $prognoz->getProshel()=="no"):?>
                    <div class="robotofamily textprognoza">
                        <?=$prognoz->getText()?>
                    </div>

                <?php else:?>
                    <div class="row">
                        <div class="col-md-12 centered">
                            <p style="text-align: center;"><span style="color:#ff0000;font-size:18px;"><strong>Цена 1000 руб.</strong></span></p>
                            <p>
                                <a href="kak-poluchit-vip-prognoz-besplatno.html" class="btngetgrognoztable" style="text-transform:none;">Получить VIP-прогноз БЕСПЛАТНО</a>
                            </p><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bgform col-md-8 col-md-offset-2" style="margin-bottom: 30px;">
                            <p class="fontbuy_in_form">Купить прогноз</p>
                            <form class="pdsideform">
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                                           value="<?php if($user->getEmail()!="") echo $user->getEmail();?>" >
                                </div>
                                <input type="hidden" name="type" id="type" value="buyonevip">
                                <input type="hidden" name="id" id="id" value="<?=$prognoz->getId()?>">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="agreeemail">Я подтверждаю, что ввел e-mail правильно . Ознакомлен с <a href="oferta.php">офертой</a>
                                    </label>
                                </div>
                                <button type="button" class="btnorange" id="submitemail_prognoz">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;
                                    Оплатить
                                </button>
                            </form><br>
                        </div>
                    </div>

                <?php endif;?>
                <!--HERE WAS-->

                <!--HERE End-->
            <?php else:?>
                <div class="robotofamily textprognoza" id="textinsert">
                    <?=$prognoz->getText()?>
                </div>
                <br>
                <!--HERE WAS-->

                <!--HERE End-->

            <?php endif;?>


            <?php if(count($other_prognozi_thisdate)>0):?>

                <div class="other_prognozi_thisdate">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb15">Прогнозы на сегодня (<?=$prognoz->getDate()?>)</h4>
                        </div>
                    </div>
                    <?php foreach ($other_prognozi_thisdate as $other_prognoz_thisdate):?>

                        <div class="row robotofamily">
                            <div class="col-xs-2 col-sm-1">
                                <p class="lineheight14"><?=$other_prognoz_thisdate->getTime()?></p>
                            </div>
                            <div class="col-xs-10 col-sm-11">
                                <p class="lineheight14">
                                    <a href="<?=$other_prognoz_thisdate->getSsilka()?>.html" class="black">
                                        <?php if($other_prognoz_thisdate->getMatchnazva()!=""):?>
                                            <?=$other_prognoz_thisdate->getMatchnazva()?>.
                                        <?php endif;?>
                                        <?=$other_prognoz_thisdate->getNazva()?> -
                                        КФ <?=$other_prognoz_thisdate->getKoeficient()?>
                                    </a>
                                    <?php if($other_prognoz_thisdate->getType()=="vip"):?>
                                        <span class="vipesheprognoz">VIP</span>
                                    <?php endif;?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <br>
                </div>
            <?php endif;?>


            <div class="hidden-xs hidden-sm centered">
                <?=$prognoz_banner->getKod()?>
            </div>
            <div class="hidden-lg hidden-md centered">
                <?=$prognoz_banner->getKodMob()?>
            </div>






            <?php if(($user->getId()==0 || ($user->getId()>0 && $golosovanie['usergolosoval']=="no")) && $prognoz->getProshel()==""):?>
                <p class="centered font16">Пройдет этот прогноз ?</p>
                <!--<p class="centered grey">Проголосовал(и) 16 человек</p>-->
                <div class="centered mt15 mb15">
                    <a class="golosbtn-proidet" prohod="prohod" prognoz-id="<?=$prognoz->getId()?>" userreg="<?=$user->getId()>0? "yes" : "no";?>">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i> ДА
                    </a>&nbsp;
                    <a class="golosbtn-neproidet" prohod="neprohod" prognoz-id="<?=$prognoz->getId()?>" userreg="<?=$user->getId()>0? "yes" : "no";?>">
                        <i class="fa fa-thumbs-down" aria-hidden="true"></i> НЕТ
                    </a>
                </div>
            <?php elseif($golosovanie['summagolosov']>0 && (($user->getId()>0 && $golosovanie['usergolosoval']=="yes") || $prognoz->getProshel()!="")):?>
                <p class="centered font16">Пройдет этот прогноз ?</p>
                <p class="centered grey">Проголосовал(и) <?=$golosovanie['summagolosov']?> человек(а)</p>
                <div class="row">
                    <div class="col-xs-6 colorgreen">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i> Пройдет <?=$percent_prohod?>%
                    </div>
                    <div class="col-xs-6 colorred rightalign">
                        <i class="fa fa-thumbs-down" aria-hidden="true"></i> Не пройдет <?=100-$percent_prohod?>%
                    </div>
                </div>
                <div class="progress mt5">
                    <div class="progress-bar" role="progressbar" style="width:<?=$percent_prohod?>%;background-color:#08ad2f;" aria-valuenow="<?=$percent_prohod?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar" role="progressbar" style="width:<?=100-$percent_prohod?>%;background-color:#f22c2c;" aria-valuenow="<?=100-$percent_prohod?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            <?php endif;?>
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
            </div>
            <br>


                <?php
                    if($comment_sort=="popular"){
                        $comments = $db->getPrognozCommentsSortPopular($prognoz->getId());
                    }else{
                        $comments = $db->getPrognozComments($prognoz->getId());
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
                                    <button type="button" class="btn-leavecomment" prognoz-id="<?=$prognoz->getId()?>">Написать</button>
                                <?php else:?>
                                    <button type="button" class="btn-leavecomment-notreg" prognoz-id="<?=$prognoz->getId()?>">Написать</button>
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

<div class="modal fade product_view" id="modal-golosovanie">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_modalsend" prognoz-id="<?=$prognoz->getId()?>">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="response-modal-golosovanie">
                        <p class="font16">Почему? Объясни нам! Автор лучшего коммента недели получит приз 3000 тенге/500 рублей/250 грн</p>
                        <form class="centered">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" id="golosmodal-comment" style="font-family: 'Roboto', sans-serif;"></textarea>
                            </div>
                            <div class="rightalign">
                                <button type="button" class="btn-golosmodalsend" prognoz-id="<?=$prognoz->getId()?>">Добавить мнение</button>
                            </div>
                        </form><br>
                    </div>
                </div>
            </div>

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
                                    <button type="button" id="btn-replycomment" class="btn-replycomment" prognoz-id="<?=$prognoz->getId()?>">Отправить</button>
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
    var ssilkaprognoz = "<?=$prognoz->getSsilka()?>";
    var thisprognozid = <?=$prognoz->getId()?>;
    var commentssort = "<?=$comment_sort?>";
    <?php if($scroll>0):?>
        document.documentElement.scrollTop = <?=$scroll?>;
    <?php endif;?>

</script>

<?php require_once "footer.php";?>
<script src="js/prognozcomments.js"></script>

<script>
    $(document).ready(function(){
        var arr_paragr_prognoz = $('.textprognoza p');
        if(arr_paragr_prognoz.length>1){
            if(arr_paragr_prognoz.length>3){
                $('.other_prognozi_thisdate').insertAfter(arr_paragr_prognoz[2]);
            }else{
                $('.other_prognozi_thisdate').insertAfter(arr_paragr_prognoz[arr_paragr_prognoz.length-1]);
            }
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#textinsert iframe').css('width','100%');
        $('#textinsert table').addClass('table').css('width','100%');
        $('#textinsert img').css("width","auto").css('height','auto').addClass('img-responsive');
    });
</script>
</body>
</html>
