<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();
$page = isset($_GET['p'])? intval($_GET['p']) : 1;

$comments = $db->getAllCommentsPrognozAdmin($page);
$pages_result = $db->pagesResultCommentsPrognoz();
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
    <style>
        a{cursor:pointer;}
    </style>
</head>
<body>
<?php require_once "navbar.php";?></nav>

<div class="container">


    <h1>Комментарии к прогнозам</h1>
    <br>
    <p><a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные</a></p>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Комментарий</th>
            <th>Пользователь</th>
            <th>Страница</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($comments as $comment):?>
            <?php
                $comment_user = $db->getUserById($comment->getIdUser());
                $comment_prognoz = $db->getPrognozById($comment->getIdPrognoz())
            ?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$comment->getId()?>"></td>
                <td><?=$comment->getId();?></td>
                <td><?=$comment->getText()?></td>
                <td><?=$comment_user->getLogin()?></td>
                <td><a href="../<?=$comment_prognoz->getSsilka()?>.html"><?=$comment_prognoz->getNazva()?></a></td>
                <td>
                    <a href="deletecommentprognoz.php?id=<?=$comment->getId();?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="commentsprognoz.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="commentsprognoz.php?p=<?=$page+1;?>">вперед</a>
            <?php endif;?>
        <?php endif;?>
    </div>


</div>

<script>

    $(".otmetitvse").click(function(){
        $('.checkprognoz').prop("checked", true);
    });

    $(".ubratvidelenie").click(function(){
        $('.checkprognoz').prop("checked", false);
    });


    $(".deletesomeitems").click(function(){
        var deletelist = [];
        $('.checkprognoz').each(function () {
            if($(this).prop('checked')==true){
                deletelist.push($(this).attr('id'));
            }
        });
        var deletelist_json = JSON.stringify(deletelist);
        $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"prognozcomments"},function(data){
            if(data=="ok"){
                window.location.href = "commentsprognoz.php";
            }
        });
    });



</script>
</body>

</html>