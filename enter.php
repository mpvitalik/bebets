<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "enter";
require_once "php/Database.php";
$db = new Database();


$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);
if($user->getId()>0){
    header("Location:index.php");
    die();
}

$golos_idprognoz = isset($_COOKIE['golos_idprognoz'])? intval($_COOKIE['golos_idprognoz']) : 0;
$golos_prohod = isset($_COOKIE['golos_prohod'])? htmlspecialchars($_COOKIE['golos_prohod']) : false;
$golos_comment = isset($_COOKIE['golos_comment'])? htmlspecialchars($_COOKIE['golos_comment']) : false;
$golos_status = isset($_COOKIE['golos_status'])? htmlspecialchars($_COOKIE['golos_status']) : false;


$prognoz_idprognoz = isset($_COOKIE['prognoz_idprognoz'])? intval($_COOKIE['prognoz_idprognoz']) : 0;
$prognoz_comment = isset($_COOKIE['prognoz_comment'])? htmlspecialchars($_COOKIE['prognoz_comment']) : false;


$post_idpost = isset($_COOKIE['post_idpost'])? intval($_COOKIE['post_idpost']) : 0;
$post_comment = isset($_COOKIE['post_comment'])? htmlspecialchars($_COOKIE['post_comment']) : false;


if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email']) : "";
    $pass = isset($_POST['pass'])? htmlspecialchars($_POST['pass']) : "";

    $error_mess = $db->checkUserVhod($email,$pass);
    if($error_mess['error']=="false"){
        $user = $db->makeUserVhod($email,$pass);
        if($user->getId()!=0 && $user->getPodtverzden()=="yes"){
            $user_session = $db->insertUserToUserSession($user->getId());
            //Если стоят куки голосования на прогнозе - тогда редиректим на сам прогноз
            if($golos_status!=false && $golos_status=="notsaved" && $golos_idprognoz!=0 ){
                $datagolos = array(
                    'id_prognoz'=> $golos_idprognoz,
                    'prohod' => $golos_prohod,
                    'comment' => $golos_comment,
                    'id_user' => $user->getId()
                );
                if($db->checkGolosovalUserInThisPrognoz($user->getId(),$golos_idprognoz)=="negolosoval"){
                    $db->insertPrognozgolos($datagolos);
                    if($datagolos['comment']!="" && $datagolos['comment']!=" " && $datagolos['comment']!="  "){
                        $db->insertUserPrognozcomment($datagolos);
                    }
                }
                $db->unsetGolosCookie();
                $prognoz = $db->getPrognozById($golos_idprognoz);
                header("Location:".$prognoz->getSsilka().".html");
            }elseif($prognoz_idprognoz!=0 && $prognoz_comment!=false){//Если стоят куки коммента от незарег пользователя
                if($prognoz_comment!="" && $prognoz_comment!=" " && $prognoz_comment!="  "){
                    $datacomment = array(
                        'id_prognoz'=> $prognoz_idprognoz,
                        'comment' => $prognoz_comment,
                        'id_user' => $user->getId()
                    );
                    $db->insertUserPrognozcomment($datacomment);
                }
                $db->unsetCommentPrognozCookie();
                $prognoz = $db->getPrognozById($prognoz_idprognoz);
                header("Location:".$prognoz->getSsilka().".html");
            }elseif($post_idpost!=0 && $post_comment!=false){//Если стоят куки коммента от незарег пользователя в новости
                if($post_comment!="" && $post_comment!=" " && $post_comment!="  "){
                    $datacomment = array(
                        'id_post'=> $post_idpost,
                        'comment' => $post_comment,
                        'id_user' => $user->getId()
                    );
                    $db->insertUserPostcomment($datacomment);
                }
                $db->unsetCommentPostCookie();
                $post = $db->getPostById($post_idpost);
                header("Location:".$post->getSsilka().".html");
            }else{
                header("Location:index.php");
            }

        }elseif($user->getId()!=0 && $user->getPodtverzden()=="no"){
            $no_user = "nepodtverzdenkod";
        }else{
            $no_user = "yes";
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Вход - Bebets.ru</title>
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9 hidden-sm hidden-xs">

            <div class="col-md-10 col-md-offset-1">
                <h1>Вход</h1>
                <div class="bgform">
                  <br>
                    <form class="pdsideform" action="<?=basename(__FILE__)?>" method="post">
                        <?php if(isset($no_user) && $no_user=="yes"):?>
                            <p style="color:red;">Неверный email или пароль</p>
                        <?php elseif (isset($no_user) && $no_user=="nepodtverzdenkod"):?>
                            <p style="color:red;">
                                Ваш Email не подтвержден - <a href="podtverditemail2.php?id_user=<?=$user->getId()?>"><b>Получить код</b></a>
                            </p>
                        <?php elseif(isset($error_mess)):?>
                            <p style="color:red;"><?=$error_mess['mess']?></p>
                        <?php endif;?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" name="pass">
                        </div>
                        <button type="submit" class="btnorange">Войти</button>
                    </form><br>
                    <a href="register.php" class="orange">Регистрация</a> &nbsp;&nbsp;| &nbsp;&nbsp;
                    <a href="remember-password.php" class="orange">Восстановить пароль</a>
                </div>
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