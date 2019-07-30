<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false){
    header("Location:index.php");die();
}

require_once "../php/Database.php";
$db = new Database();

$page = isset($_GET['p'])? intval($_GET['p']) : 1;


$posts = $db->getAllUsersPrognoziAdmin($page);

$pages_result = $db->pagesResultUsersPrognozi();
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
<?php require_once "navbar.php";?>

<div class="container">

    <br><br>
    <h1>Чат
    </h1>

    <br>
    <p><a class="copysomeitems">Копировать</a> | <a class="deletesomeitems">Удалить</a> |
        <a class="otmetitvse">Отметить все</a> | <a class="ubratvidelenie">Убрать выделенные</a></p>
    <br>
    <table class="table" >
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>Пользователь</th>
            <th>Чемпионат</th>
            <th>Время</th>
            <th>Команды</th>
            <th>Прогноз</th>
            <th>Коеф.</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($posts as $post):?>
            <tr>
                <td><input type="checkbox" class="checkprognoz" id="<?=$post->getId()?>"></td>
                <td><?=$post->getId();?></td>
                <td><?=$post->getName()?></td>
                <td><?=$post->getChampionat()?></td>
                <td><?=$post->getTimeChampionat()?></td>
                <td><?=$post->getComandi()?></td>
                <td><?=$post->getPrognoz()?></td>
                <td><?=$post->getKoeficient()?></td>
                <td>
                    <a href="changechat.php?id=<?=$post->getId();?>">Изменить</a> <br>
                    <a href="deletechat.php?id=<?=$post->getId();?>">Удалить</a><br>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="border-top: 1px dashed grey;padding:10px;">
        <?php if($pages != 0):?>
            <?php if($page!=1):?>
                <a href="chat.php?p=<?=$page-1;?>">назад</a>
            <?php endif;?>
            <?=$page;?> из <?=$pages;?>
            <?php if($page!=$pages):?>
                <a href="chat.php?p=<?=$page+1;?>">вперед</a>
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

$(".copysomeitems").click(function(){
    var copylist = [];
    $('.checkprognoz').each(function () {
        if($(this).prop('checked')==true){
            copylist.push($(this).attr('id'));
        }
    });
    var copylist_json = JSON.stringify(copylist);
    $.post('someitems.php',{ids:copylist_json,action:"copy",type:"chat"},function(data){
        if(data=="ok"){
            window.location.href = "chat.php";
        }
    });
});

$(".deletesomeitems").click(function(){
    var deletelist = [];
    $('.checkprognoz').each(function () {
        if($(this).prop('checked')==true){
            deletelist.push($(this).attr('id'));
        }
    });
    var deletelist_json = JSON.stringify(deletelist);
    $.post('someitems.php',{ids:deletelist_json,action:"delete",type:"chat"},function(data){
        if(data=="ok"){
            window.location.href = "chat.php";
        }
    });
});

</script>

</body>

</html>