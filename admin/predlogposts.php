<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$predlogposts = $db->getPredlogPostsAdmin($page);
$pages_result = $db->pagesResultPredlogPosts();
$pages = ceil($pages_result/40);

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
<?php require_once "navbar.php";?></nav>

<div class="container">
    <br><br>
    <h1>Предлагаемые посты</h1>


    <table class="table" style="margin-top:50px;">
        <thead>
        <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Пользователь</th>
            <th>Дата</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($predlogposts as $predlogpost):?>
            <?php $predlogpost_user = $db->getUserById($predlogpost->getUserId());?>
            <tr>
                <td><a href="predlogpost.php?id=<?=$predlogpost->getId()?>"><?=$predlogpost->getNazva();?></a></td>
                <td>
                    <?php if($predlogpost->getCat()=="news"):?>
                        <span>Новости</span>
                    <?php elseif ($predlogpost->getCat()=="video"):?>
                        <span>Видео</span>
                    <?php elseif ($predlogpost->getCat()=="photos"):?>
                        <span>Фото</span>
                    <?php elseif ($predlogpost->getCat()=="gifki"):?>
                        <span>Гифки</span>
                    <?php endif;?>
                </td>
                <td>
                    Логин: <?=$predlogpost_user->getLogin();?><br>
                    Email: <?=$predlogpost_user->getEmail();?>
                </td>
                <td><?=$predlogpost->getDate();?></td>
                <td>
                    <?php if($predlogpost->getStatus()=="rassmotr"):?>
                        <span>Новый</span>
                    <?php elseif ($predlogpost->getStatus()=="public"):?>
                        <span style="color:green;">Опубликован</span>
                    <?php elseif ($predlogpost->getStatus()=="otklon"):?>
                        <span style="color:red;">Отклонен</span>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="predlogposts.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="predlogposts.php?p=<?=$page+1;?>">вперед</a>
            <?php endif;?>
        <?php endif;?>
    </div>


</div>


</body>

</html>