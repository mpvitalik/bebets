<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "";
require_once "php/Database.php";
$db = new Database();
$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);
if($user->getId()>0){
    header("Location:index.php");
    die();
}

$kod = isset($_GET['kod'])? htmlspecialchars($_GET['kod']) : false;
$id_user = isset($_GET['id_user'])? intval($_GET['id_user']) : 0;

if($kod!=false && $id_user!=0){
    $success_podtversdenie = $db->emailPodtverzdenieNewUser($id_user,$kod);
}

$golos_idprognoz = isset($_COOKIE['golos_idprognoz'])? intval($_COOKIE['golos_idprognoz']) : 0;
$golos_prohod = isset($_COOKIE['golos_prohod'])? htmlspecialchars($_COOKIE['golos_prohod']) : false;
$golos_comment = isset($_COOKIE['golos_comment'])? htmlspecialchars($_COOKIE['golos_comment']) : false;
$golos_status = isset($_COOKIE['golos_status'])? htmlspecialchars($_COOKIE['golos_status']) : false;

$prognoz_idprognoz = isset($_COOKIE['prognoz_idprognoz'])? htmlspecialchars($_COOKIE['prognoz_idprognoz']) : 0;
$prognoz_comment = isset($_COOKIE['prognoz_comment'])? htmlspecialchars($_COOKIE['prognoz_comment']) : false;

$post_idpost = isset($_COOKIE['post_idpost'])? intval($_COOKIE['post_idpost']) : 0;
$post_comment = isset($_COOKIE['post_comment'])? htmlspecialchars($_COOKIE['post_comment']) : false;


//Если стоят куки голосования на прогнозе - тогда редиректим на сам прогноз
if( isset($success_podtversdenie) && $success_podtversdenie && $golos_status!=false && $id_user!=0 &&  $golos_status=="notsaved" && $golos_idprognoz!=0 ){
    $datagolos = array(
        'id_prognoz'=> $golos_idprognoz,
        'prohod' => $golos_prohod,
        'comment' => $golos_comment,
        'id_user' => $id_user
    );
    if($db->checkGolosovalUserInPrognoz($id_user)=="negolosoval"){
        $db->insertPrognozgolos($datagolos);
        if($datagolos['comment']!="" && $datagolos['comment']!=" " && $datagolos['comment']!="  "){
            $db->insertUserPrognozcomment($datagolos);
        }
    }

    $db->unsetGolosCookie();

    $prognoz = $db->getPrognozById($golos_idprognoz);
    $us_golos = $db->getUserById($id_user);

    if( $us_golos->getId()!=0 && $us_golos->getPodtverzden()=="yes"){
        $user_session = $db->insertUserToUserSession($us_golos->getId());
        header("Location:".$prognoz->getSsilka().".html");
    }
    //Если стоят куки коммента от незарег пользователя
}elseif(isset($success_podtversdenie) && $success_podtversdenie && $prognoz_idprognoz!=0 && $prognoz_comment!=false){
    if($prognoz_comment!="" && $prognoz_comment!=" " && $prognoz_comment!="  "){
        $datacomment = array(
            'id_prognoz'=> $prognoz_idprognoz,
            'comment' => $prognoz_comment,
            'id_user' => $id_user
        );
        $db->insertUserPrognozcomment($datacomment);
    }
    $db->unsetCommentPrognozCookie();
    $prognoz = $db->getPrognozById($prognoz_idprognoz);
    $us_golos = $db->getUserById($id_user);
    if($us_golos->getId()!=0 && $us_golos->getPodtverzden()=="yes"){
        $user_session = $db->insertUserToUserSession($us_golos->getId());
    }
    header("Location:".$prognoz->getSsilka().".html");
    //Если стоят куки коммента на новость от незарег пользователя
}elseif(isset($success_podtversdenie) && $success_podtversdenie && $post_idpost!=0 && $post_comment!=false){
    if($post_comment!="" && $post_comment!=" " && $post_comment!="  "){
        $datacomment = array(
            'id_post'=> $post_idpost,
            'comment' => $post_comment,
            'id_user' => $id_user
        );
        $db->insertUserPostcomment($datacomment);
    }
    $db->unsetCommentPostCookie();
    $post = $db->getPostById($post_idpost);
    $us_golos = $db->getUserById($id_user);
    if($us_golos->getId()!=0 && $us_golos->getPodtverzden()=="yes"){
        $user_session = $db->insertUserToUserSession($us_golos->getId());
    }
    header("Location:".$post->getSsilka().".html");
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Подтверждение email - Bebets.ru</title>
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">
            <?php if(isset($success_podtversdenie) && $success_podtversdenie==true):?>
                <h2>Ваш емейл успешно подтвержден!</h2>
                <?php if($golos_status!=false && $id_user!=0 && $golos_status=="notsaved" && $golos_idprognoz!=0 ):?>
                    <h3>Ваше мнение добавленно в комментарии!</h3>
                <?php endif;?>
                <a href="enter.php">Войдите в личный кабинет</a>
            <?php elseif(isset($success_podtversdenie) && $success_podtversdenie==false):?>
                <h2>Ваш емейл не подтвержден!</h2>
                <a href="podtverditemail2.php?id_user=<?=$id_user?>"><b>Получить код снова</b></a>
            <?php else:?>
                <h2>На ваш емейл выслано письмо для подтверждения</h2>
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