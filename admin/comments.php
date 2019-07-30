<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$id = isset($_GET['id']) ? intval($_GET['id']) : die("Error post");


$post = $db->getPostById($id);
$comments = $db->getCommentsByIdPost($id);


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
    <h1><?=$post->getNazva()?> <small>(Комментарии)</small></h1>


    <table class="table" style="margin-top:50px;">
        <thead>
        <tr>
            <th>Комментарий</th>
            <th>Логин</th>
            <th>Email</th>
            <th>Дата</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($comments as $comment):?>
            <?php $user_comment = $db->getUserById($comment->getUserId());?>
            <tr>
                <td><?=$comment->getText();?></td>
                <td><?=$user_comment->getLogin();?></td>
                <td><?=$user_comment->getEmail();?></td>
                <td><?=$comment->getDatee();?></td>
                <td>
                    <a href="deletecomment.php?post_id=<?=$post->getId()?>&comment_id=<?=$comment->getId();?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>


</div>


</body>

</html>