<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";

$db = new Database();

$posts = $db->getMainPostsAdmin();


?>

<!doctype html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
</head>
<body>
<?php require_once "navbar.php";?>

<div class="container">

    <br><br>
    <div class="row">
        <div class="col-md-12">
            <?php if(count($posts)==0):?>
                <h1>Нету главной новости</h1>
            <?php else:?>
                <h1>Главная новость:</h1><br><br>
            <?php endif;?>


            <?php foreach ($posts as $post):?>

                <h3 style="padding-left:10px;">
                    <?php if($post->getImg()!=""):?>
                        <img src="../<?=$post->getImg()?>" style="width: 100px;">
                    <?php endif;?>
                    <a href="changepost.php?id=<?=$post->getId()?>" style="color:black;"><?=$post->getNazva()?></a>
                    <a href="mainpost.php?id=<?=$post->getId()?>&action=delete" style="padding-left:10px;font-size:20px;">Убрать из главной</a>
                </h3>

            <?php endforeach;?>
        </div>
    </div>







</div>


</body>

</html>
