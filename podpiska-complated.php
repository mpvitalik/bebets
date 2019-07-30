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

$id = isset($_GET['id'])? intval($_GET['id']) : 0;
$email  = isset($_GET['email'])? htmlspecialchars($_GET['email']) : false;
if($id!=0 && $email!=false){
    $success_podtversdenie = $db->makePublicPodpiska($id,$email);
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
                <h2>Вы подписались на рассылку прогнозов!</h2>
            <?php else:?>
                <h2>Подписка не оформлена! Попробуйте еще раз!</h2>
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