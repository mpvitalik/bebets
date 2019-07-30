<?php
header('Powered: test');
header('Content-Type: text/html; charset=utf-8');
session_start();

$nav = "register";
require_once "php/Database.php";
$db = new Database();


$user_session = isset($_COOKIE['user_session'])? htmlspecialchars($_COOKIE['user_session']) : false;
$user = $db->loginUserWithCookie($user_session);
if($user->getId()>0){
    header("Location:index.php");
    die();
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $login = isset($_POST['login'])? htmlspecialchars($_POST['login']) : "";
    $email = isset($_POST['email'])? htmlspecialchars($_POST['email']) : "";
    $pass = isset($_POST['pass'])? htmlspecialchars($_POST['pass']) : "";
    $error_mess = $db->checkRegister($login,$email,$pass);
    if($error_mess['error']=="false"){
        $user_id = $db->registerNewUser($login,$email,$pass);

        //$user_session = $db->insertUserToUserSession($user_id);
        header("Location:podtverditemail.php");
    }

}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Регистрация - Bebets.ru</title>
    <?php require_once "head.php";?>
</head>
<body>

<?php require_once "header.php";?>

<div class="container whitecontainer">
    <?php require_once "left_right_images.php";?>
    <div class="row">
        <div class="col-md-9">

            <div class="col-md-10 col-md-offset-1">
                <h1>Регистрация</h1>
                <div class="bgform">
                    <br>
                    <form class="pdsideform" method="post" action="<?=basename(__FILE__)?>">
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
                            <input type="text" class="form-control" placeholder="Логин" name="login" value="<?php if(isset($login)) echo $login;?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" name="email" value="<?php if(isset($email)) echo $email;?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" name="pass">
                        </div>
                        <button type="submit" class="btnorange">Зарегистрироваться</button>
                    </form><br>
                    <a href="enter.php" class="orange">Вход</a> &nbsp;&nbsp;| &nbsp;&nbsp;
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