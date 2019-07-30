<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}


require_once "../php/Database.php";
$db = new Database();

if(isset($_GET['num'])){
    $type = isset($_GET['type'])? $_GET['type'] : die("Error,go back!");
    $id = isset($_GET['id'])? $_GET['id'] : die("Error,go back!");
    $num = intval($_GET['num']);
    $db->updatePopular($num,$id,$type);
    header("Location:posts.php?type=".$type);

}else{
    $type = isset($_GET['type'])? $_GET['type'] : die("Error,go back!");
    $id = isset($_GET['id'])? $_GET['id'] : die("Error,go back!");

    $post = $db->getPostById($id);
    $nazvacat = $db->getCategoryByEng($type);
}




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
        <div class="col-md-5">
            <h1><?=$nazvacat->getNazva()?> <small>популярное</small></h1>
            <h2><?=$post->getNazva()?></h2>
            <img src="../<?=$post->getImg()?>" style="width: 100px;">
        </div>
        <div class="col-md-5">
            <div style="padding-top: 50px;">

                    <h3><a href="makepopular.php?id=<?=$id?>&type=<?=$type?>&num=1">1. Первый</a></h3>
                    <h3><a href="makepopular.php?id=<?=$id?>&type=<?=$type?>&num=2">2. Второй</a></h3>
                    <h3><a href="makepopular.php?id=<?=$id?>&type=<?=$type?>&num=3">3. Третий</a></h3>
                    <h3><a href="mainpost.php?id=<?=$id?>&type=<?=$type?>&action=update">Закрепить главным</a></h3>
            </div>
        </div>
    </div>







</div>


</body>

</html>